<?php

namespace App\Http\Controllers\Users;

use Stripe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionPaymentController extends Controller
{
    /**
     * Display the select subscription page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET', null));
        $products = $stripe->products->all(['expand' => ['data.default_price']]);

        $allProducts = [];
        foreach ($products as $key => $product) {
            $allProducts[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price_id' => $product->default_price->id,
                'amount' => ($product->default_price->unit_amount / 100),
            ];
        }

        return view('users.subscription.select', compact('allProducts'));
    }

    /**
     * Create the subscription.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET', null));
        $product = $stripe->products->retrieve(request('product_id'));
        if (! $product || empty($product)) {
            return back();
        }

        $price = $stripe->prices->retrieve($product->default_price);
        if (! $price || empty($price)) {
            return back();
        }

        try {
            $user = auth()->user();

            $response = $stripe->subscriptions->create([
                'customer' => $user->stripe_customer_id,
                'items' => [
                    ['price' => $price->id,]
                ],
                'description' => "Making a subscription payment for {$product->name}",
                'billing_cycle_anchor' => today()->addMonth()->timestamp,
                'payment_settings' => [
                    'payment_method_types' => [
                        'card',
                    ]
                ]
            ]);

            $invoice = $stripe->invoices->retrieve($response->latest_invoice);
            $captureResponse = $stripe->paymentIntents->confirm(
                $invoice->payment_intent, ['return_url' => route('users.subscription.success')]
            );

            if ($captureResponse->status === 'requires_action') {
                return redirect($captureResponse->next_action->redirect_to_url->url);
            }

            return back();
        } catch (\Exception $e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            return back();
        }

        return back();
    }

    public function success()
    {
        dd(request()->all());
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
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET', null));
            $stripe->customers->update($user->stripe_customer_id, [
                'source' => $stripeToken,
            ]);

            $company->update(['stripe_token' => $stripeToken]);

            session()->flash('successMessage', 'Card details added successfully');

            return back();
        } catch (\Exception $e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            return back();
        }
    }
}
