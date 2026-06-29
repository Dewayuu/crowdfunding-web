<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_campaign_categories')->insert([
    [
        'category_name' => 'Pendidikan',
        'slug' => 'pendidikan',
        'category_icon' => 'fa-graduation-cap',
        'is_active' => 'yes',
        'created_at' => now(),
    ],
    [
        'category_name' => 'Kesehatan',
        'slug' => 'kesehatan',
        'category_icon' => 'fa-heart',
        'is_active' => 'yes',
        'created_at' => now(),
    ],
    [
        'category_name' => 'Bencana Alam',
        'slug' => 'bencana-alam',
        'category_icon' => 'fa-house-damage',
        'is_active' => 'yes',
        'created_at' => now(),
    ],
    [
        'category_name' => 'Sosial',
        'slug' => 'sosial',
        'category_icon' => 'fa-users',
        'is_active' => 'yes',
        'created_at' => now(),
    ],
]);   
}
}