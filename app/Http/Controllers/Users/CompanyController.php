<?php

namespace App\Http\Controllers\Users;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;

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

        try {
            $company = Company::create($request->all());

            $company->users()->attach(auth()->id(), ['access_level' => Company::ACCESS_OWNER]);

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET', null));
            $customer = $stripe->customers->create([
                'email' => auth()->user()->email,
                'name' => auth()->user()->getFullName(),
                'address' => [
                    'line1' => $company->address1 . ' ' . $company->address2,
                    'postal_code' => $company->zip,
                    'city' => $company->city,
                    'state' => $company->state,
                    'country' => $company->country,
                ],
            ]);

            auth()->user()->update([
                'stripe_customer_id' => $customer->id,
            ]);

            return back()->with('successMessage', "Company created successfully.");
        } catch (\Exception $e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            return back();
        }
    }

    /**
     * Update the company details of the given id.
     *
     * @param  integer  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \illuminate\Http\RedirectResponse
     */
    public function update($id, CompanyRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();

        $company = $user->companies()->find($id);
        if (! $company) {
            return back()->with("errorMessage", "Company with the given id not found.");
        }

        if (! $user->isOwnerOfAnyCompany($company)) {
            return back()->with("errorMessage", "You don't have permissions to update the company details.");
        }

        $company->update($request->all());
        return back()->with('successMessage', 'Company details updated successfully.');
    }
}
