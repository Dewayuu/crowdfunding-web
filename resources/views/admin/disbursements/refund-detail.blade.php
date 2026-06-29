@extends('layouts.sidebar.admin')

@section('title', 'Detail Pengembalian Dana')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <div>
        <a href="{{ route('admin.disbursements') }}" class="text-xs font-semibold text-gray-500 hover:text-[#2D1622] transition flex items-center space-x-1 w-fit">
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span>Kembali</span>
        </a>
        <h1 class="text-3xl font-bold text-[#2D1622] tracking-wide mt-2">Detail Pengembalian Dana</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-4">
            <div>
                <span class="text-[9px] font-bold text-white px-2.5 py-1 rounded bg-[#2D1622] uppercase tracking-wider">Informasi Campaign</span>
                <h3 class="text-base font-bold text-gray-800 mt-2">{{ $campaign->title }}</h3>
                <p class="text-xs text-gray-400 mt-0.5">Kategori: {{ $campaign->category?->category_name ?? '-' }} • Kategori ID: #CAT-{{ str_pad($campaign->category_id, 2, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                    <p class="text-gray-400">Target Dana</p>
                    <p class="font-bold text-gray-800 mt-0.5">Rp{{ number_format($campaign->target_amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Dana Terkumpul</p>
                    <p class="font-bold text-emerald-600 mt-0.5">Rp{{ number_format($campaign->current_amount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-4">
            <div>
                <span class="text-[9px] font-bold text-red-700 px-2.5 py-1 rounded bg-red-50 border border-red-100 uppercase tracking-wider">Identitas Owner</span>
                <h3 class="text-base font-bold text-gray-800 mt-2">{{ $ownerName }}</h3>
                <p class="text-xs text-gray-400 mt-0.5">Entity Type: <span class="capitalize">{{ $campaign->user?->entity_type }}</span></p>
            </div>
            <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                    <p class="text-gray-400">Kontak Penanggungjawab</p>
                    <p class="font-medium text-gray-700 mt-0.5 break-all">{{ $campaign->user?->contact_number }} • {{ $campaign->user?->email }}</p>
                </div>
                <div>
                    <p class="text-gray-400">{{ $identityLabel }}</p>
                    <p class="font-medium text-gray-700 mt-0.5 font-mono">
                        {{ $identityValue }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-[#2D1622] text-white rounded-2xl p-6 shadow-xs flex flex-col justify-between">
            <div>
                <span class="text-[9px] font-bold text-[#2D1622] px-2.5 py-1 rounded bg-[#F6ECEF] uppercase tracking-wider">Ringkasan Antrean</span>
                <div class="flex items-baseline space-x-2 mt-2">
                    <span class="text-4xl font-black tracking-tight">{{ $totalDonatur }}</span>
                    <span class="text-xs text-gray-300">Donatur</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 text-xs border-t border-white/10 pt-4 mt-4">
                <div>
                    <p class="text-gray-400">Total Nilai Refund</p>
                    <p class="font-bold text-amber-300 mt-0.5">Rp{{ number_format($totalRefundAmount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Sudah Diproses</p>
                    <p class="font-bold text-emerald-400 mt-0.5">{{ $processedCount }} dari {{ $totalDonatur }} Antrean</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ URL::current() }}" method="GET" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-3 md:space-y-0">
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama donatur atau ID..." class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-xs">
        </div>

        <div class="relative w-full md:w-48">
            <select name="status" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-xs pr-10">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Selesai</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></span>
        </div>

        <div class="w-full md:w-auto">
            <a href="{{ route('admin.disbursements.export-refund', $campaign->campaign_id) }}" class="inline-flex items-center justify-center w-full px-4 py-3 bg-[#55A08E] hover:bg-teal-700 text-white text-sm font-semibold rounded-xl transition shadow-sm whitespace-nowrap">
                <i class="fa-solid fa-file-csv mr-2 text-base"></i> Ekspor Rekening
            </a>
        </div>

        @if(request()->filled('search') || request()->filled('status'))
            <a href="{{ URL::current() }}" class="inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-xl transition whitespace-nowrap">
                <i class="fa-solid fa-rotate-left mr-2 text-xs"></i> Reset
            </a>
        @endif
    </form>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F6ECEF] border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622] w-12 text-center">NO</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622] w-1/4">DONATUR</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622] w-1/4">REKENING TUJUAN</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">NOMINAL</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622] w-1/4">BUKTI TRANSFER</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622] text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($refundItems as $index => $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 text-center text-sm text-gray-400 font-medium">
                                {{ $refundItems->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-mono font-bold text-gray-400 block">{{ $item->midtrans_order_id ?? '#DON-'.$item->donation_id }}</span>
                                <div class="font-semibold text-gray-800 text-sm mt-0.5">{{ $item->donor_name }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">Via {{ strtoupper($item->payment_method) }} • {{ \Carbon\Carbon::parse($item->donation_date)->translatedFormat('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-block text-[10px] font-bold px-2 py-0.5 bg-amber-50 text-amber-600 border border-amber-200 rounded uppercase tracking-wide">
                                        {{ $item->bank_name ?? 'BANK' }}
                                    </span>
                                    <span class="font-semibold text-gray-800">{{ $item->account_number ?? '-' }}</span>
                                </div>
                                <span class="text-xs text-gray-400 block mt-1">a.n {{ $item->account_name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold {{ $item->refund_status === 'success' ? 'text-gray-400 line-through' : 'text-red-500' }}">
                                Rp{{ number_format($item->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($item->refund_status === 'pending')
                                    <form action="{{ route('admin.disbursements.process-refund', $item->refund_id) }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                                        @csrf
                                        <div class="relative flex-1">
                                            <input type="file" name="transfer_proof" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName(this)">
                                            <div class="border border-dashed border-gray-300 bg-gray-50/50 hover:bg-gray-50 px-3 py-1.5 rounded-lg flex items-center justify-between text-xs text-gray-400 transition select-none">
                                                <span class="file-name-label truncate max-w-[120px]"><i class="fa-solid fa-cloud-arrow-up mr-1"></i> Pilih Bukti...</span>
                                            </div>
                                        </div>
                                        <button type="submit" class="bg-[#2D1622] hover:bg-[#462435] text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-xs">Kirim</button>
                                    </form>
                                @elseif($item->refund_status === 'success')
                                    <div class="flex items-center space-x-2 text-xs text-emerald-600 font-medium">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <a href="/storage/{!! $item->transfer_proof !!}" target="_blank" class="hover:underline flex items-center space-x-1">
                                            <span>Lihat Bukti Transfer</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">Gagal diproses</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-4 py-1 text-xs font-medium rounded-full 
                                    {{ $item->refund_status === 'pending' ? 'bg-[#FBF4E4] text-[#D4A343]' : 
                                       ($item->refund_status === 'success' ? 'bg-[#E6ECE9] text-[#55A08E]' : 'bg-[#FDE8E7] text-[#FA6B6B]') }}">
                                    {{ $item->refund_status === 'pending' ? 'Menunggu' : ($item->refund_status === 'success' ? 'Selesai' : 'Gagal') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                <i class="fa-solid fa-folder-open text-2xl mb-2 block"></i> Tidak ada antrean pengembalian dana.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @include('layouts.pagination', ['items' => $refundItems])
    </div>
</div>

<script>
function updateFileName(input) {
    let label = input.parentElement.querySelector('.file-name-label');
    if (input.files.length > 0) {
        label.innerHTML = `<i class="fa-solid fa-image mr-1"></i> ${input.files[0].name}`;
        label.classList.remove('text-gray-400');
        label.classList.add('text-gray-700', 'font-medium');
    } else {
        label.innerHTML = `<i class="fa-solid fa-cloud-arrow-up mr-1"></i> Pilih Bukti...`;
        label.classList.add('text-gray-400');
        label.classList.remove('text-gray-700', 'font-medium');
    }
}
</script>
@endsection