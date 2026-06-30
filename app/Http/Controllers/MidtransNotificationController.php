<?php

namespace App\Http\Controllers;

use App\Services\DonationService;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Throwable;

class MidtransNotificationController extends Controller
{
    public function __construct(
        private DonationService $donationService
    ) {}

    public function handle(): JsonResponse
    {
        try {

            $notification = MidtransService::getNotification();

            $this->donationService
                ->handleNotification($notification);

            return response()->json([
                'success' => true
            ]);

        } catch (Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }
}