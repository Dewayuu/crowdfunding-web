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
                                @if($item->status === 'pending')
                                    <span class="inline-flex items-center px-4 py-1 text-xs font-medium bg-[#FBF4E4] text-[#D4A343] rounded-full">
                                        Menunggu
                                    </span>

                                @elseif($item->status === 'approved')
                                    <span class="inline-flex items-center px-4 py-1 text-xs font-medium bg-blue-50 text-blue-600 rounded-full">
                                        Disetujui
                                    </span>

                                @elseif($item->status === 'transferred' || $item->status === 'success')
                                    <span class="inline-flex items-center px-4 py-1 text-xs font-medium bg-[#E6ECE9] text-[#55A08E] rounded-full">
                                        {{ $item->type_code === 'refund' ? 'Selesai' : 'Dana Ditransfer' }}
                                    </span>

                                @elseif($item->status === 'rejected' || $item->status === 'failed')
                                    <span class="inline-flex items-center px-4 py-1 text-xs font-medium bg-[#FDE8E7] text-[#FA6B6B] rounded-full">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ date('d M Y', strtotime($item->tanggal)) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->type_code === 'refund')
                                    <a href="{{ route('admin.disbursements.refund-detail', ['campaignId' => $item->id]) }}"
                                    class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-50 border border-gray-200">
                                        <i class="fa-regular fa-eye text-sm"></i>
                                    </a>

                                    @else

                                    <button
                                    type="button"
                                    onclick="loadDisbursementDetail({{ $item->id }}, '{{ $item->type_code }}')"
                                    class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-50 border border-gray-200"
                                    >
                                        <i class="fa-regular fa-eye text-sm"></i>
                                    </button>

                                    @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                <i class="fa-solid fa-folder-open text-2xl mb-2 block"></i> Belum ada pengajuan dana.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('layouts.pagination', ['items' => $disbursements])
    </div>
</div>

@include('admin.disbursements.modal-detail')

<script>
function loadDisbursementDetail(id, typeCode) {
    fetch(`/admin/disbursements/${id}/${typeCode}`)
        .then(response => {
            if (!response.ok) throw new Error('Gagal mengambil data detail');
            return response.json();
        })
        .then(data => {
            document.getElementById('mdCampaignTitle').innerText = data.campaign_title;
            document.getElementById('mdCategory').innerText = data.category_name ?? '-';
            document.getElementById('mdDeadline').innerText = data.deadline;
            document.getElementById('mdTarget').innerText = data.target_amount;
            document.getElementById('mdCurrent').innerText = data.current_amount;
            document.getElementById('mdAmount').innerText = data.amount_requested;
            document.getElementById('mdPurpose').innerText = data.purpose;
            
            document.getElementById('mdBankOwner').innerText = data.bank_account_name;
            document.getElementById('mdBankNumber').innerText = data.bank_account_number;
            document.getElementById('mdBankName').innerText = data.bank_name;

            let statusDiv = document.getElementById('mdStatus');

            document.getElementById('mdFooterPending').classList.add('hidden');
            document.getElementById('mdFooterApproved').classList.add('hidden');
            document.getElementById('mdUploadContainer').classList.add('hidden');
            document.getElementById('mdRejectedContainer').classList.add('hidden');
            document.getElementById('mdViewProofContainer').classList.add('hidden');

            document.getElementById('mdFormCampaignId').value = data.campaign_id;

            if (data.status === 'pending') {
                statusDiv.innerHTML =
                    `<span class="inline-flex px-3 py-0.5 bg-[#FBF4E4] text-[#D4A343] rounded-full text-xs font-medium">
                        Menunggu
                    </span>`;

                document.getElementById('mdFooterPending').classList.remove('hidden');
            }

            else if (data.status === 'approved') {

                statusDiv.innerHTML =
                    `<span class="inline-flex px-3 py-0.5 bg-blue-50 text-blue-600 rounded-full text-xs font-medium">
                        Disetujui
                    </span>`;

                document.getElementById('mdUploadContainer').classList.remove('hidden');
                document.getElementById('mdFooterApproved').classList.remove('hidden');
            }

            else if (data.status === 'transferred') {

                statusDiv.innerHTML =
                    `<span class="inline-flex px-3 py-0.5 bg-[#E6ECE9] text-[#55A08E] rounded-full text-xs font-medium">
                        Dana Ditransfer
                    </span>`;

                if (data.transfer_proof) {

                    let fileName = data.transfer_proof.split('/').pop();

                    document.getElementById('mdProofFileName').innerText = fileName;
                    document.getElementById('mdProofLink').href = `/storage/${data.transfer_proof}`;

                    document.getElementById('mdViewProofContainer').classList.remove('hidden');
                }
            }

            else if (data.status === 'rejected') {

                statusDiv.innerHTML =
                    `<span class="inline-flex px-3 py-0.5 bg-[#FDE8E7] text-[#FA6B6B] rounded-full text-xs font-medium">
                        Ditolak
                    </span>`;

                document.getElementById('mdRejectionText').innerText =
                    data.rejection_reason ?? 'Tanpa alasan';

                document.getElementById('mdRejectedContainer').classList.remove('hidden');
            }

            let type = data.entity_type;
            document.getElementById('mdOwnerBadge').innerText = type;
            let container = document.getElementById('mdOwnerContainer');

            if(type === 'individual') {
                container.innerHTML = `
                    <div><p class="text-xs text-gray-400">Nama</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.full_name ?? '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Email</p><p class="font-semibold text-gray-800 mt-1">${data.owner_email}</p></div>
                    <div><p class="text-xs text-gray-400">Nomor Telepon</p><p class="font-semibold text-gray-800 mt-1">${data.owner_contact}</p></div>
                    <div><p class="text-xs text-gray-400">NIK</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.national_id_number ?? '-'}</p></div>`;
            } else if(type === 'foundation') {
                container.innerHTML = `
                    <div><p class="text-xs text-gray-400">Nama PIC</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.pic_name ?? '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Nama Foundation</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.foundation_name ?? '-'}</p></div>
                    <div><p class="text-xs text-gray-400">SK Kemenkumham</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.sk_kemenkumham_number ?? '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Alamat</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.foundation_address ?? '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Kontak</p><p class="font-semibold text-gray-800 mt-1">${data.owner_contact} / ${data.owner_email}</p></div>`;
            } else if(type === 'community') {
                container.innerHTML = `
                    <div><p class="text-xs text-gray-400">Nama PIC</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.pic_name ?? '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Nama Komunitas</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.community_name ?? '-'}</p></div>
                    <div><p class="text-xs text-gray-400">URL Sosial Media</p><p class="font-semibold text-blue-600 mt-1 break-all"><a href="${data.owner_detail.social_media_url ?? '#'}" target="_blank">${data.owner_detail.social_media_url ?? '-'}</a></p></div>
                    <div><p class="text-xs text-gray-400">Kontak</p><p class="font-semibold text-gray-800 mt-1">${data.owner_contact} / ${data.owner_email}</p></div>`;
            } else if(type === 'corporate') {
                container.innerHTML = `
                    <div><p class="text-xs text-gray-400">Nama PIC</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.pic_name ?? '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Nama Perusahaan</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.company_name ?? '-'}</p></div>
                    <div><p class="text-xs text-gray-400">NIB / NPWP</p><p class="font-semibold text-gray-800 mt-1">${data.owner_detail.nib ?? '-'} / ${data.owner_detail.npwp ?? '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Kontak</p><p class="font-semibold text-gray-800 mt-1">${data.owner_contact} / ${data.owner_email}</p></div>`;
            }

            document.getElementById('disbursementActionForm').action = `/admin/disbursements/${id}/${typeCode}/update`;
            document.getElementById('disbursementModal').classList.remove('hidden');
        })
        .catch(err => alert('Gagal memuat detail pengajuan dana.'));
}

function closeDisbursementModal() {
    document.getElementById('disbursementModal').classList.add('hidden');
}

function submitDisbursementDecision(status)
{
    if(status === 'approved')
    {
        openConfirmModal('approved');
    }
    else if(status === 'rejected')
    {
        openConfirmModal('rejected');
    }
    else if(status === 'transferred')
    {
        executeSubmit('transferred');
    }
}

function openConfirmModal(type) {
    document.getElementById('disbursementModal').classList.add('hidden');
    
    if (type === 'approved') {
        document.getElementById('confirmApproveModal').classList.remove('hidden');
    } else if (type === 'rejected') {
        document.getElementById('modalAdminNotes').value = '';
        document.getElementById('rejectError').classList.add('hidden');
        document.getElementById('confirmRejectModal').classList.remove('hidden');
    }
}

function closeConfirmModal(type) {
    if (type === 'approved') {
        document.getElementById('confirmApproveModal').classList.add('hidden');
    } else if (type === 'rejected') {
        document.getElementById('confirmRejectModal').classList.add('hidden');
    }
    document.getElementById('disbursementModal').classList.remove('hidden');
}

function executeSubmit(status)
{
    let form = document.getElementById('disbursementActionForm');

    document.getElementById('mdFormStatus').value = status;

    if(status === 'approved')
    {
        form.submit();
        return;
    }

    if(status === 'rejected')
    {
        let reason = document.getElementById('modalAdminNotes').value;

        if(reason.trim() === '')
        {
            document.getElementById('rejectError')
                .classList.remove('hidden');
            return;
        }

        document.getElementById('mdFormRejectionReason').value =
            reason;

        form.submit();
        return;
    }

    if(status === 'transferred')
    {
        let fileInput =
            document.getElementById('mdTransferProofInput');

        if(fileInput.files.length === 0)
        {
            alert('Silakan unggah bukti transfer.');
            return;
        }

        form.submit();
    }
}
</script>
@endsection