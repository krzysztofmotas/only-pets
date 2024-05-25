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

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

         /** @var \App\Models\User $subscriber **/
        $subscriber = Auth::user();
        $subscriptionsQuery = $subscriber->subscriptions()->with(['subscribedUser:id,name']);

        if ($filter !== 'all') {
            $subscriptionsQuery->where('is_active', $filter === 'active' ? true : false);
        }
        $subscriptions = $subscriptionsQuery->paginate(2);

        return view('subscriptions.index', compact('subscriptions', 'filter'));
    }

    public function buyView(User $user)
    {
        $subscriber = Auth::user();
        if ($subscriber->id == $user->id) {
            abort(403);
        }

        return view('subscriptions.buy', compact('user'));
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

            $isNewSubscription = false;

            $existingSubscription = $subscriber->getSubscriptionForUser($user->id);
            if ($existingSubscription) {
                $endDateTime = Carbon::parse($existingSubscription->end_at);
                $endDateTime->addMonth($length);

                $existingSubscription->end_at = $endDateTime->toDateTime();
                $existingSubscription->update();
            } else {
                $endDateTime = Carbon::now()->addMonth($length);

                $subscriber->subscriptions()->create([
                    'subscribed_user_id' => $user->id,
                    'started_at' => now(),
                    'end_at' => $endDateTime->toDateTime(),
                    'price' => env('SUBSCRIPTION_MONTH_PRICE') * $length,
                ]);

                $isNewSubscription = true;
            }

            return to_route('subscriptions.success');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('paymentError', $e->getMessage());
        }
    }

    public function successView()
    {
        return view('subscriptions.success');
    }
}
