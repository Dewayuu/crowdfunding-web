@extends('layouts.sidebar.user') @section('title', 'Riwayat Donasi')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-3xl font-bold text-[#2D1622] tracking-wide">Riwayat Donasi</h1>
        <a href="{{ route('campaigns.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#EE7D43] hover:bg-[#d66a34] text-white text-sm font-semibold rounded-xl transition shadow-sm whitespace-nowrap">
            <i class="fa-solid fa-hand-holding-heart mr-2"></i> Donasi Sekarang
        </a>
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('error'))
        <div class="w-full p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium flex items-center shadow-xs animate-fade-in">
            <i class="fa-solid fa-circle-exclamation mr-3 text-base flex-shrink-0"></i> 
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="w-full p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center shadow-xs animate-fade-in">
            <i class="fa-solid fa-circle-check mr-3 text-base flex-shrink-0"></i> 
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- STATISTIK RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#FDE7D7] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-wallet text-[#EE7D43]"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Total Donasi Berhasil</p>
                    <p class="text-lg font-bold text-[#2D1622]">Rp{{ number_format($totalDonated, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#E6ECE9] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-[#55A08E]"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Total Transaksi</p>
                    <p class="text-lg font-bold text-[#2D1622]">{{ $totalTransactions }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#EEF4E4] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-circle-check text-[#78913E]"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Transaksi Berhasil</p>
                    <p class="text-lg font-bold text-[#2D1622]">{{ $successTransactions }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <form action="{{ route('user.donations') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-3 md:space-y-0">
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama campaign atau order ID..." class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-xs">
        </div>

        <div class="relative w-full md:w-48">
            <select name="status" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-xs pr-10">
                <option value="">Semua Status</option>
                <option value="settlement" {{ request('status') == 'settlement' ? 'selected' : '' }}>Berhasil</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="expire" {{ request('status') == 'expire' ? 'selected' : '' }}>Kedaluwarsa</option>
                <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Dibatalkan</option>
                <option value="deny" {{ request('status') == 'deny' ? 'selected' : '' }}>Ditolak</option>
                <option value="refund" {{ request('status') == 'refund' ? 'selected' : '' }}>Refund</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></span>
        </div>

        <div class="relative w-full md:w-48">
            <select name="sort" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-xs pr-10">
                <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></span>
        </div>

        @if(request()->filled('search') || request()->filled('status') || request()->filled('sort'))
            <a href="{{ route('user.donations') }}" class="inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-xl transition whitespace-nowrap">
                <i class="fa-solid fa-rotate-left mr-2 text-xs"></i> Reset
            </a>
        @endif
    </form>

    {{-- DAFTAR DONASI --}}
    <div class="space-y-4">
        @forelse($donations as $donation)
            @php
                $statusMap = [
                    'settlement' => ['label' => 'Berhasil', 'text' => 'text-[#55A08E]', 'bg' => 'bg-[#E6ECE9]', 'icon' => 'fa-circle-check'],
                    'pending'    => ['label' => 'Menunggu', 'text' => 'text-[#D4A343]', 'bg' => 'bg-[#FBF4E4]', 'icon' => 'fa-clock'],
                    'expire'     => ['label' => 'Kedaluwarsa', 'text' => 'text-[#9CA3AF]', 'bg' => 'bg-gray-100', 'icon' => 'fa-clock-rotate-left'],
                    'cancel'     => ['label' => 'Dibatalkan', 'text' => 'text-[#FA6B6B]', 'bg' => 'bg-[#FDE8E7]', 'icon' => 'fa-ban'],
                    'deny'       => ['label' => 'Ditolak', 'text' => 'text-[#FA6B6B]', 'bg' => 'bg-[#FDE8E7]', 'icon' => 'fa-xmark'],
                    'refund'     => ['label' => 'Refund', 'text' => 'text-[#7C6FD4]', 'bg' => 'bg-[#EEEAF9]', 'icon' => 'fa-rotate-left'],
                ];
                $status = $statusMap[$donation->payment_status] ?? ['label' => ucfirst($donation->payment_status ?? '-'), 'text' => 'text-gray-500', 'bg' => 'bg-gray-100', 'icon' => 'fa-question'];
                $campaign = $donation->campaign;
            @endphp

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-xs hover:border-gray-300 transition group">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">

                    {{-- INFO UTAMA --}}
                    <div class="flex-1 space-y-3">
                        {{-- STATUS BADGE + TANGGAL --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center px-3 py-0.5 text-xs font-semibold {{ $status['text'] }} {{ $status['bg'] }} rounded-full">
                                <i class="fa-solid {{ $status['icon'] }} mr-1.5"></i>
                                {{ $status['label'] }}
                            </span>
                            <span class="inline-flex items-center text-xs text-gray-400 font-medium">
                                <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i>
                                {{ $donation->created_at ? $donation->created_at->translatedFormat('d M Y, H:i') : '-' }}
                            </span>
                            @if($donation->is_anonymous === 'yes')
                                <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-semibold text-gray-500 bg-gray-100 rounded-full">
                                    <i class="fa-solid fa-eye-slash mr-1"></i> Anonim
                                </span>
                            @endif
                        </div>

                        {{-- NAMA CAMPAIGN --}}
                        <div>
                            @if($campaign)
                                <a href="{{ route('campaigns.show', $campaign->campaign_id) }}" class="text-lg font-bold text-gray-800 hover:text-[#EE7D43] transition">
                                    {{ $campaign->title }}
                                </a>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $campaign->category?->category_name ?? 'Tanpa Kategori' }}</p>
                            @else
                                <h3 class="text-lg font-bold text-gray-800">Campaign Tidak Ditemukan</h3>
                            @endif
                        </div>

                        {{-- NOMINAL DONASI --}}
                        <div class="flex flex-wrap items-center gap-4">
                            <div>
                                <p class="text-xs text-gray-400">Nominal Donasi</p>
                                <p class="text-xl font-bold text-[#EE7D43]">Rp{{ number_format($donation->amount, 0, ',', '.') }}</p>
                            </div>
                            @if($donation->payment_method)
                                <div>
                                    <p class="text-xs text-gray-400">Metode Pembayaran</p>
                                    <p class="text-sm font-semibold text-gray-700">{{ strtoupper($donation->payment_method) }}</p>
                                </div>
                            @endif
                            @if($donation->paid_at)
                                <div>
                                    <p class="text-xs text-gray-400">Dibayar Pada</p>
                                    <p class="text-sm font-semibold text-gray-700">{{ $donation->paid_at->translatedFormat('d M Y, H:i') }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- PESAN DUKUNGAN --}}
                        @if($donation->support_message)
                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                <p class="text-xs text-gray-400 mb-1"><i class="fa-regular fa-message mr-1"></i> Pesan Dukungan</p>
                                <p class="text-sm text-gray-600 italic">"{{ $donation->support_message }}"</p>
                            </div>
                        @endif

                        {{-- REFUND INFO --}}
                        @if($donation->refund)
                            <div class="bg-[#EEEAF9] rounded-lg p-3 border border-[#DDD6F3]">
                                <p class="text-xs text-[#7C6FD4] font-semibold mb-1"><i class="fa-solid fa-rotate-left mr-1"></i> Informasi Refund</p>
                                <p class="text-sm text-gray-600">
                                    Status: 
                                    <span class="font-semibold">
                                        @if($donation->refund->refund_status === 'pending')
                                            Menunggu Diproses
                                        @elseif($donation->refund->refund_status === 'completed')
                                            Selesai
                                        @else
                                            {{ ucfirst($donation->refund->refund_status) }}
                                        @endif
                                    </span>
                                </p>
                                @if($donation->refund->transfer_proof)
                                    <a href="{{ asset('storage/' . $donation->refund->transfer_proof) }}" target="_blank" class="inline-flex items-center mt-2 text-xs font-semibold text-[#7C6FD4] hover:text-[#5a4fb3] transition">
                                        <i class="fa-solid fa-file-invoice mr-1"></i> Lihat Bukti Transfer Refund
                                    </a>
                                @endif
                            </div>
                        @endif

                        {{-- ORDER ID --}}
                        @if($donation->midtrans_order_id)
                            <p class="text-[11px] text-gray-400 font-mono">Order ID: {{ $donation->midtrans_order_id }}</p>
                        @endif
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="self-end md:self-start flex flex-col space-y-2 min-w-[130px]">
                        @if($campaign)
                            <a href="{{ route('campaigns.show', $campaign->campaign_id) }}" class="text-center px-4 py-1.5 border border-gray-200 text-xs font-semibold text-gray-500 hover:text-[#2D1622] hover:bg-[#F6ECEF] hover:border-gray-300 rounded-lg transition bg-white shadow-2xs">
                                <i class="fa-solid fa-eye mr-1"></i> Lihat Campaign
                            </a>
                        @endif

                        @if($donation->payment_status === 'pending' && $donation->snap_token)
                            <button 
                                onclick="retryPayment('{{ $donation->snap_token }}')" 
                                class="text-center px-4 py-1.5 bg-[#EE7D43] hover:bg-[#d66a34] text-white text-xs font-semibold rounded-lg transition shadow-sm">
                                <i class="fa-solid fa-credit-card mr-1"></i> Bayar Sekarang
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center text-sm text-gray-400 shadow-xs">
                <i class="fa-solid fa-receipt text-3xl mb-2 block text-gray-300"></i>
                Anda belum memiliki riwayat donasi.
                <div class="mt-4">
                    <a href="{{ route('campaigns.index') }}" class="inline-flex items-center px-5 py-2.5 bg-[#EE7D43] hover:bg-[#d66a34] text-white text-sm font-semibold rounded-xl transition shadow-sm">
                        <i class="fa-solid fa-hand-holding-heart mr-2"></i> Mulai Berdonasi
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        @include('layouts.pagination', ['items' => $donations])
    </div>
</div>
@endsection

{{-- SCRIPT UNTUK BAYAR ULANG MIDTRANS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function retryPayment(snapToken) {
        snap.pay(snapToken, {
            onSuccess: function(result) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pembayaran berhasil dilakukan.',
                    confirmButtonColor: '#EE7D43'
                }).then(() => {
                    location.reload();
                });
            },
            onPending: function(result) {
                Swal.fire({
                    icon: 'info',
                    title: 'Tertunda',
                    text: 'Pembayaran masih menunggu konfirmasi.',
                    confirmButtonColor: '#EE7D43'
                });
            },
            onError: function(result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Pembayaran gagal. Silakan coba lagi.',
                    confirmButtonColor: '#EE7D43'
                });
            },
            onClose: function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Dibatalkan',
                    text: 'Popup pembayaran ditutup.',
                    confirmButtonColor: '#EE7D43'
                });
            }
        });
    }
</script>
