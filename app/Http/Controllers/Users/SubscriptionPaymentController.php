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
            $company = $user->companies()->first();

            $customer = $stripe->customers->create([
                'email' => $user->email,
                'name' => $user->getFullName(),
                'address' => [
                    'line1' => $company->address1 . ' ' . $company->address2,
                    'postal_code' => $company->zip,
                    'city' => $company->city,
                    'state' => $company->state,
                    'country' => $company->country,
                ],
                'source' => request()->stripeToken,
            ]);

            $response = $stripe->subscriptions->create([
                'customer' => $customer->id,
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

            dd($captureResponse);

            /*$response = $stripe->paymentIntents->create([
                "amount" => $price->unit_amount,
                "currency" => $price->currency,
                'customer' => $customer->id,
                "description" => "Making a subscription payment for {$product->name}",
                "capture_method" => "automatic",
                "confirm" => true,
                "confirmation_method" => "automatic",
                "payment_method_types" => ['card'],
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'token' => request()->stripeToken
                    ]
                ]
            ]);

            $captureResponse = $stripe->paymentIntents->confirm(
                $response->id, ['return_url' => route('users.subscription.success')]
            );

            if ($captureResponse->status === 'requires_action') {
                return redirect($captureResponse->next_action->redirect_to_url->url);
            }*/
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
}
