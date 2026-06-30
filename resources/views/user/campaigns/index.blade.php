@extends('layouts.sidebar.user') @section('title', 'Campaign Saya')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-3xl font-bold text-[#2D1622] tracking-wide">Campaign Saya</h1>
        <a href="{{ route('user.campaigns.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#EE7D43] hover:bg-[#d66a34] text-white text-sm font-semibold rounded-xl transition shadow-sm whitespace-nowrap">
            + Create Campaign
        </a>
    </div>

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
                                <span class="inline-flex items-center text-xs text-gray-400 font-medium">
                                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i>
                                    <span>Deadline: {{ $campaign->end_date ? \Carbon\Carbon::parse($campaign->end_date)->translatedFormat('d M Y') : '-' }}</span>
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-0.5 text-xs font-semibold text-[#FA6B6B] bg-[#FDE8E7] rounded-full">Ditolak</span>
<<<<<<< HEAD
=======
                                @if($campaign->admin_notes)
                                    <div class="mt-2 text-xs text-red-600 bg-red-50 p-3 rounded-lg border border-red-100">
                                        <span class="font-bold block mb-0.5">Alasan Penolakan:</span>
                                        {{ $campaign->admin_notes }}
                                    </div>
                                @endif
>>>>>>> main
                            @endif
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $campaign->title }}</h3>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $campaign->category?->category_name ?? 'Tanpa Kategori' }}</p>
                        </div>
                    </div>

                    <div class="self-end md:self-start flex flex-col space-y-2 min-w-[110px]">
<<<<<<< HEAD
                        <a href="{{ route('user.campaigns.owner-detail', ['id' => $campaign->campaign_id]) }}" class="text-center px-4 py-1.5 border border-gray-200 text-xs font-semibold text-gray-500 hover:text-[#2D1622] hover:bg-[#F6ECEF] hover:border-gray-300 rounded-lg transition bg-gray-50/50 shadow-2xs">
                            Lihat Detail
                        </a>
                        
                        <a href="{{ route('user.campaigns.edit', ['id' => $campaign->campaign_id]) }}" class="text-center px-4 py-1.5 border border-gray-200 text-xs font-semibold text-gray-500 hover:text-[#2D1622] hover:bg-[#F6ECEF] hover:border-gray-300 rounded-lg transition bg-white shadow-2xs">
                            <i class="fa-regular fa-pen-to-square mr-1"></i> Edit
                        </a>
=======
                        <a href="{{ route('user.campaigns.edit', ['id' => $campaign->campaign_id]) }}" class="text-center px-4 py-1.5 border border-gray-200 text-xs font-semibold text-gray-500 hover:text-[#2D1622] hover:bg-[#F6ECEF] hover:border-gray-300 rounded-lg transition bg-white shadow-2xs">
                            <i class="fa-regular fa-pen-to-square mr-1"></i> Edit
                        </a>

                        @if($campaign->last_disbursement && $campaign->last_disbursement->disbursement_status === 'rejected')
                            <div class="mt-2 text-[10px] text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                <span class="font-bold block">Pencairan Ditolak:</span>
                                {{ $campaign->last_disbursement->rejection_reason }}
                            </div>
                        @endif

                        @php
                            $isPending = $campaign->last_disbursement && $campaign->last_disbursement->disbursement_status === 'pending';
                        @endphp

                        @if($campaign->disbursement_option === 'REQUESTED')
                            <div class="w-full text-center px-4 py-2 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold rounded-lg flex flex-col gap-2 items-center justify-center">
                                @if($campaign->last_disbursement)
                                    <div class="flex items-center">
                                        <i class="fa-solid fa-clock-rotate-left mr-2"></i> 
                                        {{ $campaign->last_disbursement->disbursement_status === 'pending' ? 'Sedang Diproses Admin' : 'Sudah Diproses' }}
                                    </div>
                                    
                                    @if($campaign->last_disbursement->transfer_proof)
                                        <a href="{{ asset('storage/' . $campaign->last_disbursement->transfer_proof) }}" 
                                        target="_blank" 
                                        class="block w-full py-1 bg-white border border-blue-200 text-blue-600 rounded hover:bg-blue-100 transition text-[10px]">
                                            <i class="fa-solid fa-file-invoice mr-1"></i> Lihat Bukti Transfer
                                        </a>
                                    @endif

                                @elseif($campaign->has_refund)
                                    <div class="flex items-center">
                                        <i class="fa-solid fa-rotate-left mr-2"></i> 
                                        Dana Direfund ke Donatur
                                    </div>
                                @endif
                            </div>
                        @elseif($campaign->disbursement_option === 'ALLOW_DISBURSE')
                            <form action="{{ route('user.campaigns.disburse', $campaign->campaign_id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    {{ $isPending ? 'disabled' : '' }}
                                    class="w-full text-center px-4 py-1.5 {{ $isPending ? 'bg-gray-400 cursor-not-allowed' : 'bg-[#55A08E] hover:bg-teal-700' }} text-white text-xs font-semibold rounded-lg transition">
                                    {{ $isPending ? 'Sedang Diproses' : 'Cairkan Dana' }}
                                </button>
                            </form>
                        
                        @elseif($campaign->disbursement_option === 'SHOW_CHOICE')
                            <div class="flex gap-2">
                                <form action="{{ route('user.campaigns.disburse', $campaign->campaign_id) }}" method="POST" 
                                    onsubmit="return confirmAction(this, 'Apakah Anda yakin ingin mencairkan dana campaign ini? Pastikan data bank Anda sudah benar.');">
                                    @csrf
                                    <button type="submit" 
                                        {{ $isPending ? 'disabled' : '' }}
                                        class="w-full text-center px-4 py-1.5 {{ $isPending ? 'bg-gray-400 cursor-not-allowed' : 'bg-[#55A08E] hover:bg-teal-700' }} text-white text-xs font-semibold rounded-lg transition">
                                        {{ $isPending ? 'Sedang Diproses' : 'Cairkan Dana' }}
                                    </button>
                                </form>
                                <form action="{{ route('user.campaigns.refund', $campaign->campaign_id) }}" method="POST" class="flex-1" 
                                    onsubmit="return confirmAction(this, 'PERINGATAN: Campaign akan dibatalkan dan semua donasi akan dikembalikan. Aksi ini tidak dapat dibatalkan.');">
                                    @csrf
                                    <button type="submit" class="w-full text-center px-2 py-1.5 bg-red-500 text-white text-[10px] font-semibold rounded-lg hover:bg-red-600 transition">Refund</button>
                                </form>
                            </div>
                        @endif
>>>>>>> main
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
<<<<<<< HEAD
@endsection
=======
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmAction(formElement, message) {
        event.preventDefault(); 
        Swal.fire({
            title: 'Konfirmasi Aksi',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#55A08E',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                formElement.submit(); 
            }
        });
    }
</script>
>>>>>>> main
