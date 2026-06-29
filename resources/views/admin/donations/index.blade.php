@extends('layouts.sidebar.admin') @section('title', 'Data Donasi')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#2D1622] tracking-wide">Data Donasi</h1>
            <p class="text-sm text-gray-400 mt-1">Seluruh transaksi donasi di platform HatiNurani</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl transition shadow-sm whitespace-nowrap">
            <i class="fa-solid fa-arrow-left mr-2 text-xs"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- STATISTIK RINGKASAN --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#EEF4E4] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-wallet text-[#78913E]"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Total Donasi Berhasil</p>
                    <p class="text-lg font-bold text-[#2D1622]">Rp{{ number_format($totalAmount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#FBF4E4] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-[#D4A343]"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Total Transaksi</p>
                    <p class="text-lg font-bold text-[#2D1622]">{{ number_format($totalCount) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#E6ECE9] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-circle-check text-[#55A08E]"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Transaksi Berhasil</p>
                    <p class="text-lg font-bold text-[#2D1622]">{{ number_format($successCount) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#FDE7D7] rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-clock text-[#EE7D43]"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Transaksi Pending</p>
                    <p class="text-lg font-bold text-[#2D1622]">{{ number_format($pendingCount) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <form action="{{ route('admin.donations') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-3 md:space-y-0">
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari donatur, campaign, order ID, atau email..." class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-sm">
        </div>

        <div class="relative w-full md:w-44">
            <select name="status" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-sm pr-10">
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

        @if($paymentMethods->count() > 0)
        <div class="relative w-full md:w-44">
            <select name="method" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-sm pr-10">
                <option value="">Semua Metode</option>
                @foreach($paymentMethods as $method)
                    <option value="{{ $method }}" {{ request('method') == $method ? 'selected' : '' }}>{{ strtoupper($method) }}</option>
                @endforeach
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></span>
        </div>
        @endif

        <div class="relative w-full md:w-40">
            <select name="sort" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-sm pr-10">
                <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                <option value="terbesar" {{ request('sort') == 'terbesar' ? 'selected' : '' }}>Nominal ↓</option>
                <option value="terkecil" {{ request('sort') == 'terkecil' ? 'selected' : '' }}>Nominal ↑</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></span>
        </div>

        @if(request()->filled('search') || request()->filled('status') || request()->filled('method') || request()->filled('sort'))
            <a href="{{ route('admin.donations') }}" class="inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-xl transition shadow-sm whitespace-nowrap">
                <i class="fa-solid fa-rotate-left mr-2 text-xs"></i> Reset
            </a>
        @endif
    </form>

    {{-- TABEL DATA DONASI --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F6ECEF] border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Donatur</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Campaign</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Nominal</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Metode</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($donations as $donation)
                        @php
                            $statusMap = [
                                'settlement' => ['label' => 'Berhasil', 'text' => 'text-[#55A08E]', 'bg' => 'bg-[#E6ECE9]', 'icon' => 'fa-circle-check'],
                                'pending'    => ['label' => 'Menunggu', 'text' => 'text-[#D4A343]', 'bg' => 'bg-[#FBF4E4]', 'icon' => 'fa-clock'],
                                'expire'     => ['label' => 'Expired', 'text' => 'text-gray-500', 'bg' => 'bg-gray-100', 'icon' => 'fa-clock-rotate-left'],
                                'cancel'     => ['label' => 'Batal', 'text' => 'text-[#FA6B6B]', 'bg' => 'bg-[#FDE8E7]', 'icon' => 'fa-ban'],
                                'deny'       => ['label' => 'Ditolak', 'text' => 'text-[#FA6B6B]', 'bg' => 'bg-[#FDE8E7]', 'icon' => 'fa-xmark'],
                                'refund'     => ['label' => 'Refund', 'text' => 'text-[#7C6FD4]', 'bg' => 'bg-[#EEEAF9]', 'icon' => 'fa-rotate-left'],
                            ];
                            $st = $statusMap[$donation->payment_status] ?? ['label' => ucfirst($donation->payment_status ?? '-'), 'text' => 'text-gray-500', 'bg' => 'bg-gray-100', 'icon' => 'fa-question'];
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition">
                            {{-- DONATUR --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-[#F6ECEF] flex items-center justify-center flex-shrink-0">
                                        @if($donation->is_anonymous === 'yes')
                                            <i class="fa-solid fa-eye-slash text-[10px] text-gray-400"></i>
                                        @else
                                            <span class="text-xs font-bold text-[#2D1622]">{{ strtoupper(substr($donation->donor_name ?? '?', 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-semibold text-gray-800 truncate max-w-[140px]">
                                            {{ $donation->is_anonymous === 'yes' ? 'Anonim' : ($donation->donor_name ?? '-') }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 truncate max-w-[140px]">
                                            {{ $donation->user?->email ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- CAMPAIGN --}}
                            <td class="px-6 py-4">
                                @if($donation->campaign)
                                    <div class="text-sm font-medium text-gray-800 truncate max-w-[180px]">{{ $donation->campaign->title }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $donation->campaign->category?->category_name ?? '-' }}</div>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>

                            {{-- NOMINAL --}}
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-[#2D1622]">Rp{{ number_format($donation->amount, 0, ',', '.') }}</span>
                            </td>

                            {{-- METODE --}}
                            <td class="px-6 py-4">
                                @if($donation->payment_method)
                                    <span class="inline-flex items-center px-2.5 py-1 bg-gray-50 border border-gray-200 rounded-lg text-[10px] font-semibold text-gray-600 uppercase">
                                        {{ $donation->payment_method }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium {{ $st['text'] }} {{ $st['bg'] }} rounded-full">
                                    <i class="fa-solid {{ $st['icon'] }} mr-1.5 text-[10px]"></i>
                                    {{ $st['label'] }}
                                </span>
                            </td>

                            {{-- TANGGAL --}}
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700">{{ $donation->created_at?->format('d M Y') }}</div>
                                <div class="text-[10px] text-gray-400">{{ $donation->created_at?->format('H:i') }} WIB</div>
                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4 text-center">
                                <button type="button" onclick="showDonationDetail({{ $donation->donation_id }})" class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-50 border border-gray-200 text-gray-400 hover:text-[#2D1622] hover:border-gray-300 transition shadow-sm" title="Detail Donasi">
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-400">
                                <i class="fa-solid fa-receipt text-2xl mb-2 block text-gray-300"></i>
                                Belum ada data donasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('layouts.pagination', ['items' => $donations])
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{-- MODAL DETAIL DONASI --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<div id="donationDetailModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeDonationModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto relative">

            {{-- Header --}}
            <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                <h3 class="text-lg font-bold text-[#2D1622]">Detail Donasi</h3>
                <button onclick="closeDonationModal()" class="p-1.5 rounded-lg hover:bg-gray-100 transition text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 space-y-5" id="modalBody">
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#EE7D43]"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showDonationDetail(donationId) {
    const modal = document.getElementById('donationDetailModal');
    const body = document.getElementById('modalBody');
    modal.classList.remove('hidden');

    // Cari data donasi dari tabel
    @php $allDonations = []; @endphp
    @foreach($donations as $d)
        @php $allDonations[] = $d; @endphp
    @endforeach

    const donations = @json($donations->items());
    const donation = donations.find(d => d.donation_id == donationId);

    if (!donation) {
        body.innerHTML = '<p class="text-center text-gray-400 py-8">Data tidak ditemukan.</p>';
        return;
    }

    const statusMap = {
        'settlement': { label: 'Berhasil', text: 'text-[#55A08E]', bg: 'bg-[#E6ECE9]' },
        'pending': { label: 'Menunggu', text: 'text-[#D4A343]', bg: 'bg-[#FBF4E4]' },
        'expire': { label: 'Expired', text: 'text-gray-500', bg: 'bg-gray-100' },
        'cancel': { label: 'Batal', text: 'text-[#FA6B6B]', bg: 'bg-[#FDE8E7]' },
        'deny': { label: 'Ditolak', text: 'text-[#FA6B6B]', bg: 'bg-[#FDE8E7]' },
        'refund': { label: 'Refund', text: 'text-[#7C6FD4]', bg: 'bg-[#EEEAF9]' },
    };

    const st = statusMap[donation.payment_status] || { label: donation.payment_status || '-', text: 'text-gray-500', bg: 'bg-gray-100' };
    const donorName = donation.is_anonymous === 'yes' ? 'Anonim' : (donation.donor_name || '-');
    const amount = new Intl.NumberFormat('id-ID').format(donation.amount);
    const createdAt = donation.created_at ? new Date(donation.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-';
    const paidAt = donation.paid_at ? new Date(donation.paid_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-';
    const campaignTitle = donation.campaign ? donation.campaign.title : '-';
    const campaignCategory = donation.campaign && donation.campaign.category ? donation.campaign.category.category_name : '-';
    const userEmail = donation.user ? donation.user.email : '-';
    const paymentMethod = donation.payment_method ? donation.payment_method.toUpperCase() : '-';
    const orderId = donation.midtrans_order_id || '-';

    let refundHtml = '';
    if (donation.refund) {
        const refundStatus = donation.refund.refund_status === 'success' ? 'Selesai' : (donation.refund.refund_status === 'pending' ? 'Menunggu' : donation.refund.refund_status);
        refundHtml = `
            <div class="bg-[#EEEAF9] rounded-xl p-4 border border-[#DDD6F3]">
                <p class="text-xs text-[#7C6FD4] font-semibold mb-2"><i class="fa-solid fa-rotate-left mr-1"></i> Informasi Refund</p>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Status Refund</span>
                    <span class="font-semibold text-gray-800">${refundStatus}</span>
                </div>
            </div>`;
    }

    let messageHtml = '';
    if (donation.support_message) {
        messageHtml = `
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <p class="text-xs text-gray-400 mb-1"><i class="fa-regular fa-message mr-1"></i> Pesan Dukungan</p>
                <p class="text-sm text-gray-600 italic">"${donation.support_message}"</p>
            </div>`;
    }

    const campaignLink = donation.campaign ? `{{ url('/campaigns') }}/${donation.campaign.campaign_id}` : '#';

    body.innerHTML = `
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400">Donatur</p>
                <p class="text-lg font-bold text-[#2D1622]">${donorName}</p>
                <p class="text-xs text-gray-400">${userEmail}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold ${st.text} ${st.bg} rounded-full">${st.label}</span>
        </div>

        <div class="bg-[#FBF4E4] rounded-xl p-4 text-center">
            <p class="text-xs text-gray-500">Nominal Donasi</p>
            <p class="text-2xl font-bold text-[#EE7D43] mt-1">Rp${amount}</p>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                <span class="text-sm text-gray-500">Campaign</span>
                <span class="text-sm font-semibold text-right text-gray-800 max-w-[220px] truncate">${campaignTitle}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <span class="text-sm text-gray-500">Kategori</span>
                <span class="text-sm font-semibold text-gray-800">${campaignCategory}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <span class="text-sm text-gray-500">Metode Pembayaran</span>
                <span class="text-sm font-semibold text-gray-800">${paymentMethod}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <span class="text-sm text-gray-500">Order ID</span>
                <span class="text-xs font-mono text-gray-600">${orderId}</span>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <span class="text-sm text-gray-500">Tanggal Donasi</span>
                <span class="text-sm font-semibold text-gray-800">${createdAt}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-gray-500">Tanggal Dibayar</span>
                <span class="text-sm font-semibold text-gray-800">${paidAt}</span>
            </div>
        </div>

        ${messageHtml}
        ${refundHtml}

        <div class="pt-2">
            <a href="${campaignLink}" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition">
                <i class="fa-solid fa-eye mr-2 text-xs"></i> Lihat Campaign
            </a>
        </div>
    `;
}

function closeDonationModal() {
    document.getElementById('donationDetailModal').classList.add('hidden');
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDonationModal();
});
</script>
@endsection
