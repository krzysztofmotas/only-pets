<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function buyView(User $user)
    {
        return view('subscriptions.buy', compact('user'));
    }

    public function manageView(Subscription $subscription)
    {
        return view('subscriptions.manage', compact('subscription'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'cc-name' => 'required|string|max:255',
            'cc-number' => 'required|digits:16',
            'cc-expiration' => 'required|date_format:m/y',
            'cc-cvv' => 'required|digits:3'
        ]);
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
