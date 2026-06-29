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
        'is_anonymous',
        'support_message',

        'amount',

        'midtrans_order_id',
        'midtrans_transaction_id',
        'snap_token',

        'payment_method',
        'payment_reference',
        'payment_payload',
        'payment_status',

        'paid_at',
        'expired_at',
        'payment_notified_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',

        'payment_payload' => 'array',

        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'payment_notified_at' => 'datetime',
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