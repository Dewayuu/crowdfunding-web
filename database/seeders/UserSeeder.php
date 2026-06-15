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
        $userId = DB::table('tb_users')->insertGetId([
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
            'user_id' => $userId,
            'full_name' => 'Test User',
            'national_id_number' => '3171010202020002',
            'birth_date' => '2001-05-12',
            'gender' => 'male',
        ]);
    }
}