<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = DB::table('tb_users')->insertGetId([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'contact_number' => '081234567890',
            'username' => 'admin_crowd',
            'profile_photo' => null,
            'bio' => 'Akun utama pengelola dan verifikator platform crowdfunding.',
            'role' => 'admin',
            'entity_type' => 'individual',
            'account_status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tb_user_details_individual')->insert([
            'user_id' => $adminId,
            'full_name' => 'Admin Utama Platform',
            'national_id_number' => null, 
            'birth_date' => '1995-08-17',
            'gender' => 'male',
        ]);
    }
}