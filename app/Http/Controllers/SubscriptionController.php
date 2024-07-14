<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class SubscriptionController extends Controller
{
    /**
     * Display the pricing table view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function pricing(): \Illuminate\Contracts\View\View
    {  
        $stripe = new \Stripe\StripeClient(Config::get('cashier.secret'));

        $prices = $stripe->prices->all(['active' => true]);

        return view('subscription.pricing')->with('prices', $prices);
    }

    /**
     * Do the redirection to Stripe checkout page
     *
     * @param Request $request
     * @return void
     */
    public function subscribe(Request $request)
    {
        return $request->user()
        ->newSubscription('default', $request->input('stripe_id'))
        ->allowPromotionCodes()
        ->checkout([
            'success_url' => route('subscription.confirmation'),
            'cancel_url' => route('subscription.pricing'),
        ]);
    }

    /**
     * Return the confirmation view after successful checkout
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function confirmation(Request $request): \Illuminate\Contracts\View\View
    {
        return view('subscription.confirmation');
    }

    /**
     * Do the cancelation of the user's subscription
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if(!$user->subscribed())
        {
            return back()->with('error', 'You don\'t have any subscription to cancel');
        }

        $user->subscription()->cancel();

        return back()->with('success', 'Subscription canceled successfuly');
    }
}
