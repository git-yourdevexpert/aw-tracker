<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * Display the registration page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email:filter|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $request['c_time'] = now();
        $request['password'] = bcrypt($request->password);
        $request['verification_token'] = \Illuminate\Support\Str::random(32);
        $request['status'] = User::PENDING_VERIFICATION;
        User::create($request->all());

        session()->flash('successMessage', 'User registered successfully.');

        return redirect(url('/'));
    }
}