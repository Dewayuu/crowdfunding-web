@extends('layouts.sidebar.user') @section('title', 'Campaign Saya')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-3xl font-bold text-[#2D1622] tracking-wide">Campaign Saya</h1>
        <a href="#" class="inline-flex items-center justify-center px-6 py-3 bg-[#EE7D43] hover:bg-[#d66a34] text-white text-sm font-semibold rounded-xl transition shadow-sm whitespace-nowrap">
            + Create Campaign
        </a>
    </div>

    <form action="{{ route('user.campaigns') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-3 md:space-y-0">
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama campaign, pembuat, atau kategori..." class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-xs">
        </div>

        <div class="relative w-full md:w-48">
            <select name="status" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-xs pr-10">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></span>
        </div>

        <div class="relative w-full md:w-48">
            <select name="category" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-xs pr-10">
                <option value="">Semua Kategori</option>
                <option value="Pendidikan" {{ request('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                <option value="Sosial" {{ request('category') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                <option value="Kesehatan" {{ request('category') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></span>
        </div>

        @if(request()->filled('search') || request()->filled('status') || request()->filled('category'))
            <a href="{{ route('user.campaigns') }}" class="inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-xl transition whitespace-nowrap">
                <i class="fa-solid fa-rotate-left mr-2 text-xs"></i> Reset
            </a>
        @endif
    </form>

    <div class="space-y-4">
        @forelse($campaigns as $campaign)
            @php
                // Hitung persentase capaian dana secara dinamis
                $percent = $campaign->target_amount > 0 ? min(100, round(($campaign->current_amount / $campaign->target_amount) * 100)) : 0;
            @endphp
            
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-xs flex flex-col justify-between relative group hover:border-gray-300 transition">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                    <div class="space-y-2 flex-1">
                        <div>
                            @if($campaign->verification_status === 'pending')
                                <span class="inline-flex items-center px-3 py-0.5 text-xs font-semibold text-[#D4A343] bg-[#FBF4E4] rounded-full">Menunggu</span>
                            @elseif($campaign->verification_status === 'approved')
                                <span class="inline-flex items-center px-3 py-0.5 text-xs font-semibold text-[#55A08E] bg-[#E6ECE9] rounded-full">Terverifikasi</span>
                            @else
                                <span class="inline-flex items-center px-3 py-0.5 text-xs font-semibold text-[#FA6B6B] bg-[#FDE8E7] rounded-full">Ditolak</span>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $campaign->title }}</h3>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $campaign->category?->category_name ?? 'Tanpa Kategori' }}</p>
                        </div>
                    </div>

                    <div class="self-end md:self-start">
                        <a href="#" class="px-4 py-1.5 border border-gray-200 text-xs font-semibold text-gray-400 hover:text-[#2D1622] hover:border-gray-300 rounded-lg transition bg-gray-50/50">
                            Lihat Detail
                        </a>
                    </div>
                </div>

                @if($campaign->verification_status === 'approved')
                    <div class="mt-6 space-y-2">
                        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-[#EE7D43] h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                        <p class="text-xs font-medium text-gray-400">
                            Terkumpul <span class="text-[#EE7D43] font-bold">Rp{{ number_format($campaign->current_amount, 0, ',', '.') }}</span> 
                            dari Rp{{ number_format($campaign->target_amount, 0, ',', '.') }} • <span class="text-gray-700 font-bold">{{ $percent }}%</span>
                        </p>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center text-sm text-gray-400 shadow-xs">
                <i class="fa-solid fa-folder-open text-3xl mb-2 block text-gray-300"></i> Anda belum pernah membuat campaign.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        @include('layouts.pagination', ['items' => $campaigns])
    </div>
</div>
@endsection