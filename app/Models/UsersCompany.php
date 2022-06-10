<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersCompany extends Model
{
    use HasFactory;
    protected $table = 'users_company';
    protected $fillable = [
        'user_id', 'company_id', 'access_level'
    ];
    public $timestamps = false;
}
