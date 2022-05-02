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

        session()->flash('successMessage', 'User verified successfully.');

        return redirect(route('pages.login'));
    }
}
