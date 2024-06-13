<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\User;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Validator;
use App\Jobs\RenewSubscriptionJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        /** @var \App\Models\User $subscriber **/
        $subscriber = Auth::user();
        $subscriptionsQuery = $subscriber->subscriptions()->with(['subscribedUser:id,name,avatar']);

        if ($filter !== 'all') {
            $subscriptionsQuery->where('end_at', $filter === 'active' ? '>' : '<=', now());
        }
        $subscriptionsQuery->orderBy('started_at', 'desc');
        $subscriptions = $subscriptionsQuery->paginate(5);

        return view('subscriptions.index', compact('subscriptions', 'filter'));
    }

    public function buyView(User $user)
    {
        $subscriber = Auth::user();
        if ($subscriber->id == $user->id) {
            abort(403);
        }

        /** @var \App\Models\User $subscriber **/
        $subscriber = Auth::user();
        $rank = $subscriber->getRank();

        return view('subscriptions.buy', compact('user', 'rank'));
    }

    public function store(Request $request, User $user)
    {
        /** @var \App\Models\User $subscriber **/
        $subscriber = Auth::user();
        if ($subscriber->id == $user->id) {
            abort(403);
        }

        $request->validate([
            'cc-name' => 'required|string|max:255',
            'cc-number' => 'required|digits:16',
            'cc-expiration' => 'required|date_format:m/y',
            'cc-cvv' => 'required|digits:3',
            'length' => 'required|numeric|min:1'
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            PaymentIntent::create([
                'amount' => 200,
                'currency' => 'pln',
                'payment_method' => 'pm_card_visa',
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ]
            ]);
            $length = (int) $request->input('length');
            $price = env('SUBSCRIPTION_MONTH_PRICE') * $length;

            $discount = $subscriber->getRank()->getSubscriptionDiscount();
            if ($discount > 0) {
                $discountedPrice = $price - ($price * ($discount / 100));
                $price = $discountedPrice;
            }

            $subscription = $subscriber->getSubscriptionForUser($user->id);
            if ($subscription) {
                $endDateTime = Carbon::parse($subscription->end_at);
                $endDateTime->addMonth($length);

                $subscription->end_at = $endDateTime->toDateTime();
                $subscription->price = $price;
                $subscription->show_notification = true;
                $subscription->update();

                $toastMessage = 'Przedłużyłeś subskrypcję dla użytkownika <strong>' . $user->name . '</strong>!<br><br>Nowa data ważności: ';
            } else {
                $endDateTime = Carbon::now()->addMonth($length);
                // $endDateTime = Carbon::now()->addSecond(10);

                $subscription = $subscriber->subscriptions()->create([
                    'subscribed_user_id' => $user->id,
                    'started_at' => now(),
                    'end_at' => $endDateTime->toDateTime(),
                    'price' => $price,
                    // 'auto_renew' => 1,
                ]);

                $toastMessage = 'Kupiłeś subskrypcję dla użytkownika <strong>' . $user->name . '</strong>!<br><br>Data ważności: ';
            }
            $toastMessage .= $endDateTime->translatedFormat('d F Y, H:i') . '<br>Cena subskrypcji: <strong>' . $price . 'zł</strong>';

            $diffInSeconds = now()->diffInSeconds($endDateTime);
            $job = (new RenewSubscriptionJob($subscription))->delay(now()->addSeconds($diffInSeconds));
            $jobId = dispatchId($job);

            $oldJobId = $subscription->job_id;
            $subscription->job_id = $jobId;
            $subscription->update();

            if ($oldJobId) {
                DB::table('jobs')->where('id', $oldJobId)->delete();
            }

            return to_route('profile', $user)->with('successToast', Markdown::parse($toastMessage));
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('paymentError', $e->getMessage());
        }
    }

    public function switchAutoRenew(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subscription_id' => 'required|integer|exists:subscriptions,id',
            'auto_renew' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $subscription = Subscription::findOrFail($request->input('subscription_id'));

        if (!$user || $subscription->subscriber_user_id != $user->id || !$user->getRank()->canAutoRenewSubscription()) {
            return response()->json(null, 403);
        }

        $subscription->auto_renew = $request->input('auto_renew');
        if ($subscription->save()) {
            return response()->json();
        } else {
            return response()->json(['errors' => ['save' => 'Nie udało się zapisać zmian w subskrypcji.']], 500);
        }
    }
}
