<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignDisbursement extends Model
{
    use HasFactory;

    protected $table = 'tb_campaign_disbursement';
    protected $primaryKey = 'disbursement_id';

    protected $fillable = [
        'campaign_id',
        'user_bank_account_id',
        'amount_requested',
        'purpose',
        'disbursement_status',
        'transfer_proof',
        'rejection_reason',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'campaign_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(UserBankAccount::class, 'user_bank_account_id', 'user_bank_account_id');
    }
}