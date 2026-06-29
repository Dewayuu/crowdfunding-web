<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationDataController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with(['user', 'campaign', 'campaign.category', 'refund']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                  ->orWhere('midtrans_order_id', 'like', "%{$search}%")
                  ->orWhereHas('campaign', function ($cq) use ($search) {
                      $cq->where('title', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('username', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter status pembayaran
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Filter metode pembayaran
        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        // Sorting
        $sortBy = $request->get('sort', 'terbaru');
        if ($sortBy === 'terlama') {
            $query->oldest();
        } elseif ($sortBy === 'terbesar') {
            $query->orderByDesc('amount');
        } elseif ($sortBy === 'terkecil') {
            $query->orderBy('amount');
        } else {
            $query->latest();
        }

        $donations = $query->paginate(15)->withQueryString();

        // Statistik
        $totalAmount = Donation::where('payment_status', 'settlement')->sum('amount');
        $totalCount = Donation::count();
        $successCount = Donation::where('payment_status', 'settlement')->count();
        $pendingCount = Donation::where('payment_status', 'pending')->count();

        // Daftar metode pembayaran unik (untuk filter)
        $paymentMethods = Donation::whereNotNull('payment_method')
            ->distinct()
            ->pluck('payment_method')
            ->sort()
            ->values();

        return view('admin.donations.index', compact(
            'donations',
            'totalAmount',
            'totalCount',
            'successCount',
            'pendingCount',
            'paymentMethods'
        ));
    }
}
