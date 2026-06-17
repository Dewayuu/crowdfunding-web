<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil data campaign dari tb_campaigns beserta relasi user dan kategorinya
        $query = Campaign::with(['user', 'category'])->latest('created_at');

        // Integrasi Filter Pencarian Sederhana
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('category_name', $request->category);
            });
        }

        $campaigns = $query->paginate(10);

        return view('admin.campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

   public function show(string $id)
    {
       $campaign = Campaign::with([
        'category',
        'beneficiary',
        'images',
        'user.detailIndividual',
        'user.detailCorporate',
        'user.detailFoundation',
        'user.detailCommunity',
        'user.bankAccount',
        'user.documents'
        ])->findOrFail($id);

        return response()->json($campaign);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function verify(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        $campaign = Campaign::findOrFail($id);
        
        // Update status verifikasi dan status keaktifan campaign secara sinkron
        $campaign->update([
            'verification_status' => $request->status,
            'admin_notes' => $request->admin_notes,
            // Jika disetujui, otomatis status campaign menjadi active agar donatur bisa mulai berdonasi
            'campaign_status' => $request->status === 'approved' ? 'active' : 'canceled'
        ]);

        return redirect()->route('admin.campaigns')->with('success', 'Status verifikasi campaign berhasil diperbarui.');
    }
}