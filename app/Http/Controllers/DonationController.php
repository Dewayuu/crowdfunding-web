<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Services\DonationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreDonationRequest;

class DonationController extends Controller
{
    public function __construct(
        private DonationService $donationService
    ) {
    }

    public function store(StoreDonationRequest $request)
    {
        try {

            $data = $request->validated();

            $campaign = Campaign::findOrFail(
                $data['campaign_id']
            );

            $user = Auth::user();

            $result = $this->donationService
                ->createDonation(
                    $campaign,
                    $user,
                    $data
                );

            return response()->json($result);

        } catch (ValidationException $e) {

            return response()->json([

                'success' => false,

                'errors' => $e->errors()

            ],422);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ],500);

        }
    }
}