<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display the company page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $company = null;
        $user = auth()->user();

        if ($user->isOwnerOfAnyCompany()) {
            $company = $user->companies->first();
            return view('users.company.edit', compact('company'));
        }

        return view('users.company');
    }

    /**
     * Update the company details of the given id.
     *
     * @param  integer  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \illuminate\Http\RedirectResponse
     */
    public function updateCompany($id, CompanyRequest $request)
    {
        $user = auth()->user();

        $company = $user->companies()->find($id);
        if (!$company) {
            return back()->with("errorMessage", "Company with the given id not found.");
        }

        if (!$user->isOwnerOfAnyCompany($company)) {
            return back()->with("errorMessage", "You don't have permissions to update the company details.");
        }

        $company->update($request->all());
        return back()->with('successMessage', 'Company details updated successfully.');
    }
}
