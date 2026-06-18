<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil ID User Biasa yang sudah kita buat di UserSeeder sebagai Owner
        $owners = DB::table('tb_users')
            ->where('role', 'user')
            ->get();

        // 2. Buat Kategori Contoh (Pendidikan) di tb_campaign_categories
        $category = DB::table('tb_campaign_categories')
            ->where('slug', 'pendidikan')
            ->first();

        if (!$category) {
            $categoryId = DB::table('tb_campaign_categories')->insertGetId([
                'category_name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'category_icon' => 'fa-graduation-cap',
                'is_active' => 'yes',
                'created_at' => now(),
            ]);
        } else {
            $categoryId = $category->category_id;
        }

        // 3. Buat Data Campaign Utama dengan Status PENDING sesuai PDM image_fa9e82.jpg
        $campaignTitles = [
        'individual' => 'Beasiswa Pendidikan Anak Yatim Piatu',
        'foundation' => 'Renovasi Gedung Yayasan',
        'corporate' => 'Program CSR Laptop Untuk Pelajar',
        'community' => 'Gerakan Literasi Desa'
    ];

    foreach ($owners as $owner) {

        $campaignId = DB::table('tb_campaigns')->insertGetId([
            'user_id' => $owner->user_id,
            'category_id' => $categoryId,
            'title' => $campaignTitles[$owner->entity_type],
            'slug' => \Illuminate\Support\Str::slug($campaignTitles[$owner->entity_type]),
            'short_description' => 'Campaign testing untuk verifikasi admin.',
            'story' => 'Ini adalah campaign dummy untuk pengujian fitur verifikasi campaign.',
            'target_amount' => 25000000,
            'current_amount' => 0,
            'end_date' => now()->addDays(30),

            // SEMUA PENDING
            'verification_status' => 'pending',

            'campaign_status' => 'active',
            'disbursement_status' => 'not_started',
            'admin_notes' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tb_campaign_images')->insert([
            'campaign_id' => $campaignId,
            'image' => 'campaign/login-bg.jpg',
            'caption' => 'Dokumentasi campaign',
            'is_primary' => 'yes',
            'created_at' => now(),
        ]);

        DB::table('tb_campaign_beneficiaries')->insert([
            'campaign_id' => $campaignId,
            'beneficiary_type' => 'community',
            'name' => 'Penerima Manfaat Demo',
            'identity_number' => 'REG-' . rand(100000, 999999),
            'contact_number' => '081234567890',
            'address' => 'Alamat penerima manfaat',
            'description' => 'Data dummy beneficiary',
            'document_path' => 'campaign/login-bg.pdf',
            'created_at' => now(),
        ]);
    }
    }
}