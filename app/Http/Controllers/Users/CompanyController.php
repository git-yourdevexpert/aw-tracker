<?php

namespace App\Http\Controllers\Users;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * Store the company details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\redirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'address1' => 'required|max:255',
            'address2' => 'nullable|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:3',
            'zip' => 'required|string|max:9',
            'country' => 'required|string|max:255',
        ]);

        $company = Company::create($request->all());

        $company->users()->attach(auth()->id(), ['access_level' => Company::ACCESS_OWNER]);

        session()->flash('successMessage', "Company created successfully.");

        return back();
    }

    /**
     * Update the company details of the given id.
     *
     * @param  integer  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'address1' => 'required|max:255',
            'address2' => 'nullable|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:3',
            'zip' => 'required|string|max:9',
            'country' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $company = $user->companies()->find($id);
        if (! $company) {
            sessiopn()->flash("errorMessage", "Company with the given id not found.");
            return back();
        }

        if (! $user->isOwnerOfAnyCompany($company)) {
            session()->flash("errorMessage", "You don't have permissions to update the company details.");
            return back();
        }

        $company->update($request->all());

        session()->flash('successMessage', 'Company details updated successfully.');

        return back();
    }
}
