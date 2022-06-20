<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('users.dashboard');
    }

    /**
     * Logout the currently authenticated user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->logout();

        request()->session()->regenerate();

        return redirect(route('login'));
    }
}
