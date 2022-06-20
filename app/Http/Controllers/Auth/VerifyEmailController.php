<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class VerifyEmailController extends Controller
{
    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return [type]           [description]
     */
    public function verifyEmail($token, Request $request)
    {
        $user = User::where('verification_token', $token)->first();
        if (!$user) {
            abort(404, "The given verification link is invalid.");
        }

        $user->update([
            'status' => config('constants.VERFIFIED'),
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);

        $stripe = Cashier::stripe();
        $allProducts = $stripe->products->all(['expand' => ['data.default_price']]);
        return view('auth.registerCompany', compact('user', 'allProducts'))->with('successMessage', 'User verified successfully.');
    }
}
