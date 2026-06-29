<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisbursementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = DB::table('tb_campaigns')->get();
        $users = DB::table('tb_users')->where('role', 'user')->get();

        if ($campaigns->isEmpty() || $users->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            $bankExist = DB::table('tb_user_bank_accounts')->where('user_id', $user->user_id)->exists();
            if (!$bankExist) {
                DB::table('tb_user_bank_accounts')->insert([
                    'user_id' => $user->user_id, 
                    'bank_name' => 'Bank Mandiri',
                    'account_number' => '13100' . rand(1000000, 9999999),
                    'account_name' => 'Rekening ' . $user->username,
                ]);
            }
        }

        foreach ($campaigns as $index => $campaign) {
            $donatur = $users->get(($index + 1) % $users->count());

            $donationId = DB::table('tb_donations')->insertGetId([
                'campaign_id' => $campaign->campaign_id,
                'user_id' => $donatur->user_id,
                'donor_name' => $donatur->username,
                'is_anonymous' => 'no',
                'amount' => 500000,
                'support_message' => 'Semoga berkah dan membantu!',
                'payment_method' => 'qris',
                'payment_reference' => 'REF-' . rand(100000, 999999),
                'payment_status' => 'success', 
                'paid_at' => now()->subDays(5),
                'expired_at' => now()->subDays(5)->addHours(2),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ]);

            $campaign->latest_donation_id = $donationId;
            $campaign->donatur_id = $donatur->user_id;
        }

        foreach ($campaigns as $index => $campaign) {
            $statusOptions = ['pending', 'transferred', 'rejected'];
            $currentStatus = $statusOptions[$index % 3]; 

            DB::table('tb_campaign_disbursement')->insert([
                'campaign_id' => $campaign->campaign_id,
                'user_bank_account_id' => $campaign->user_id, 
                'amount_requested' => 15000000.00,
                'purpose' => 'Alokasi dana untuk pembelian logistik utama proyek sesuai deskripsi pengajuan.',
                'disbursement_status' => $currentStatus,
                'transfer_proof' => $currentStatus === 'transferred' ? 'campaign/login-bg.jpg' : null, 
                'rejection_reason' => $currentStatus === 'rejected' ? 'Rincian nota pengajuan dana yang dilampirkan tidak jelas.' : null,
                'created_at' => now()->subDays(3),
                'processed_at' => $currentStatus !== 'pending' ? now()->subDays(1) : null,
            ]);
        }

        foreach ($campaigns->take(2) as $index => $campaign) {
            $statusOptions = ['pending', 'success'];
            $currentStatus = $statusOptions[$index % 2];

            DB::table('tb_donation_refunds')->insert([
                'donation_id' => $campaign->latest_donation_id, 
                'user_bank_account_id' => $campaign->donatur_id, 
                'refund_status' => $currentStatus,
                'transfer_proof' => $currentStatus === 'success' ? 'campaign/login-bg.jpg' : null,
                'created_at' => now()->subDays(2),
                'processed_at' => $currentStatus !== 'pending' ? now()->subDays(1) : null,
            ]);
        }
    }
}