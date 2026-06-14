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
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'account_status' => 'active',
            'account_type' => 'tabungan', 
            'contact_number' => '081234567890',
            'bio' => 'Akun utama pengelola dan verifikator platform crowdfunding.',
            'profile_photo' => null,
            'bank_name' => null,
            'account_number' => null,
            'account_holder' => null,
            'bank_proof_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}