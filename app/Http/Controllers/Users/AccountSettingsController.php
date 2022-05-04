<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AccountSettingsController extends Controller
{
    /**
     * Display the account settings page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = auth()->user();

        return view('users.account-settings.index', compact('user'));
    }

    /**
     * Update the general account settings of the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateGeneral(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email:filter|unique:users,email,'. auth()->id(),
        ]);

        auth()->user()->update($request->all());

        session()->flash('successMessage', "General settings updated successfully.");

        return back();
    }

    /**
     * Update the password of the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required',
            'repeat_new_password' => 'required|same:new_password',
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->update(['password' => bcrypt($request->new_password)]);

            session()->flash('successMessage', "Password changed successfully.");

            return back();
        }

        session()->flash('errorMessage', "Invalid current password provided.");

        return back();
    }
}
