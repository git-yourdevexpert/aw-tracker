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

        Company::create($request->all());

        session()->flash('successMessage', "Company created successfully.");

        return back();
    }
}
