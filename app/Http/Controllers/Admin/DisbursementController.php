<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CampaignDisbursement;
use App\Models\DonationRefund;
use App\Models\Donation;
use App\Models\Campaign;

class DisbursementController extends Controller
{
    public function index(Request $request)
    {
        $disbursements = DB::table('tb_campaign_disbursement as tcd')
            ->join('tb_campaigns as c', 'tcd.campaign_id', '=', 'c.campaign_id')
            ->join('tb_users as u', 'c.user_id', '=', 'u.user_id')
            ->leftJoin('tb_campaign_categories as cat', 'c.category_id', '=', 'cat.category_id')
            ->select(
                'tcd.disbursement_id as id',
                'c.title as campaign_title',
                'cat.category_name',
                'u.username as owner_name',
                DB::raw("'Pencairan Dana' as jenis"),
                'tcd.disbursement_status as status',
                'tcd.created_at as tanggal',
                DB::raw("'disbursement' as type_code")
            );

        $refunds = DB::table('tb_donation_refunds as tr')
            ->join('tb_donations as d', 'tr.donation_id', '=', 'd.donation_id')
            ->join('tb_campaigns as c', 'd.campaign_id', '=', 'c.campaign_id')
            ->join('tb_users as u', 'c.user_id', '=', 'u.user_id')
            ->leftJoin('tb_campaign_categories as cat', 'c.category_id', '=', 'cat.category_id')
            ->select(
                'c.campaign_id as id',
                'c.title as campaign_title',
                'cat.category_name',
                'u.username as owner_name',
                DB::raw("'Refund Dana' as jenis"),

                DB::raw("
                    CASE
                        WHEN SUM(CASE WHEN tr.refund_status='pending' THEN 1 ELSE 0 END) > 0
                        THEN 'pending'
                        ELSE 'success'
                    END as status
                "),

                DB::raw('MAX(tr.created_at) as tanggal'),

                DB::raw("'refund' as type_code")
            )
            ->groupBy(
                'c.campaign_id',
                'c.title',
                'cat.category_name',
                'u.username'
            );

        $combinedQuery = $disbursements->unionAll($refunds);

        $mainQuery = DB::table(DB::raw("({$combinedQuery->toSql()}) as combined"))
            ->mergeBindings($combinedQuery);

        if ($request->filled('search')) {
            $search = $request->search;
            $mainQuery->where(function($q) use ($search) {
                $q->where('campaign_title', 'LIKE', "%{$search}%")
                  ->orWhere('owner_name', 'LIKE', "%{$search}%")
                  ->orWhere('category_name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $mainQuery->where('type_code', $request->type);
        }

        if ($request->filled('category')) {
            $mainQuery->where('category_name', $request->category);
        }

        $data = $mainQuery->orderBy('tanggal', 'DESC')
                          ->paginate(10)
                          ->withQueryString();

        return view('admin.disbursements.index', ['disbursements' => $data]);
    }

    public function refundDetail(Request $request, $campaignId)
    {
        $campaign = Campaign::with([
            'category',
            'user.detailFoundation',
            'user.detailCommunity',
            'user.detailCorporate',
            'user.detailIndividual'
        ])->findOrFail($campaignId);

        $user = $campaign->user;

        $refundItemsQuery = DB::table('tb_donation_refunds as r')
            ->join('tb_donations as d', 'r.donation_id', '=', 'd.donation_id')
            ->leftJoin('tb_user_bank_accounts as uba', 'r.user_bank_account_id', '=', 'uba.user_id')
            ->where('d.campaign_id', $campaignId)
            ->select(
                'r.*',
                'd.donation_id',
                'd.midtrans_order_id', 
                'd.payment_status',
                'd.donor_name',
                'd.amount',
                'd.payment_method',
                'd.created_at as donation_date',
                'uba.bank_name',
                'uba.account_number',
                'uba.account_name'
            );
        
        if ($request->filled('search')) {
            $search = $request->search;
            $refundItemsQuery->where(function($q) use ($search) {
                $q->where('d.donor_name', 'LIKE', "%{$search}%")
                  ->orWhere('d.donation_id', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $refundItemsQuery->where('r.refund_status', $request->status);
        }

        $refundItems = $refundItemsQuery->orderBy('r.created_at', 'desc')->paginate(10)->withQueryString();

        $totalDonatur = $refundItems->total();

        $totalRefundAmount = DB::table('tb_donation_refunds as r')
            ->join('tb_donations as d', 'r.donation_id', '=', 'd.donation_id')
            ->where('d.campaign_id', $campaignId)
            ->sum('d.amount');

        $processedCount = DB::table('tb_donation_refunds as r')
            ->join('tb_donations as d', 'r.donation_id', '=', 'd.donation_id')
            ->where('d.campaign_id', $campaignId)
            ->where('r.refund_status', 'success')
            ->count();

        $ownerName = $user->username;
        $identityLabel = 'Dokumen';
        $identityValue = '-';

        switch ($user->entity_type) {

            case 'individual':
                $ownerName = $user->detailIndividual?->full_name ?? $user->username;

                $identityLabel = 'NIK';
                $identityValue = $user->detailIndividual?->national_id_number ?? '-';
                break;

            case 'foundation':
                $ownerName = $user->detailFoundation?->foundation_name ?? $user->username;

                $identityLabel = 'SK Kemenkumham';
                $identityValue = $user->detailFoundation?->sk_kemenkumham_number ?? '-';
                break;

            case 'corporate':
                $ownerName = $user->detailCorporate?->company_name ?? $user->username;

                $identityLabel = 'NIB / NPWP';
                $identityValue =
                    ($user->detailCorporate?->nib ?? '-') .
                    ' / ' .
                    ($user->detailCorporate?->npwp ?? '-');
                break;

            case 'community':
                $ownerName = $user->detailCommunity?->community_name ?? $user->username;

                $identityLabel = 'Tipe Komunitas';
                $identityValue = $user->detailCommunity?->community_type ?? '-';
                break;
        }

        return view(
            'admin.disbursements.refund-detail',
            compact(
                'campaign',
                'refundItems',
                'ownerName',
                'identityLabel',
                'identityValue',
                'totalDonatur',
                'totalRefundAmount',
                'processedCount'
            )
        );
    }

    public function show($id, $type)
    {
        try {

            if ($type === 'disbursement') {

                $disbursement = CampaignDisbursement::with([
                    'campaign.category',
                    'campaign.user.detailIndividual',
                    'campaign.user.detailFoundation',
                    'campaign.user.detailCommunity',
                    'campaign.user.detailCorporate',
                    'campaign.user.bankAccount',
                    'bankAccount'
                ])->findOrFail($id);

                $campaign = $disbursement->campaign;
                $user = $campaign->user;

                $entityType = $user->entity_type;

                $ownerDetail = match ($entityType) {
                    'individual' => $user->detailIndividual,
                    'foundation' => $user->detailFoundation,
                    'community' => $user->detailCommunity,
                    'corporate' => $user->detailCorporate,
                    default => null
                };

                return response()->json([
                    'campaign_id'         => $campaign->campaign_id,
                    'campaign_title'      => $campaign->title,
                    'category_name'       => $campaign->category?->category_name,
                    'deadline'            => optional($campaign->end_date)->format('d F Y'),
                    'target_amount'       => 'Rp' . number_format($campaign->target_amount, 0, ',', '.'),
                    'current_amount'      => 'Rp' . number_format($campaign->current_amount, 0, ',', '.'),
                    'status'              => $disbursement->disbursement_status,
                    'amount_requested'    => 'Rp' . number_format($disbursement->amount_requested, 0, ',', '.'),
                    'purpose'             => $disbursement->purpose,
                    'transfer_proof'      => $disbursement->transfer_proof,
                    'rejection_reason'    => $disbursement->rejection_reason,

                    'entity_type'         => $entityType,

                    'owner_email'         => $user->email,
                    'owner_contact'       => $user->contact_number,

                    'bank_name'           => $disbursement->bankAccount?->bank_name ?? '-',
                    'bank_account_number' => $disbursement->bankAccount?->account_number ?? '-',
                    'bank_account_name'   => $disbursement->bankAccount?->account_name ?? '-',

                    'owner_detail'        => $ownerDetail ?? (object)[]
                ]);
            }
        }  catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile())
            ], 500);
        }
    }
    
    public function update(Request $request, $id, $type)
    {
        $statusInput = $request->input('status'); 

        if ($type === 'disbursement') {
            $disbursement = DB::table('tb_campaign_disbursement')
                ->where('disbursement_id', $id)
                ->first();

            if (!$disbursement) {
                return back()->with('error', 'Data tidak ditemukan');
            }

            if ($statusInput === 'approved') {
                DB::table('tb_campaign_disbursement')->where('disbursement_id', $id)->update([
                    'disbursement_status' => 'approved',
                    'processed_at'        => now()
                ]);

            } elseif ($statusInput === 'transferred') {

                if ($disbursement->disbursement_status !== 'approved') {
                    return back()->with('error', 'Pengajuan harus berstatus approved terlebih dahulu.');
                }

                $request->validate([
                    'transfer_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
                ]);

                $path = $request
                    ->file('transfer_proof')
                    ->store('transfer-proofs', 'public');

                DB::table('tb_campaign_disbursement')
                    ->where('disbursement_id', $id)
                    ->update([
                        'disbursement_status' => 'transferred',
                        'transfer_proof' => $path,
                        'processed_at' => now()
                    ]);

                DB::table('tb_campaigns')
                    ->where('campaign_id', $disbursement->campaign_id)
                    ->update([
                        'disbursement_status' => 'fully_disbursed'
                    ]);
            } else {

                $request->validate([
                    'rejection_reason' => 'required|string|max:500'
                ]);

                DB::table('tb_campaign_disbursement')
                    ->where('disbursement_id', $id)
                    ->update([
                        'disbursement_status' => 'rejected',
                        'rejection_reason' => $request->rejection_reason,
                        'processed_at' => now()
                    ]);
            }
        } else {
            if ($statusInput === 'approved') {
                DB::table('tb_donation_refunds')->where('refund_id', $id)->update([
                    'refund_status'  => 'approved', 
                    'processed_at'   => now()
                ]);
            } elseif ($statusInput === 'transferred') {
                $request->validate([
                    'transfer_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ]);

                $path = $request->file('transfer_proof')->store('campaign', 'public');

                DB::table('tb_donation_refunds')->where('refund_id', $id)->update([
                    'refund_status'  => 'success', 
                    'transfer_proof' => $path,
                    'processed_at'   => now()
                ]);
            } else {
                DB::table('tb_donation_refunds')->where('refund_id', $id)->update([
                    'refund_status' => 'failed', 
                    'processed_at'  => now()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status pengajuan dana berhasil diperbarui!');
    }

    public function processRefund(Request $request, $refundId)
    {
        $request->validate([
            'transfer_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $refund = DB::table('tb_donation_refunds')->where('refund_id', $refundId)->first();
        if (!$refund) {
            return redirect()->back()->with('error', 'Data refund tidak ditemukan.');
        }

        $path = $request->file('transfer_proof')->store('transfer-proofs', 'public');

        DB::table('tb_donation_refunds')->where('refund_id', $refundId)->update([
            'refund_status'  => 'success',
            'transfer_proof' => $path,
            'processed_at'   => now()
        ]);

        return redirect()->back()->with('success', 'Bukti transfer refund donatur berhasil dikirim!');
    }

    public function exportRefundAccounts($campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);

        $refunds = DB::table('tb_donation_refunds as r')
            ->join('tb_donations as d', 'r.donation_id', '=', 'd.donation_id')
            ->leftJoin('tb_user_bank_accounts as uba', 'r.user_bank_account_id', '=', 'uba.user_id')
            ->where('d.campaign_id', $campaignId)
            ->select(
                'd.donation_id',
                'd.midtrans_order_id',
                'd.donor_name',
                'd.amount',
                'uba.bank_name',
                'uba.account_number',
                'uba.account_name',
                'r.refund_status'
            )
            ->orderBy('r.created_at', 'asc')
            ->get();

        $fileName = 'Daftar_Refund_Rekening_Campaign_' . $campaignId . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($refunds) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['No', 'Order ID Midtrans', 'Nama Donatur', 'Nama Bank', 'Nomor Rekening', 'Atas Nama', 'Nominal Refund', 'Status']);
            
            foreach ($refunds as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->midtrans_order_id ?? ('#DON-' . $item->donation_id),
                    $item->donor_name,
                    $item->bank_name ?? '-',
                    $item->account_number ? "'" . $item->account_number : '-', 
                    $item->account_name ?? '-',
                    number_format($item->amount, 0, '', ''), 
                    $item->refund_status === 'success' ? 'Selesai' : ($item->refund_status === 'pending' ? 'Menunggu' : 'Gagal')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}