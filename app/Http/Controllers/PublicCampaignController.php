<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

class PublicCampaignController extends Controller
{
    public function show($id)
    {
        $campaign = Campaign::with([
                'user',
                'category',
                'images',
                'beneficiary',
            ])
            ->findOrFail($id);

        $donorCount = DB::table('tb_donations')
            ->where('campaign_id', $id)
            ->where('payment_status', 'success')
            ->count();

        $latestDonations = DB::table('tb_donations')
            ->where('campaign_id', $id)
            ->where('payment_status', 'success')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        $targetAmount = (float) $campaign->target_amount;
        $currentAmount = (float) $campaign->current_amount;

        $progressPercentage = $targetAmount > 0
            ? min(100, round(($currentAmount / $targetAmount) * 100))
            : 0;

        $daysLeft = $campaign->end_date
            ? max(0, now()->diffInDays($campaign->end_date, false))
            : 0;

        return view('campaigns.show', compact(
            'campaign',
            'donorCount',
            'latestDonations',
            'progressPercentage',
            'daysLeft'
        ));
    }
}