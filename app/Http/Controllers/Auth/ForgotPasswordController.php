<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ForgotPasswordRequest;

use App\Models\User;

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
        $validated = $request->validated();

        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(64),
            'created_at' => now(),
        ]);

        $record = \DB::table('password_resets')->where('email', $request->email)->first();
        $user = User::where('email',$request->email)->first();
        if($user->verification_token == null){
            Mail::to($request->email)
            ->send(new ResetPasswordLink($record));
            session()->flash('successMessage', "Password reset link email sent successfully.");
        }else{
            session()->flash('errorMessage', "Please verify Email First..");
        }

        return back()->withInput();
    }
}
