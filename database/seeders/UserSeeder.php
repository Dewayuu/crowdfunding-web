<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $individualId = DB::table('tb_users')->insertGetId([
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'contact_number' => '089876543210',
            'username' => 'test_user',
            'profile_photo' => null,
            'bio' => 'Saya adalah donatur aktif yang ingin berbagi kebaikan.',
            'role' => 'user',
            'entity_type' => 'individual',
            'account_status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tb_user_details_individual')->insert([
            'user_id' => $individualId,
            'full_name' => 'Test User',
            'national_id_number' => '3171010202020002',
            'birth_date' => '2001-05-12',
            'gender' => 'male',
        ]);

        $foundationId = DB::table('tb_users')->insertGetId([
            'email' => 'foundation@example.com',
            'password' => Hash::make('user123'),
            'contact_number' => '082222222222',
            'username' => 'foundation_user',
            'profile_photo' => null,
            'bio' => 'Akun yayasan sosial.',
            'role' => 'user',
            'entity_type' => 'foundation',
            'account_status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tb_user_details_foundation')->insert([
            'user_id' => $foundationId,
            'foundation_name' => 'Yayasan Harapan Bangsa',
            'sk_kemenkumham_number' => 'AHU-0012345',
            'foundation_address' => 'Jakarta Selatan',
            'pic_name' => 'Andi Wijaya',
            'pic_national_id_number' => '3171010202020002',
        ]);

        $corporateId = DB::table('tb_users')->insertGetId([
            'email' => 'corporate@example.com',
            'password' => Hash::make('user123'),
            'contact_number' => '083333333333',
            'username' => 'corporate_user',
            'profile_photo' => null,
            'bio' => 'Akun perusahaan CSR.',
            'role' => 'user',
            'entity_type' => 'corporate',
            'account_status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tb_user_details_corporate')->insert([
            'user_id' => $corporateId,
            'company_name' => 'PT Peduli Sesama',
            'nib' => '1234567890123',
            'npwp' => '12.345.678.9-123.000',
            'company_address' => 'Bandung',
            'pic_name' => 'Siti Rahma',
            'pic_national_id_number' => '3171010202020003',
        ]);

        $communityId = DB::table('tb_users')->insertGetId([
            'email' => 'community@example.com',
            'password' => Hash::make('user123'),
            'contact_number' => '084444444444',
            'username' => 'community_user',
            'profile_photo' => null,
            'bio' => 'Komunitas sosial kemanusiaan.',
            'role' => 'user',
            'entity_type' => 'community',
            'account_status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tb_user_details_community')->insert([
            'user_id' => $communityId,
            'community_name' => 'Komunitas Peduli Pendidikan',
            'community_type' => 'Sosial',
            'social_media_url' => 'https://instagram.com/pedulipendidikan',
            'pic_name' => 'Made Putra',
            'pic_national_id_number' => '3171010202020004',
        ]);
    }
}