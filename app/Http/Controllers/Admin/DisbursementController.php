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
}