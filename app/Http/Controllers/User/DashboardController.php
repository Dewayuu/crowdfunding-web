<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Campaign;
use App\Models\Donation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalCampaign = Campaign::where('user_id', $user->id)->count();

        $verifiedCampaign = Campaign::where('user_id', $user->id)
            ->where('status', 'verified')
            ->count();

        $totalCollected = Donation::whereHas('campaign', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->sum('amount');

        $totalDonation = Donation::where('user_id', $user->id)
            ->sum('amount');

        return view('user.dashboard', compact(
            'user',
            'totalCampaign',
            'verifiedCampaign',
            'totalCollected',
            'totalDonation'
        ));
    }
}