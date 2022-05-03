<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VerifyEmailAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /**
     * Display the login page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Validate the credentials and login the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function check(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email:filter|exists:users,email',
            'password' => 'required',
        ]);

        if (auth()->attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();

            return redirect(route('users.dashboard'));
        }

        session()->flash('couldNotLogin', "Invalid Credentials provided.");

        return back()->withInput();
    }
}
