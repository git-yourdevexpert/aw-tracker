<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class SubscriptionPaymentController extends Controller
{
    /**
     * Display the select subscription page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $stripe = Cashier::stripe();
        $allProducts = $stripe->products->all(['expand' => ['data.default_price']]);

        return view('users.subscription.select', compact('allProducts'));
    }

    /**
     * Create the subscription.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        try {
            $stripe = Cashier::stripe();
            $product = $stripe->products->retrieve(request('product_id'));
            if (!$product || empty($product)) {
                return back()->with('errorMessage', 'Please Select Product Or Valid Product');
            }

            $price = $stripe->prices->retrieve($product->default_price);
            if (!$price || empty($price)) {
                return back()->with('errorMessage', 'Please Select Price Or Valid Price');
            }
            $user = auth()->user();

            $subscription = $user->newSubscription($product->id, $price->id)
                ->create();
            $invoice = $user->subscription($product->id)->upcomingInvoice();

            return redirect()->back()->with('successMessage', 'New Plan added successfully');
        } catch (\Exception$e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            return back()->with('errorMessage', 'Error to create new plan');
        }
    }

    public function success()
    {
        return view('users.subscription.success');
    }

    /**
     * Store the Credit Card details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCard(Request $request)
    {
        $user = auth()->user();
        $company = $user->companies()->first();

        $stripeToken = $request->stripeToken;

        try {
            $stripe = Cashier::stripe();
            $stripe->customers->update($user->stripe_id, [
                'source' => $stripeToken,
            ]);
            $company->update(['stripe_token' => $stripeToken]);
            return back()->with('successMessage', 'Card details added successfully');
        } catch (\Exception$e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            return back()->with('errorMessage', 'Error To add new card');
        }
    }
}
