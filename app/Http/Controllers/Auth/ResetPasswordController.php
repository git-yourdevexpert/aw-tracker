<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    /**
     * Display the reset password page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index($token)
    {
        $record = \DB::table('password_resets')->where('token', $token)->first();
        if (! $record) {
            abort(404);
        }

        return view('auth.reset-password', compact('record'));
    }

    /**
     * Update the user's password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required',
            'repeat_new_password' => 'required|same:new_password',
        ]);

        $record = \DB::table('password_resets')
                    ->where('token', $request->reset_token)
                    ->first();
        if (! $record) {
            return back()->with('errorMessage', "Invalid password reset token provided.");
        }

        User::where('email', $record->email)->first()->update([
            'password' => bcrypt($request->new_password),
        ]);

        \DB::table('password_resets')->where('token', $request->reset_token)->delete();

        session()->flash('successMessage', "Password updated successfully.");

        return redirect(route('pages.login'));
    }
}
