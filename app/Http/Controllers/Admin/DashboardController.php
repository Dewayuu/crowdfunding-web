<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignDisbursement;
use App\Models\Donation;
use App\Models\DonationRefund;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ──────────────────────────────────────────────────────
        // STATISTIK UTAMA (CARD ATAS)
        // ──────────────────────────────────────────────────────

        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalCampaigns = Campaign::count();
        $totalDonations = Donation::where('payment_status', 'settlement')->sum('amount');
        $totalTransactions = Donation::count();

        // ──────────────────────────────────────────────────────
        // STATUS CAMPAIGN
        // ──────────────────────────────────────────────────────

        $campaignsPending = Campaign::where('verification_status', 'pending')->count();
        $campaignsApproved = Campaign::where('verification_status', 'approved')->count();
        $campaignsRejected = Campaign::where('verification_status', 'rejected')->count();
        $campaignsActive = Campaign::where('verification_status', 'approved')
            ->where('campaign_status', 'active')
            ->count();

        // ──────────────────────────────────────────────────────
        // STATUS DONASI
        // ──────────────────────────────────────────────────────

        $donationsSettlement = Donation::where('payment_status', 'settlement')->count();
        $donationsPending = Donation::where('payment_status', 'pending')->count();
        $donationsExpired = Donation::where('payment_status', 'expire')->count();

        // ──────────────────────────────────────────────────────
        // PENCAIRAN DANA (DISBURSEMENT)
        // ──────────────────────────────────────────────────────

        $disbursementsPending = CampaignDisbursement::where('disbursement_status', 'pending')->count();
        $disbursementsApproved = CampaignDisbursement::where('disbursement_status', 'approved')->count();
        $disbursementsTransferred = CampaignDisbursement::where('disbursement_status', 'transferred')->count();
        $totalDisbursedAmount = CampaignDisbursement::where('disbursement_status', 'transferred')->sum('amount_requested');

        // ──────────────────────────────────────────────────────
        // REFUND
        // ──────────────────────────────────────────────────────

        $refundsPending = DonationRefund::where('refund_status', 'pending')->count();
        $refundsCompleted = DonationRefund::where('refund_status', 'success')->count();

        // ──────────────────────────────────────────────────────
        // CAMPAIGN TERBARU (5 terakhir yang diajukan)
        // ──────────────────────────────────────────────────────

        $latestCampaigns = Campaign::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        // ──────────────────────────────────────────────────────
        // DONASI TERBARU (5 terakhir)
        // ──────────────────────────────────────────────────────

        $latestDonations = Donation::with(['user', 'campaign'])
            ->latest()
            ->take(5)
            ->get();

        // ──────────────────────────────────────────────────────
        // PENCAIRAN PENDING (5 terakhir)
        // ──────────────────────────────────────────────────────

        $pendingDisbursements = CampaignDisbursement::with(['campaign', 'campaign.user'])
            ->where('disbursement_status', 'pending')
            ->latest('created_at')
            ->take(5)
            ->get();

        // ──────────────────────────────────────────────────────
        // DATA CHART — Donasi 6 bulan terakhir
        // ──────────────────────────────────────────────────────

        $monthlyDonations = Donation::where('payment_status', 'settlement')
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(amount) as total, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $chartLabels = [];
        $chartAmounts = [];
        $chartCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $key = $date->format('Y-m');
            $chartLabels[] = $date->translatedFormat('M Y');
            $chartAmounts[] = (float) ($monthlyDonations[$key]->total ?? 0);
            $chartCounts[] = (int) ($monthlyDonations[$key]->count ?? 0);
        }

        // ──────────────────────────────────────────────────────
        // USER BARU BULAN INI
        // ──────────────────────────────────────────────────────

        $newUsersThisMonth = User::where('role', '!=', 'admin')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCampaigns',
            'totalDonations',
            'totalTransactions',
            'campaignsPending',
            'campaignsApproved',
            'campaignsRejected',
            'campaignsActive',
            'donationsSettlement',
            'donationsPending',
            'donationsExpired',
            'disbursementsPending',
            'disbursementsApproved',
            'disbursementsTransferred',
            'totalDisbursedAmount',
            'refundsPending',
            'refundsCompleted',
            'latestCampaigns',
            'latestDonations',
            'pendingDisbursements',
            'chartLabels',
            'chartAmounts',
            'chartCounts',
            'newUsersThisMonth'
        ));
    }
}
