<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'contact_number',
        'bio',
        'profile_photo',
        'role',
        'account_status',
        'bank_name',
        'account_number',
        'account_holder',
        'account_type',
        'bank_proof_path'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}