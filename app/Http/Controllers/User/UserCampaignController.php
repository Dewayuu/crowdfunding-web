<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use App\Models\CampaignDisbursement;
use App\Models\Donation;
use App\Models\DonationRefund;
use Illuminate\Support\Facades\DB;

class UserCampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::with(['category'])
            ->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('short_description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }

        if ($request->filled('category')) {
            $categoryName = $request->category;

            $query->whereHas('category', function ($q) use ($categoryName) {
                $q->where('category_name', $categoryName);
            });
        }

        $campaigns = $query->orderBy('created_at', 'DESC')
            ->paginate(6)
            ->withQueryString();

        foreach ($campaigns as $campaign) {

            $lastDisbursement = CampaignDisbursement::where(
                'campaign_id',
                $campaign->campaign_id
            )->latest()->first();

            $hasRefund = DB::table('tb_donation_refunds')
                ->join(
                    'tb_donations',
                    'tb_donation_refunds.donation_id',
                    '=',
                    'tb_donations.donation_id'
                )
                ->where('tb_donations.campaign_id', $campaign->campaign_id)
                ->exists();

            $campaign->last_disbursement = $lastDisbursement;
            $campaign->has_refund = $hasRefund;
            $campaign->disbursement_option = $this->getDisbursementOptions($campaign);
        }

        return view('user.campaigns.index', compact('campaigns'));
    }

    public function getDisbursementOptions($campaign)
    {
        $hasRequest =
            CampaignDisbursement::where('campaign_id', $campaign->campaign_id)->exists()
            ||
            DonationRefund::whereHas('donation', function ($q) use ($campaign) {
                $q->where('campaign_id', $campaign->campaign_id);
            })->exists();

        if ($hasRequest) {
            return 'REQUESTED';
        }

        if ($campaign->can_disburse) {
            return 'ALLOW_DISBURSE';
        }

        if ($campaign->is_deadline_passed && $campaign->current_amount > 0) {
            return 'SHOW_CHOICE';
        }

        return 'LOCKED';
    }

    public function requestDisbursement($id)
    {
        $campaign = Campaign::where('campaign_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (
            $campaign->current_amount < $campaign->target_amount &&
            !$campaign->is_deadline_passed
        ) {
            return back()->with('error', 'Pencairan belum bisa dilakukan.');
        }

        DB::table('tb_campaign_disbursement')->insert([
            'campaign_id' => $campaign->campaign_id,
            'user_bank_account_id' => $campaign->user_id,
            'amount_requested' => $campaign->current_amount,
            'purpose' => 'Pencairan dana otomatis - Target tercapai/Deadline lewat.',
            'disbursement_status' => 'pending',
            'created_at' => now(),
        ]);

        return back()->with('success', 'Permintaan pencairan dana berhasil diajukan.');
    }

    public function requestRefund($id)
    {
        $existingDisbursement = CampaignDisbursement::where(
            'campaign_id',
            $id
        )->exists();

        if ($existingDisbursement) {
            return back()->with('error', 'Aksi tidak bisa dilakukan karena sudah ada ajuan pencairan.');
        }

        $campaign = Campaign::where('campaign_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (
            !$campaign->is_deadline_passed ||
            $campaign->current_amount >= $campaign->target_amount
        ) {
            return back()->with('error', 'Refund tidak tersedia untuk campaign ini.');
        }

        $donations = Donation::where('campaign_id', $id)
            ->where('payment_status', 'paid')
            ->get();

        foreach ($donations as $donation) {

            DB::table('tb_donation_refunds')->insert([
                'donation_id' => $donation->donation_id,
                'user_bank_account_id' => $donation->user_id,
                'refund_status' => 'pending',
                'created_at' => now(),
            ]);
        }

        $campaign->update([
            'campaign_status' => 'canceled'
        ]);

        return back()->with('success', 'Permintaan refund telah diajukan untuk semua donatur.');
    }

    public function ownerDetail($id)
    {
        $campaign = Campaign::findOrFail($id);

        return view('user.campaigns.owner-detail', compact('campaign'));
    }
}