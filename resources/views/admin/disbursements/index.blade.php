@extends('layouts.sidebar.admin')

@section('title', 'Pengajuan Dana')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-[#2D1622] tracking-wide mb-8">Pengajuan Dana</h1>

    <form action="{{ route('admin.disbursements') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-3 md:space-y-0 mb-6">
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama campaign, pembuat, atau kategori..." class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2D1622] focus:border-transparent transition shadow-sm">
        </div>

        <div class="relative w-full md:w-48">
            <select name="type" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-sm pr-10">
                <option value="">Jenis Pengajuan</option>
                <option value="disbursement" {{ request('type') == 'disbursement' ? 'selected' : '' }}>Pencairan Dana</option>
                <option value="refund" {{ request('type') == 'refund' ? 'selected' : '' }}>Refund Dana</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></span>
        </div>

        <div class="relative w-full md:w-48">
            <select name="category" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-sm pr-10">
                <option value="">Semua Kategori</option>
                <option value="Pendidikan" {{ request('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                <option value="Sosial" {{ request('category') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                <option value="Kesehatan" {{ request('category') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></span>
        </div>

        @if(request()->filled('search') || request()->filled('type') || request()->filled('category'))
            <a href="{{ route('admin.disbursements') }}" class="inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-xl transition shadow-sm whitespace-nowrap">
                <i class="fa-solid fa-rotate-left mr-2 text-xs"></i> Reset
            </a>
        @endif
    </form>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center shadow-xs">
            <i class="fa-solid fa-circle-check mr-2 text-base"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F6ECEF] border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622] w-1/4">Campaign</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Owner</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Jenis</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($disbursements as $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800 text-sm">{{ $item->campaign_title }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $item->category_name ?? 'Tanpa Kategori' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                {{ $item->owner_name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                {{ $item->jenis }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-4 py-1 text-xs font-medium rounded-full 
                                    {{ $item->status === 'pending' ? 'bg-[#FBF4E4] text-[#D4A343]' : 
                                    ($item->status === 'approved' || $item->status === 'success' || $item->status === 'transferred' ? 'bg-[#E6ECE9] text-[#55A08E]' : 'bg-[#FDE8E7] text-[#FA6B6B]') }}">
                                    {{ $item->status === 'pending' ? 'Menunggu' : 
                                    ($item->status === 'approved' || $item->status === 'success' || $item->status === 'transferred' ? 'Disetujui' : 'Ditolak') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ date('d M Y', strtotime($item->tanggal)) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="button" onclick="loadDisbursementDetail({{ $item->id }}, '{{ $item->type_code }}')" class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-50 border border-gray-200 text-gray-400 hover:text-[#2D1622] hover:border-gray-300 transition shadow-sm">
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        @endforelse
                </tbody>
            </table>
        </div>

        @include('layouts.pagination', ['items' => $disbursements])
    </div>
</div>

<script>
function loadDisbursementDetail(id) {
    console.log("Membuka detail pengajuan dana ID:", id);
}
</script>
@endsection