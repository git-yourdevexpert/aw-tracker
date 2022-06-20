<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that will be mutated to Carbon instance.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at', 'c_time',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address1', 'address2', 'city', 'state', 'zip', 'country', 'stripe_token', 'status', 'c_time',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company';
    public $timestamps = false;
    /**
     * A company has many users attached to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_company')->withPivot('access_level');
    }

    /**
     * Check if the company is owned by the given user.
     *
     * @param  \App\Models\User  $user
     * @return boolean
     */
    public function isOwnedBy($user)
    {
        if (! $user) {
            return false;
        }

        $hasUser = $this->users()->find($user->id);
        if (! $hasUser) {
            return false;
        }

        if ($hasUser->pivot->access_level === static::ACCESS_OWNER) {
            return true;
        }

        return false;
    }
}
