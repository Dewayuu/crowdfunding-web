<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRefund extends Model
{
    use HasFactory;

    protected $table = 'tb_donation_refunds';
    protected $primaryKey = 'refund_id';

    protected $fillable = [
        'donation_id',
        'user_bank_account_id',
        'refund_status',
        'transfer_proof',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id', 'donation_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(UserBankAccount::class, 'user_bank_account_id', 'user_id');
    }

    public function campaign()
    {
        return $this->hasOneThrough(Campaign::class, Donation::class, 'donation_id', 'campaign_id', 'donation_id', 'campaign_id');
    }
}