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

class SubscriptionController extends Controller
{
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

            $now = Carbon::now();
            $endDate = $now->copy()->addMonth($length);

            $existingSubscription = $subscriber->getSubscriptionForUser($user->id);
            if ($existingSubscription) {
                $existingEndDate = Carbon::parse($existingSubscription->end_at);

                if ($existingEndDate->isFuture()) {
                    $remainingSeconds = $now->diffInSeconds($existingEndDate);
                    $endDate->addSeconds($remainingSeconds);
                }

                $existingSubscription->is_active = false;
                $existingSubscription->update();
            }

            Subscription::create([
                'subscriber_user_id' => $subscriber->id,
                'subscribed_user_id' => $user->id,
                'started_at' => now(),
                'end_at' => $endDate->toDateTime(),
                'price' => env('SUBSCRIPTION_MONTH_PRICE') * $length,
            ]);

            return redirect()->route('subscriptions.buy.success');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('paymentError', $e->getMessage());
        }
    }

    public function success()
    {
        return view('subscriptions.success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
