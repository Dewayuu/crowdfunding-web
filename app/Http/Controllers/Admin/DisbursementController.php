<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CampaignDisbursement;
use App\Models\DonationRefund;

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
            ->join('tb_users as u', 'd.user_id', '=', 'u.user_id') 
            ->leftJoin('tb_campaign_categories as cat', 'c.category_id', '=', 'cat.category_id')
            ->select(
                'tr.refund_id as id',
                'c.title as campaign_title',
                'cat.category_name',
                'u.username as owner_name', 
                DB::raw("'Refund Dana' as jenis"),
                'tr.refund_status as status',
                'tr.created_at as tanggal',
                DB::raw("'refund' as type_code")
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
}