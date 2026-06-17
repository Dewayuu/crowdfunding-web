<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    use HasFactory;

    protected $table = 'tb_user_bank_accounts';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}