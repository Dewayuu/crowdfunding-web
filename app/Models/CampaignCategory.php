<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignCategory extends Model
{
    use HasFactory;

    protected $table = 'tb_campaign_categories';
    protected $primaryKey = 'category_id';

    // Matikan timestamps karena di PDM tabel ini hanya memiliki kolom created_at (tanpa updated_at)
    public $timestamps = false;

    protected $fillable = [
        'category_name',
        'slug',
        'category_icon',
        'is_active',
        'created_at',
    ];

    /**
     * Relasi Has Many: Satu kategori bisa dimiliki oleh banyak campaign
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'category_id', 'category_id');
    }
}