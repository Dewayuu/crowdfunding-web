<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdditionalCampaignSeeder extends Seeder
{
    public function run(): void
    {
        $campaigns = [
            [
                'owner_email' => 'maheswari@gmail.com',
                'owner_name' => 'Maheswari',
                'category_name' => 'Kesehatan',
                'category_slug' => 'kesehatan',
                'category_icon' => 'fa-heartbeat',
                'title' => 'Bantuan Biaya Operasi Anak Penderita Jantung',
                'short_description' => 'Bantu biaya operasi dan pemulihan anak penderita jantung agar dapat kembali beraktivitas.',
                'story' => 'Campaign ini dibuat untuk membantu biaya operasi, pemeriksaan lanjutan, obat-obatan, dan kebutuhan pemulihan anak penderita jantung. Bantuan dari donatur akan digunakan untuk mendukung proses pengobatan secara bertahap dan transparan.',
                'target_amount' => 35000000,
                'current_amount' => 3500000,
                'end_days' => 25,
                'beneficiary_type' => 'individual',
                'beneficiary_name' => 'Anak Penderita Jantung',
                'beneficiary_description' => 'Penerima manfaat membutuhkan bantuan biaya operasi dan perawatan medis lanjutan.',
                'image_caption' => 'Dokumentasi campaign kesehatan',
            ],
            [
                'owner_email' => 'riana11@gmail.com',
                'owner_name' => 'Riana',
                'category_name' => 'Bencana Alam',
                'category_slug' => 'bencana-alam',
                'category_icon' => 'fa-house-flood-water',
                'title' => 'Bantuan Darurat untuk Korban Banjir',
                'short_description' => 'Bantu penyediaan makanan, pakaian, obat-obatan, dan kebutuhan dasar bagi korban banjir.',
                'story' => 'Campaign ini ditujukan untuk membantu korban banjir yang membutuhkan kebutuhan dasar seperti makanan siap saji, air bersih, pakaian, perlengkapan tidur, dan obat-obatan. Dana yang terkumpul akan disalurkan secara bertahap kepada warga terdampak.',
                'target_amount' => 50000000,
                'current_amount' => 8000000,
                'end_days' => 20,
                'beneficiary_type' => 'community',
                'beneficiary_name' => 'Warga Terdampak Banjir',
                'beneficiary_description' => 'Penerima manfaat merupakan komunitas warga yang terdampak banjir dan membutuhkan bantuan darurat.',
                'image_caption' => 'Dokumentasi bantuan korban banjir',
            ],
            [
                'owner_email' => 'suryaA@gmail.com',
                'owner_name' => 'Surya Adi Putra',
                'category_name' => 'Sosial Kemanusiaan',
                'category_slug' => 'sosial-kemanusiaan',
                'category_icon' => 'fa-hand-holding-heart',
                'title' => 'Paket Sembako untuk Lansia Dhuafa',
                'short_description' => 'Bantu pengadaan paket sembako untuk lansia dhuafa yang membutuhkan dukungan kebutuhan harian.',
                'story' => 'Campaign ini bertujuan menyediakan paket sembako bagi lansia dhuafa yang memiliki keterbatasan ekonomi. Bantuan akan digunakan untuk membeli beras, minyak, telur, susu, dan kebutuhan pokok lain agar penerima manfaat dapat memenuhi kebutuhan harian dengan lebih layak.',
                'target_amount' => 20000000,
                'current_amount' => 2400000,
                'end_days' => 30,
                'beneficiary_type' => 'community',
                'beneficiary_name' => 'Lansia Dhuafa',
                'beneficiary_description' => 'Penerima manfaat merupakan lansia dhuafa yang membutuhkan dukungan kebutuhan pokok.',
                'image_caption' => 'Dokumentasi paket sembako',
            ],
        ];

        foreach ($campaigns as $item) {
            $owner = $this->findOwner($item['owner_email'], $item['owner_name']);

            if (!$owner) {
                $this->command?->warn("User {$item['owner_name']} tidak ditemukan. Campaign '{$item['title']}' dilewati.");
                continue;
            }

            $categoryId = $this->getOrCreateCategory(
                $item['category_name'],
                $item['category_slug'],
                $item['category_icon']
            );

            $baseSlug = Str::slug($item['title']);
            $slug = $baseSlug . '-' . $owner->user_id;

            $existingCampaign = DB::table('tb_campaigns')
                ->where('slug', $slug)
                ->first();

            if ($existingCampaign) {
                $campaignId = $existingCampaign->campaign_id;

                DB::table('tb_campaigns')
                    ->where('campaign_id', $campaignId)
                    ->update([
                        'user_id' => $owner->user_id,
                        'category_id' => $categoryId,
                        'title' => $item['title'],
                        'short_description' => $item['short_description'],
                        'story' => $item['story'],
                        'target_amount' => $item['target_amount'],
                        'current_amount' => $item['current_amount'],
                        'end_date' => now()->addDays($item['end_days']),
                        'verification_status' => 'pending',
                        'campaign_status' => 'active',
                        'disbursement_status' => 'not_started',
                        'admin_notes' => null,
                        'updated_at' => now(),
                    ]);
            } else {
                $campaignId = DB::table('tb_campaigns')->insertGetId([
                    'user_id' => $owner->user_id,
                    'category_id' => $categoryId,
                    'title' => $item['title'],
                    'slug' => $slug,
                    'short_description' => $item['short_description'],
                    'story' => $item['story'],
                    'target_amount' => $item['target_amount'],
                    'current_amount' => $item['current_amount'],
                    'end_date' => now()->addDays($item['end_days']),
                    'verification_status' => 'pending',
                    'campaign_status' => 'active',
                    'disbursement_status' => 'not_started',
                    'admin_notes' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('tb_campaign_images')->updateOrInsert(
                [
                    'campaign_id' => $campaignId,
                    'is_primary' => 'yes',
                ],
                [
                    'image' => 'campaign/login-bg.jpg',
                    'caption' => $item['image_caption'],
                    'created_at' => now(),
                ]
            );

            DB::table('tb_campaign_beneficiaries')->updateOrInsert(
                [
                    'campaign_id' => $campaignId,
                ],
                [
                    'beneficiary_type' => $item['beneficiary_type'],
                    'name' => $item['beneficiary_name'],
                    'identity_number' => 'REG-' . $campaignId . '-' . rand(1000, 9999),
                    'contact_number' => '081234567890',
                    'address' => 'Alamat penerima manfaat campaign',
                    'description' => $item['beneficiary_description'],
                    'document_path' => 'campaign/dokumen-pendukung.pdf',
                    'created_at' => now(),
                ]
            );

            $displayName = $owner->name
                ?? $owner->full_name
                ?? $owner->username
                ?? $owner->email
                ?? 'user';

            $this->command?->info("Campaign '{$item['title']}' berhasil dibuat/diupdate untuk user {$displayName}.");
        }
    }

    private function findOwner(string $email, string $name)
    {
        $owner = DB::table('tb_users')
            ->whereRaw('LOWER(email) = ?', [strtolower($email)])
            ->first();

        if ($owner) {
            return $owner;
        }

        if (Schema::hasColumn('tb_users', 'name')) {
            $owner = DB::table('tb_users')
                ->where('name', 'like', '%' . $name . '%')
                ->first();

            if ($owner) {
                return $owner;
            }
        }

        if (Schema::hasColumn('tb_users', 'full_name')) {
            $owner = DB::table('tb_users')
                ->where('full_name', 'like', '%' . $name . '%')
                ->first();

            if ($owner) {
                return $owner;
            }
        }

        if (Schema::hasColumn('tb_users', 'username')) {
            $owner = DB::table('tb_users')
                ->where('username', 'like', '%' . $name . '%')
                ->first();

            if ($owner) {
                return $owner;
            }
        }

        return null;
    }

    private function getOrCreateCategory(string $name, string $slug, string $icon): int
    {
        $category = DB::table('tb_campaign_categories')
            ->where('slug', $slug)
            ->first();

        if ($category) {
            return $category->category_id;
        }

        return DB::table('tb_campaign_categories')->insertGetId([
            'category_name' => $name,
            'slug' => $slug,
            'category_icon' => $icon,
            'is_active' => 'yes',
            'created_at' => now(),
        ]);
    }
}