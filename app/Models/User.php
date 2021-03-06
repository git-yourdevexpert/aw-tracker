<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, Billable;

    /**
     * The dates that will be mutated to Carbon instance.
     *
     * @var array
     */
    protected $dates = [
        'c_time', 'deleted_at',
    ];
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'email_verified_at', 'password', 'verification_token', 'status', 'c_time',
        'stripe_customer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the full name of the user.
     *
     * @return string
     */

    protected $appends = ['full_name'];


    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * A user can be a part of multiple companies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'users_company')->withPivot('access_level');
    }

    /**
     * Check if the authenticated user is an owner of given company.
     *
     * @param  \App\Models\Company  $company
     * @return boolean
     */
    public function isOwnerOfAnyCompany($company = null)
    {
        if ($company == null) {
            $company = $this->companies()->first();
        }

        if (!$company) {
            return false;
        }

        $hasUser = $company->users()->find($this->id);
        if (!$hasUser) {
            return false;
        }

        if ($hasUser->pivot->access_level === config('constants.ACCESS_OWNER')) {
            return true;
        }

        return false;
    }
}
