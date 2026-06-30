<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Midtrans\Notification;
use Carbon\Carbon;
use App\Services\MidtransService;

class DonationService
{
    public function createDonation(
        Campaign $campaign,
        User $user,
        array $data
    )
    {
        $this->validateCampaign($campaign);

        $this->validateAmount(
            $campaign,
            (int)$data['amount']
        );

        $orderId = MidtransService::generateOrderId();

        return DB::transaction(function () use (
            $campaign,
            $user,
            $data,
            $orderId
        ) {

            $donation = Donation::create([

                'campaign_id' => $campaign->campaign_id,

                'user_id' => $user->user_id,

                'donor_name' => $user->username,

                'is_anonymous' => $data['is_anonymous'] ?? 'no',

                'support_message' => $data['support_message'] ?? null,

                'amount' => $data['amount'],

                'midtrans_order_id' => $orderId,

                'payment_status' => 'pending',

            ]);

            $params = MidtransService::buildTransactionParams(

                orderId: $orderId,

                amount: $donation->amount,

                donorName: $user->username,

                email: $user->email

            );

            $snapToken = MidtransService::createSnapToken($params);

            $donation->update([

                'snap_token' => $snapToken,

                'payment_payload' => $params,

            ]);

            return [

                'success' => true,

                'donation' => $donation->fresh(),

                'snap_token' => $snapToken,

                'order_id' => $orderId,

            ];

        });
    }

    private function validateCampaign(Campaign $campaign): void
    {
        if ($campaign->verification_status !== 'approved') {
            throw ValidationException::withMessages([
                'campaign' => 'Campaign belum diverifikasi.'
            ]);
        }

        if ($campaign->campaign_status !== 'active') {
            throw ValidationException::withMessages([
                'campaign' => 'Campaign sudah tidak aktif.'
            ]);
        }

        if ($campaign->current_amount >= $campaign->target_amount) {

            throw ValidationException::withMessages([
                'campaign' => 'Campaign telah mencapai target donasi.'
            ]);

        }

        if (
            $campaign->end_date &&
            now()->greaterThan($campaign->end_date)
        ) {
            throw ValidationException::withMessages([
                'campaign' => 'Campaign telah berakhir.'
            ]);
        }
    }

    private function validateAmount(
        Campaign $campaign,
        int $amount
    ): void
    {
        if ($amount < 5000) {

            throw ValidationException::withMessages([
                'amount' => 'Minimal donasi Rp5.000.'
            ]);

        }

        if ($campaign->remaining_target <= 0) {

            throw ValidationException::withMessages([
                'campaign' => 'Campaign telah mencapai target.'
            ]);

        }

        if ($amount > $campaign->remaining_target) {

            throw ValidationException::withMessages([
                'amount' =>
                    'Maksimal donasi hanya Rp '
                    . number_format(
                        $campaign->remaining_target,
                        0,
                        ',',
                        '.'
                    )
            ]);

        }
    }

    public function handleNotification(Notification $notification): void
    {
        $donation = Donation::where(
            'midtrans_order_id',
            $notification->order_id
        )->first();

        if (!$donation) {
            throw ValidationException::withMessages([
                'order' => 'Donation tidak ditemukan.'
            ]);
        }

        /*
        Verifikasi Signature Midtrans
        */

        if (!MidtransService::verifySignature($notification, $donation)) {
            throw ValidationException::withMessages([
                'signature' => 'Signature Midtrans tidak valid.'
            ]);
        }

        /*
        Validasi Nominal
        */

        if ((float) $notification->gross_amount !== (float) $donation->amount) {
            throw ValidationException::withMessages([
                'amount' => 'Nominal transaksi tidak sesuai.'
            ]);
        }

        if (
            $donation->payment_status === 'paid'
            &&
            MidtransService::isSuccess($notification)
        ) {
            return;
        }

        /*
        Mapping Status Midtrans
        */

        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? null;

        $status = 'pending';

        switch ($transactionStatus) {

            case 'capture':

                if ($fraudStatus === 'accept') {

                    $status = 'paid';

                } elseif ($fraudStatus === 'challenge') {

                    $status = 'pending';

                }

                break;

            case 'settlement':

                $status = 'paid';

                break;

            case 'pending':

                $status = 'pending';

                break;

            case 'expire':

                $status = 'expired';

                break;

            case 'cancel':

                $status = 'cancelled';

                break;

            case 'deny':

                $status = 'failed';

                break;
        }

        $oldStatus = $donation->payment_status;

        /*
        Atomic Transaction
        */

        DB::transaction(function () use (
            $donation,
            $notification,
            $status,
            $oldStatus
        ) {

            $data = [

                'payment_status' => $status,

                'payment_method' =>
                    $notification->payment_type ?? null,

                'payment_reference' =>
                    $notification->transaction_id ?? null,

                'midtrans_transaction_id' =>
                    $notification->transaction_id ?? null,

                'payment_notified_at' =>
                    now(),

                'payment_payload' =>
                    json_decode(json_encode($notification), true),

            ];

            if ($status === 'paid') {

                $data['paid_at'] = Carbon::now();

            }

            if ($status === 'expired') {

                $data['expired_at'] = Carbon::now();

            }

            $donation->update($data);

            if (
                $oldStatus !== 'paid'
                &&
                $status === 'paid'
            ) {

                $campaign = Campaign::lockForUpdate()->findOrFail(
                    $donation->campaign_id
                );

                $remainingTarget = $campaign->remaining_target;

                if ($donation->amount > $remainingTarget) {

                    $donation->update([
                        'payment_status' => 'failed',
                    ]);

                    return;
                }

                $campaign->increment(
                    'current_amount',
                    $donation->amount
                );

                $campaign->refresh();

                if ($campaign->current_amount >= $campaign->target_amount) {

                    $campaign->update([
                        'campaign_status' => 'completed',
                    ]);

                }

            }

        });

    }

}