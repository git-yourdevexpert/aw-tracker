<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillingInfoRegistrationRequest;
use App\Http\Requests\CompanyRegistrationRequest;
use App\Http\Requests\ManageSiteRequest;
use App\Http\Requests\RegistrationRequest;
use App\Mail\VerifyEmailAddress;
use App\Models\Company;
use App\Models\Site;
use App\Models\User;
use App\Models\UsersCompany;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Uuid;
use Laravel\Cashier\Cashier;
use DB;

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
    public function store(RegistrationRequest $request)
    {
        $data = [
            'c_time' =>  now(),
            'password' => Hash::make($request->password),
            'verification_token' => \Illuminate\Support\Str::random(32),
            'status' => config('constants.PENDING_VERIFICATION'),
        ];
        $user = User::create(array_merge($request->all(),$data));
        Mail::to($user->email, $user->full_name)
            ->send(new VerifyEmailAddress($user));
        return redirect()->route('register')->with('successMessage', 'Please Check Your Mail and Verify Your Account.');
    }

    public function storeCompany(CompanyRegistrationRequest $request)
    {
        $company = Company::create($request->all());
        $usersCompany = UsersCompany::create([
            'user_id' => $request->id,
            'company_id' => $company->id,
        ]);
        $user = User::where('id', $usersCompany->user_id)->first();
        $intent = $user->createSetupIntent();
        $product_id = $request->product_id;
        return view('auth.billingInfo', compact('company', 'product_id', 'intent', 'user'));
    }
    public function registerBilling($id, BillingInfoRegistrationRequest $request)
    {
        DB::beginTransaction();
        try {
            $company = Company::find($id);
            $usersCompany = UsersCompany::where('company_id', $company->id)->first();
            $user = User::where('id', $usersCompany->user_id)->first();
            $company->update($request->all());

            $company->users()->attach($user->id, ['access_level' => config('constants.ACCESS_OWNER')]);

            //create customer on stripe
            $customer = $user->createAsStripeCustomer([
                'email' => $user->email,
                'name' => $user->full_name,
                'address' => [
                    'line1' => $company->address1 . ' ' . $company->address2,
                    'postal_code' => $company->zip,
                    'city' => $company->city,
                    'state' => $company->state,
                    'country' => $company->country,
                ],
            ]);
            $user1 = User::find($usersCompany->user_id);
            $updateUser = $user1->update([
                'stripe_customer_id' => $customer->id,
            ]);
            //create card on stripe
            $paymentMethod = null;
            $paymentMethod = $request->payment_method;
            if ($paymentMethod != null) {
                $paymentMethod = $user->addPaymentMethod($paymentMethod);
            }
            $company = $user->companies()->first();
            $company->update(['stripe_token' => $paymentMethod->id]);

            //create subscription on stripe
            $stripe = Cashier::stripe();
            $product = $stripe->products->retrieve($request->product_id);
            $price = $stripe->prices->retrieve($product->default_price);
            $subscription = $user->newSubscription($product->id, $price->id)
                ->create($paymentMethod != null ? $paymentMethod->id : '');
            $invoice = $user->subscription($product->id)->upcomingInvoice();
            DB::commit();
            return view('auth.manageSites', compact('user', 'company'))->with('successMessage', "Your Account Sign up Sucessfully.");
        } catch (\Exception$e) {
            info($e->getMessage());
            info($e->getTraceAsString());
            DB::rollback();
            return redirect()->back()->with('errorMessage', 'Something went Wrong');
        }
    }

    public function siteStore(ManageSiteRequest $request)
    {
        $token = Uuid::generate()->string;

        $site = new Site();
        $site->company_id = $request->company_id;
        $site->user_id = $request->user_id;
        $site->token = $token;
        $site->domain = $request->domain;
        $site->save();
        if ($site) {
            Auth::loginUsingId($request->user_id);
        }
        return view('users.dashboard', compact('site'));
    }
}
