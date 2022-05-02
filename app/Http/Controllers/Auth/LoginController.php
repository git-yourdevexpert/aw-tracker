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
}
