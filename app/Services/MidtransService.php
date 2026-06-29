<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;
use App\Models\Donation;

class MidtransService
{
    public static function init(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Generate Order ID unik
     */
    public static function generateOrderId(): string
    {
        return 'DON-' .
            now()->format('YmdHis') .
            '-' .
            strtoupper(substr(uniqid(), -6));
    }

    /**
     * Build parameter transaksi untuk Midtrans Snap
     */
    public static function buildTransactionParams(
        string $orderId,
        float $amount,
        string $donorName,
        ?string $email = null
    ): array {

        return [

            'transaction_details' => [

                'order_id' => $orderId,

                'gross_amount' => (int) $amount,

            ],

            'customer_details' => [

                'first_name' => $donorName,

                'email' => $email,

            ],

            'enabled_payments' => [

                'qris',
                'bank_transfer',
                'gopay',
                'shopeepay'

            ]

        ];
    }

    /**
     * Generate Snap Token
     */
    public static function createSnapToken(array $params): string
    {
        self::init();

        return Snap::getSnapToken($params);
    }

    /**
     * Status transaksi
     */
    public static function getTransactionStatus(string $orderId)
    {
        self::init();

        return Transaction::status($orderId);
    }

    /**
     * Cancel transaksi
     */
    public static function cancelTransaction(string $orderId)
    {
        self::init();

        return Transaction::cancel($orderId);
    }

    /**
     * Expire transaksi
     */
    public static function expireTransaction(string $orderId)
    {
        self::init();

        return Transaction::expire($orderId);
    }

    public static function getNotification(): Notification
    {
        self::init();
        return new Notification();
    }

    /**
     * Verifikasi signature callback Midtrans
     */
    public static function verifySignature(
        Notification $notification,
        Donation $donation
    ): bool {

        $grossAmount = number_format(
            $donation->amount,
            2,
            '.',
            ''
        );

        $signature = hash(
            'sha512',
            $notification->order_id .
            $notification->status_code .
            $grossAmount .
            config('midtrans.server_key')
        );

        return hash_equals(
            $signature,
            $notification->signature_key
        );
    }

    /**
     * Apakah transaksi dianggap berhasil
     */
    public static function isSuccess(Notification $notification): bool
    {
        return
            $notification->transaction_status === 'settlement'
            ||
            (
                $notification->transaction_status === 'capture'
                &&
                ($notification->fraud_status ?? '') === 'accept'
            );
    }
}