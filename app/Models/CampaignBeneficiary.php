<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignBeneficiary extends Model
{
    use HasFactory;

    protected $table = 'tb_campaign_beneficiaries';
    protected $primaryKey = 'beneficiary_id';
    
    public $timestamps = false; // Hanya memiliki kolom created_at di PDM

    protected $fillable = [
        'campaign_id',
        'beneficiary_type',
        'name',
        'identity_number',
        'contact_number',
        'address',
        'description',
        'document_path',
        'created_at',
    ];

    /**
     * Relasi Balik ke Campaign induk
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'campaign_id');
    }
}