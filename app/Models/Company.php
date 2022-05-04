<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    const NOT_VERFIFIED = '0';
    const VERFIFIED = '1';

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
}
