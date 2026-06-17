<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    // 1. Deklarasikan nama tabel kustom sesuai PDM kalian
    protected $table = 'tb_campaigns';

    // 2. Tentukan primary key tabel ini
    protected $primaryKey = 'campaign_id';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'short_description',
        'story',
        'target_amount',
        'current_amount',
        'end_date',
        'verification_status',
        'campaign_status',
        'disbursement_status',
        'admin_notes',
    ];

    /**
     * Mengatur casting tipe data agar otomatis dikonversi menjadi objek Carbon (Tanggal)
     */
    protected $casts = [
        'end_date' => 'datetime',
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    /**
     * 🔗 RELASI: Belongs To ke tabel induk tb_users (Pembuat Campaign)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * 🔗 RELASI: Belongs To ke tabel tb_campaign_categories
     */
    public function category()
    {
        return $this->belongsTo(CampaignCategory::class, 'category_id', 'category_id');
    }

    /**
     * 🔗 RELASI: Has Many ke tabel tb_campaign_images (Satu campaign bisa punya banyak foto)
     */
    public function images()
    {
        return $this->hasMany(CampaignImage::class, 'campaign_id', 'campaign_id');
    }

    /**
     * 🔗 RELASI: Has One ke tabel tb_campaign_beneficiaries (Penerima Manfaat)
     */
    public function beneficiary()
    {
        return $this->hasOne(CampaignBeneficiary::class, 'campaign_id', 'campaign_id');
    }
}