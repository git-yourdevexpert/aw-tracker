<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VerifyEmailAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return [type]           [description]
     */
    public function check($token, Request $request)
    {
        $user = User::where('verification_token', $token)->first();
        if (! $user) {
            abort(404, "The given verification link is invalid.");
        }
        
        $user->update([
            'status' => User::VERFIFIED,
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);
        
        
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
        return view('auth.registerCompany', compact('user','allProducts'))->with('successMessage', 'User verified successfully.');
    }
}
