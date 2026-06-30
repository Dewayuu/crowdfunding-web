<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\NotVisible; 
use Illuminate\Notifications\Notifiable;
use App\Models\UserDetailIndividual;
use App\Models\UserDetailCorporate;
use App\Models\UserDetailFoundation;
use App\Models\UserDetailCommunity;
use App\Models\UserBankAccount;
use App\Models\UserDocument;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_users';

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = [
    'email',
    'password',
    'contact_number',
    'username',
    'profile_photo',
    'bio',
    'role',
    'entity_type',
    'account_status',
];

    public function detailIndividual()
    {
        return $this->hasOne(UserDetailIndividual::class, 'user_id', 'user_id');
    }

    public function detailCorporate()
    {
        return $this->hasOne(
            UserDetailCorporate::class,
            'user_id',
            'user_id'
        );
    }

    public function detailFoundation()
    {
        return $this->hasOne(
            UserDetailFoundation::class,
            'user_id',
            'user_id'
        );
    }

    public function detailCommunity()
    {
        return $this->hasOne(
            UserDetailCommunity::class,
            'user_id',
            'user_id'
        );
    }

    public function bankAccount()
    {
        return $this->hasOne(
            UserBankAccount::class,
            'user_id',
            'user_id'
        );
    }

    public function documents()
    {
        return $this->hasMany(
            UserDocument::class,
            'user_id',
            'user_id'
        );
    }

    public function campaigns()
{
    return $this->hasMany(Campaign::class,'user_id','user_id');
}

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'password' => 'string',
    ];
}