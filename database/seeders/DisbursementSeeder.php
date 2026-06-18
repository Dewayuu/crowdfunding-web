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
        // 1. Ambil data pendukung dari database yang sudah di-seed sebelumnya
        $campaigns = DB::table('tb_campaigns')->get();
        $users = DB::table('tb_users')->where('role', 'user')->get();

        // Jika data campaign atau user belum di-seed, kita batalkan agar tidak error
        if ($campaigns->isEmpty() || $users->isEmpty()) {
            return;
        }

        // 2. Pastikan data Rekening Bank dummy sudah ada di tb_user_bank_accounts
        foreach ($users as $user) {
            $bankExist = DB::table('tb_user_bank_accounts')->where('user_id', $user->user_id)->exists();
            if (!$bankExist) {
                DB::table('tb_user_bank_accounts')->insert([
                    'user_id' => $user->user_id, // Berperan sebagai PK sekaligus FK sesuai migrasimu
                    'bank_name' => 'Bank Mandiri',
                    'account_number' => '13100' . rand(1000000, 9999999),
                    'account_name' => 'Rekening ' . $user->username,
                ]);
            }
        }

        // 3. Buat beberapa data Donasi Berhasil di tb_donations (Wajib untuk kebutuhan data Refund)
        foreach ($campaigns as $index => $campaign) {
            // Ambil user donatur (kita balik saja dari urutan user agar owner tidak mendonasi ke dirinya sendiri)
            $donatur = $users->get(($index + 1) % $users->count());

            $donationId = DB::table('tb_donations')->insertGetId([
                'campaign_id' => $campaign->campaign_id,
                'user_id' => $donatur->user_id,
                'donor_name' => $donatur->username,
                'is_anonymous' => 'no',
                'amount' => 500000,
                'support_messsage' => 'Semoga berkah dan membantu!',
                'payment_method' => 'qris',
                'payment_reference' => 'REF-' . rand(100000, 999999),
                'payment_status' => 'success', // Set sukses agar valid untuk di-refund
                'paid_at' => now()->subDays(5),
                'expired_at' => now()->subDays(5)->addHours(2),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ]);

            // Save donation_id untuk dipakai di seeder refund nanti
            $campaign->latest_donation_id = $donationId;
            $campaign->donatur_id = $donatur->user_id;
        }

        // 4. SUNTIK DATA TABEL 1: tb_campaign_disbursement (Pencairan Dana)
        // Kita buat variasi status: Menunggu, Disetujui, dan Ditolak sesuai UI Dashboard
        foreach ($campaigns as $index => $campaign) {
            $statusOptions = ['pending', 'transferred', 'rejected'];
            $currentStatus = $statusOptions[$index % 3]; // Bergantian agar bervariasi

            DB::table('tb_campaign_disbursement')->insert([
                'campaign_id' => $campaign->campaign_id,
                'user_bank_account_id' => $campaign->user_id, // Owner campaign mencairkan ke bank miliknya
                'amount_requested' => 15000000.00,
                'purpose' => 'Alokasi dana untuk pembelian logistik utama proyek sesuai deskripsi pengajuan.',
                'disbursement_status' => $currentStatus,
                'transfer_proof' => $currentStatus === 'transferred' ? 'campaign/login-bg.jpg' : null, // Menggunakan sampel foto yang sudah ada
                'rejection_reason' => $currentStatus === 'rejected' ? 'Rincian nota pengajuan dana yang dilampirkan tidak jelas.' : null,
                'created_at' => now()->subDays(3),
                'processed_at' => $currentStatus !== 'pending' ? now()->subDays(1) : null,
            ]);
        }

        // 5. SUNTIK DATA TABEL 2: tb_donation_refunds (Refund Dana)
        // Kita batasi hanya mengambil 2 campaign saja untuk dijadikan data refund bervariasi
        foreach ($campaigns->take(2) as $index => $campaign) {
            $statusOptions = ['pending', 'success'];
            $currentStatus = $statusOptions[$index % 2];

            DB::table('tb_donation_refunds')->insert([
                'donation_id' => $campaign->latest_donation_id, // Unik berelasi ke tb_donations
                'user_bank_account_id' => $campaign->donatur_id, // Donatur menerima refund ke bank miliknya
                'refund_status' => $currentStatus,
                'transfer_proof' => $currentStatus === 'success' ? 'campaign/login-bg.jpg' : null,
                'created_at' => now()->subDays(2),
                'processed_at' => $currentStatus !== 'pending' ? now()->subDays(1) : null,
            ]);
        }
    }
}