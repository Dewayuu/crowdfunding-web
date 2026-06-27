<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $campaignCountSub = DB::table('tb_campaigns')
            ->selectRaw('COUNT(*)')
            ->whereColumn('tb_campaigns.user_id', 'tb_users.user_id');

        $totalDonationSub = DB::table('tb_donations')
            ->selectRaw('COALESCE(SUM(amount), 0)')
            ->whereColumn('tb_donations.user_id', 'tb_users.user_id')
            ->where('payment_status', 'success');

        $users = User::with('bankAccount')
            ->select('tb_users.*')
            ->selectSub($campaignCountSub, 'campaign_count')
            ->selectSub($totalDonationSub, 'total_donation')
            ->when($request->q, function ($query, $q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('username', 'like', '%' . $q . '%')
                        ->orWhere('email', 'like', '%' . $q . '%');
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('account_status', $status);
            })
            ->when($request->bank_status, function ($query, $bankStatus) {
                if ($bankStatus === 'complete') {
                    $query->where('role', 'user')
                        ->whereHas('bankAccount');
                }

                if ($bankStatus === 'incomplete') {
                    $query->where('role', 'user')
                        ->whereDoesntHave('bankAccount');
                }

                if ($bankStatus === 'not_applicable') {
                    $query->where('role', 'admin');
                }
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'total_users' => User::count(),
            'active_users' => User::where('account_status', 'active')->count(),
            'complete_bank_accounts' => User::where('role', 'user')->whereHas('bankAccount')->count(),
            'incomplete_bank_accounts' => User::where('role', 'user')->whereDoesntHave('bankAccount')->count(),
        ];

        return view('admin.users.index', compact('users', 'summary'));
    }

    public function show($id)
    {
        $campaignCountSub = DB::table('tb_campaigns')
            ->where('user_id', $id)
            ->count();

        $totalDonation = DB::table('tb_donations')
            ->where('user_id', $id)
            ->where('payment_status', 'success')
            ->sum('amount');

        $user = User::with('bankAccount')->findOrFail($id);

        return view('admin.users.show', [
            'user' => $user,
            'campaignCount' => $campaignCountSub,
            'totalDonation' => $totalDonation,
        ]);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()
                ->back()
                ->with('error', 'Akun admin tidak dapat dinonaktifkan.');
        }

        $user->update([
            'account_status' => $user->account_status === 'active' ? 'suspended' : 'active',
        ]);

        $message = $user->account_status === 'active'
            ? 'Akun user berhasil diaktifkan kembali.'
            : 'Akun user berhasil dinonaktifkan.';

        return redirect()
            ->back()
            ->with('success', $message);
    }
}