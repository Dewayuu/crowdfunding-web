<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'tb_donations';

    protected $primaryKey = 'donation_id';

    protected $fillable = [
        'campaign_id',
        'user_id',
        'donor_name',
        'amount',
        'payment_method',
        'payment_status'
    ];

    public function campaign()
    {
        return $this->belongsTo(
            Campaign::class,
            'campaign_id',
            'campaign_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    public function refund()
    {
        return $this->hasOne(
            DonationRefund::class,
            'donation_id',
            'donation_id'
        );
    }
}