<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

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
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email:filter|exists:users,email',
        ]);

        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(64),
            'created_at' => now(),
        ]);

        $record = \DB::table('password_resets')->where('email', $request->email)->first();

        Mail::to($request->email)
            ->send(new ResetPasswordLink($record));

        session()->flash('successMessage', "Password reset link email sent successfully.");

        return back()->withInput();
    }
}
