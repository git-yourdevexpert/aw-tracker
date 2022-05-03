<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        return redirect(route('pages.login'));
    }
}
