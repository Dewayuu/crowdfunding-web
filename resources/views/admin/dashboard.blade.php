@extends('layouts.sidebar.admin') @section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#2D1622] tracking-wide">Dashboard</h1>
            <p class="text-sm text-gray-400 mt-1">Ringkasan data platform HatiNurani</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.campaigns') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#EE7D43] hover:bg-[#d66a34] text-white text-sm font-semibold rounded-xl transition shadow-sm whitespace-nowrap">
                <i class="fa-solid fa-bullhorn mr-2 text-xs"></i> Kelola Campaign
            </a>
            <a href="{{ route('admin.donations') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl transition shadow-sm whitespace-nowrap">
                <i class="fa-solid fa-hand-holding-dollar mr-2 text-xs"></i> Data Donasi
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- STATISTIK UTAMA (4 CARD) --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total User --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs hover:shadow-sm transition">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 bg-[#EEEAF9] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-users text-[#7C6FD4]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Total User</p>
                    <p class="text-2xl font-bold text-[#2D1622]">{{ number_format($totalUsers) }}</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-[11px] text-gray-400">
                    <i class="fa-solid fa-arrow-up text-[#55A08E] mr-1"></i>
                    <span class="text-[#55A08E] font-semibold">{{ $newUsersThisMonth }}</span> user baru bulan ini
                </p>
            </div>
        </div>

        {{-- Total Campaign --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs hover:shadow-sm transition">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 bg-[#FDE7D7] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-bullhorn text-[#EE7D43]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Total Campaign</p>
                    <p class="text-2xl font-bold text-[#2D1622]">{{ number_format($totalCampaigns) }}</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-[11px] text-gray-400">
                    <span class="text-[#55A08E] font-semibold">{{ $campaignsActive }}</span> aktif ·
                    <span class="text-[#D4A343] font-semibold">{{ $campaignsPending }}</span> menunggu
                </p>
            </div>
        </div>

        {{-- Total Donasi Terkumpul --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs hover:shadow-sm transition">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 bg-[#EEF4E4] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-wallet text-[#78913E]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Total Donasi Terkumpul</p>
                    <p class="text-2xl font-bold text-[#2D1622]">Rp{{ number_format($totalDonations, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-[11px] text-gray-400">
                    <span class="text-[#55A08E] font-semibold">{{ number_format($donationsSettlement) }}</span> transaksi berhasil
                </p>
            </div>
        </div>

        {{-- Total Transaksi --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs hover:shadow-sm transition">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 bg-[#FBF4E4] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-[#D4A343]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-400 font-medium">Total Transaksi</p>
                    <p class="text-2xl font-bold text-[#2D1622]">{{ number_format($totalTransactions) }}</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-[11px] text-gray-400">
                    <span class="text-[#D4A343] font-semibold">{{ $donationsPending }}</span> pending ·
                    <span class="text-gray-500 font-semibold">{{ $donationsExpired }}</span> expired
                </p>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- BARIS 2: STATUS BREAKDOWN + CHART --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- STATUS BREAKDOWN (2 kolom) --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Status Campaign --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-[#2D1622]">Status Campaign</h2>
                    <a href="{{ route('admin.campaigns') }}" class="text-xs text-[#EE7D43] font-semibold hover:underline">Lihat Semua →</a>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 bg-[#D4A343] rounded-full"></span>
                            <span class="text-sm text-gray-600">Menunggu Verifikasi</span>
                        </div>
                        <span class="text-sm font-bold text-[#2D1622] bg-[#FBF4E4] px-3 py-0.5 rounded-full">{{ $campaignsPending }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 bg-[#55A08E] rounded-full"></span>
                            <span class="text-sm text-gray-600">Terverifikasi</span>
                        </div>
                        <span class="text-sm font-bold text-[#2D1622] bg-[#E6ECE9] px-3 py-0.5 rounded-full">{{ $campaignsApproved }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 bg-[#FA6B6B] rounded-full"></span>
                            <span class="text-sm text-gray-600">Ditolak</span>
                        </div>
                        <span class="text-sm font-bold text-[#2D1622] bg-[#FDE8E7] px-3 py-0.5 rounded-full">{{ $campaignsRejected }}</span>
                    </div>
                </div>
            </div>

            {{-- Pencairan & Refund --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-[#2D1622]">Pencairan & Refund</h2>
                    <a href="{{ route('admin.disbursements') }}" class="text-xs text-[#EE7D43] font-semibold hover:underline">Lihat Semua →</a>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 bg-[#D4A343] rounded-full"></span>
                            <span class="text-sm text-gray-600">Pencairan Pending</span>
                        </div>
                        <span class="text-sm font-bold text-[#2D1622] bg-[#FBF4E4] px-3 py-0.5 rounded-full">{{ $disbursementsPending }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 bg-[#55A08E] rounded-full"></span>
                            <span class="text-sm text-gray-600">Pencairan Ditransfer</span>
                        </div>
                        <span class="text-sm font-bold text-[#2D1622] bg-[#E6ECE9] px-3 py-0.5 rounded-full">{{ $disbursementsTransferred }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 bg-[#7C6FD4] rounded-full"></span>
                            <span class="text-sm text-gray-600">Refund Pending</span>
                        </div>
                        <span class="text-sm font-bold text-[#2D1622] bg-[#EEEAF9] px-3 py-0.5 rounded-full">{{ $refundsPending }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 bg-[#78913E] rounded-full"></span>
                            <span class="text-sm text-gray-600">Refund Selesai</span>
                        </div>
                        <span class="text-sm font-bold text-[#2D1622] bg-[#EEF4E4] px-3 py-0.5 rounded-full">{{ $refundsCompleted }}</span>
                    </div>
                </div>
                @if($totalDisbursedAmount > 0)
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <p class="text-xs text-gray-400">Total Dana Dicairkan</p>
                    <p class="text-lg font-bold text-[#2D1622]">Rp{{ number_format($totalDisbursedAmount, 0, ',', '.') }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- CHART DONASI 6 BULAN (3 kolom) --}}
        <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-200 p-6 shadow-xs">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-sm font-bold text-[#2D1622]">Tren Donasi</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Data donasi berhasil 6 bulan terakhir</p>
                </div>
                <a href="{{ route('admin.donations') }}" class="text-xs text-[#EE7D43] font-semibold hover:underline">Detail →</a>
            </div>
            <canvas id="donationChart" height="210"></canvas>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- BARIS 3: TABEL CAMPAIGN TERBARU + DONASI TERBARU --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Campaign Pengajuan Terbaru --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-bold text-[#2D1622]">Campaign Terbaru</h2>
                <a href="{{ route('admin.campaigns') }}" class="text-xs text-[#EE7D43] font-semibold hover:underline">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-[#F6ECEF]">
                            <th class="px-5 py-3 text-[10px] font-bold uppercase text-[#2D1622]">Campaign</th>
                            <th class="px-5 py-3 text-[10px] font-bold uppercase text-[#2D1622]">Owner</th>
                            <th class="px-5 py-3 text-[10px] font-bold uppercase text-[#2D1622]">Status</th>
                            <th class="px-5 py-3 text-[10px] font-bold uppercase text-[#2D1622]">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($latestCampaigns as $campaign)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3">
                                    <div class="text-sm font-semibold text-gray-800 truncate max-w-[180px]">{{ $campaign->title }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $campaign->category?->category_name ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-600">{{ $campaign->user?->username ?? '-' }}</td>
                                <td class="px-5 py-3">
                                    @if($campaign->verification_status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-semibold text-[#D4A343] bg-[#FBF4E4] rounded-full">Menunggu</span>
                                    @elseif($campaign->verification_status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-semibold text-[#55A08E] bg-[#E6ECE9] rounded-full">Terverifikasi</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-semibold text-[#FA6B6B] bg-[#FDE8E7] rounded-full">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-[11px] text-gray-400">{{ $campaign->created_at?->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-xs text-gray-400">
                                    <i class="fa-solid fa-folder-open text-lg mb-1 block text-gray-300"></i> Belum ada campaign.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Donasi Terbaru --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-sm font-bold text-[#2D1622]">Donasi Terbaru</h2>
                <a href="{{ route('admin.donations') }}" class="text-xs text-[#EE7D43] font-semibold hover:underline">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-[#F6ECEF]">
                            <th class="px-5 py-3 text-[10px] font-bold uppercase text-[#2D1622]">Donatur</th>
                            <th class="px-5 py-3 text-[10px] font-bold uppercase text-[#2D1622]">Campaign</th>
                            <th class="px-5 py-3 text-[10px] font-bold uppercase text-[#2D1622]">Nominal</th>
                            <th class="px-5 py-3 text-[10px] font-bold uppercase text-[#2D1622]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($latestDonations as $donation)
                            @php
                                $statusMap = [
                                    'settlement' => ['label' => 'Berhasil', 'text' => 'text-[#55A08E]', 'bg' => 'bg-[#E6ECE9]'],
                                    'pending'    => ['label' => 'Menunggu', 'text' => 'text-[#D4A343]', 'bg' => 'bg-[#FBF4E4]'],
                                    'expire'     => ['label' => 'Expired', 'text' => 'text-gray-500', 'bg' => 'bg-gray-100'],
                                    'cancel'     => ['label' => 'Batal', 'text' => 'text-[#FA6B6B]', 'bg' => 'bg-[#FDE8E7]'],
                                    'deny'       => ['label' => 'Ditolak', 'text' => 'text-[#FA6B6B]', 'bg' => 'bg-[#FDE8E7]'],
                                ];
                                $st = $statusMap[$donation->payment_status] ?? ['label' => ucfirst($donation->payment_status ?? '-'), 'text' => 'text-gray-500', 'bg' => 'bg-gray-100'];
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3">
                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ $donation->is_anonymous === 'yes' ? 'Anonim' : ($donation->donor_name ?? '-') }}
                                    </div>
                                    <div class="text-[10px] text-gray-400">{{ $donation->created_at?->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-600 truncate max-w-[140px]">{{ $donation->campaign?->title ?? '-' }}</td>
                                <td class="px-5 py-3 text-sm font-bold text-[#2D1622]">Rp{{ number_format($donation->amount, 0, ',', '.') }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-semibold {{ $st['text'] }} {{ $st['bg'] }} rounded-full">{{ $st['label'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-xs text-gray-400">
                                    <i class="fa-solid fa-receipt text-lg mb-1 block text-gray-300"></i> Belum ada transaksi donasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- BARIS 4: PENCAIRAN PENDING + QUICK ACTIONS --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Pencairan Menunggu --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <h2 class="text-sm font-bold text-[#2D1622]">Pencairan Menunggu Proses</h2>
                    @if($disbursementsPending > 0)
                        <span class="inline-flex items-center justify-center w-5 h-5 bg-[#FA6B6B] text-white text-[10px] font-bold rounded-full">{{ $disbursementsPending }}</span>
                    @endif
                </div>
                <a href="{{ route('admin.disbursements') }}" class="text-xs text-[#EE7D43] font-semibold hover:underline">Lihat Semua →</a>
            </div>
            @if($pendingDisbursements->count() > 0)
                <div class="divide-y divide-gray-50">
                    @foreach($pendingDisbursements as $disb)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 transition">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $disb->campaign?->title ?? '-' }}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">
                                    oleh {{ $disb->campaign?->user?->username ?? '-' }} ·
                                    Rp{{ number_format($disb->amount_requested, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('admin.disbursements.show', ['id' => $disb->disbursement_id, 'type' => 'disbursement']) }}" class="ml-4 px-3 py-1.5 bg-gray-50 border border-gray-200 text-xs font-semibold text-gray-500 hover:text-[#2D1622] hover:border-gray-300 rounded-lg transition">
                                <i class="fa-regular fa-eye mr-1"></i> Review
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-10 text-center text-xs text-gray-400">
                    <i class="fa-solid fa-circle-check text-2xl mb-2 block text-[#55A08E]/40"></i>
                    Semua pencairan sudah diproses.
                </div>
            @endif
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
            <h2 class="text-sm font-bold text-[#2D1622] mb-4">Aksi Cepat</h2>
            <div class="space-y-2.5">
                <a href="{{ route('admin.campaigns') }}?status=pending" class="flex items-center space-x-3 p-3 rounded-xl bg-[#FBF4E4] hover:bg-[#F7ECD5] transition group">
                    <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-clipboard-check text-[#D4A343] text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#2D1622] group-hover:text-[#D4A343] transition">Verifikasi Campaign</p>
                        <p class="text-[10px] text-gray-400">{{ $campaignsPending }} campaign menunggu</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
                </a>

                <a href="{{ route('admin.disbursements') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-[#EEEAF9] hover:bg-[#E3DEF5] transition group">
                    <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-money-bill-transfer text-[#7C6FD4] text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#2D1622] group-hover:text-[#7C6FD4] transition">Proses Pencairan</p>
                        <p class="text-[10px] text-gray-400">{{ $disbursementsPending }} pengajuan pending</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
                </a>

                <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-[#E6ECE9] hover:bg-[#D9E5DE] transition group">
                    <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-user-gear text-[#55A08E] text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#2D1622] group-hover:text-[#55A08E] transition">Kelola User</p>
                        <p class="text-[10px] text-gray-400">{{ $totalUsers }} user terdaftar</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
                </a>

                <a href="{{ route('admin.donations') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-[#FDE7D7] hover:bg-[#FBDAC6] transition group">
                    <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-hand-holding-dollar text-[#EE7D43] text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#2D1622] group-hover:text-[#EE7D43] transition">Lihat Data Donasi</p>
                        <p class="text-[10px] text-gray-400">{{ $totalTransactions }} total transaksi</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
                </a>
            </div>
        </div>
    </div>

</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('donationChart').getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(238, 125, 67, 0.25)');
        gradient.addColorStop(1, 'rgba(238, 125, 67, 0.02)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Total Donasi (Rp)',
                    data: @json($chartAmounts),
                    borderColor: '#EE7D43',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#EE7D43',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }, {
                    label: 'Jumlah Transaksi',
                    data: @json($chartCounts),
                    borderColor: '#7C6FD4',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#7C6FD4',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    yAxisID: 'y1',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            font: { size: 11, family: 'Inter' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#2D1622',
                        titleFont: { family: 'Inter', size: 12 },
                        bodyFont: { family: 'Inter', size: 11 },
                        cornerRadius: 10,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                                return context.raw + ' transaksi';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, family: 'Inter' }, color: '#9CA3AF' }
                    },
                    y: {
                        position: 'left',
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: {
                            font: { size: 10, family: 'Inter' },
                            color: '#9CA3AF',
                            callback: function(val) {
                                if (val >= 1000000) return 'Rp' + (val / 1000000).toFixed(1) + 'jt';
                                if (val >= 1000) return 'Rp' + (val / 1000).toFixed(0) + 'rb';
                                return 'Rp' + val;
                            }
                        }
                    },
                    y1: {
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: {
                            font: { size: 10, family: 'Inter' },
                            color: '#9CA3AF',
                            stepSize: 1,
                        }
                    }
                }
            }
        });
    });
</script>
@endsection