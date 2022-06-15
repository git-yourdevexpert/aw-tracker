<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\GeneralSettingRequest;
use App\Http\Requests\ChangePasswordRequest;

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
        $paymentMethods = $user->paymentMethods();
        $deafultPaymentMethod = $user->defaultPaymentMethod();
        $default_card = $deafultPaymentMethod->id;
        $cards=[];
        foreach($paymentMethods as $key => $payment){
            $cards[$key] = ['card_id'=>$payment->id, 'card_last4'=>'XXXX-XXXX-XXXX-'.$payment->card->last4, 'card_exp_month'=>$payment->card->exp_month, 'card_exp_year'=>$payment->card->exp_year];
        }
        return view('users.account-settings.index', compact('user','cards','default_card'));
    }

    /**
     * Update the general account settings of the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateGeneral(GeneralSettingRequest $request)
    {
        $validated = $request->validated();

        auth()->user()->update($request->all());

        return back()->with('successMessage', "General settings updated successfully.");
    }

    /**
     * Update the password of the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->update(['password' => bcrypt($request->new_password)]);

            return back()->with('successMessage', "Password changed successfully.");
        }

        return back()->with('errorMessage', "Invalid current password provided.");
    }
    public function changeDefaultCard(Request $request){
        $user = auth()->user();
        $defaultCard = $user->updateDefaultPaymentMethod($request->card);
        return response()->json([
            'success' => true,
            'card' => $defaultCard,
            'message' => 'Default Card for Payment Set Successfully',
        ]);
    }
}
