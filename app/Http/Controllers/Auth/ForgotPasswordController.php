<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Mail\ResetPasswordLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Display the forgot password page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send the reset password link email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['successMessage' => "Password reset link email sent successfully."])
                    : back()->withErrors(['errorMessage' => "Please verify Email First.."]);
    }
}
