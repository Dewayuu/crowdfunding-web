<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignImage extends Model
{
    use HasFactory;

    protected $table = 'tb_campaign_images';
    protected $primaryKey = 'image_id';
    
    public $timestamps = false; // Hanya menggunakan created_at default timestamp

    protected $fillable = [
        'campaign_id',
        'image',
        'caption',
        'is_primary',
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