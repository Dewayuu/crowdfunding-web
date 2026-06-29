<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with(['campaign', 'campaign.category', 'campaign.images', 'refund'])
            ->where('user_id', Auth::id());

        // Filter berdasarkan pencarian (judul campaign / order id)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('midtrans_order_id', 'like', "%{$search}%")
                  ->orWhere('donor_name', 'like', "%{$search}%")
                  ->orWhereHas('campaign', function ($cq) use ($search) {
                      $cq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan status pembayaran
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort', 'terbaru');
        if ($sortBy === 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $donations = $query->paginate(10)->withQueryString();

        // Hitung statistik ringkasan
        $totalDonated = Donation::where('user_id', Auth::id())
            ->where('payment_status', 'settlement')
            ->sum('amount');

        $totalTransactions = Donation::where('user_id', Auth::id())->count();

        $successTransactions = Donation::where('user_id', Auth::id())
            ->where('payment_status', 'settlement')
            ->count();

        return view('user.donations.index', compact(
            'donations',
            'totalDonated',
            'totalTransactions',
            'successTransactions'
        ));
    }
}
