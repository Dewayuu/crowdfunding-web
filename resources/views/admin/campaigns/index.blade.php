@extends('layouts.sidebar.admin')

@section('title', 'Manage Campaign')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-[#2D1622] tracking-wide mb-8">Kelola Pengajuan Campaign</h1>

    <form action="{{ route('admin.campaigns') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-3 md:space-y-0 mb-6">
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama campaign..." class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2D1622] focus:border-transparent transition shadow-sm">
        </div>

        <div class="relative w-full md:w-48">
            <select name="status" onchange="this.form.submit()" class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-sm pr-10">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
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
    </form>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center shadow-xs animate-fade-in">
            <i class="fa-solid fa-circle-check mr-2 text-base"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F6ECEF] border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622] w-2/5">Campaign</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Owner</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Target</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622]">Tanggal Diajukan</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-[#2D1622] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($campaigns as $campaign)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800 text-sm">{{ $campaign->title }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $campaign->category?->category_name ?? 'Tanpa Kategori' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span class="font-medium block">{{ $campaign->user?->username }}</span>
                                <span class="text-xs text-gray-400 uppercase">[{{ $campaign->user?->entity_type }}]</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">Rp{{ number_format($campaign->target_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-4 py-1 text-xs font-medium rounded-full {{ $campaign->verification_status === 'pending' ? 'bg-[#FBF4E4] text-[#D4A343]' : ($campaign->verification_status === 'approved' ? 'bg-[#E6ECE9] text-[#55A08E]' : 'bg-[#FDE8E7] text-[#FA6B6B]') }}">
                                    {{ $campaign->verification_status === 'pending' ? 'Menunggu' : ($campaign->verification_status === 'approved' ? 'Terverifikasi' : 'Ditolak') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $campaign->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <button type="button" onclick="loadCampaignDetail({{ $campaign->campaign_id }})" class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-50 border border-gray-200 text-gray-400 hover:text-[#2D1622] hover:border-gray-300 transition shadow-sm">
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                <i class="fa-solid fa-folder-open text-2xl mb-2 block"></i> Belum ada pengajuan campaign.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('layouts.pagination', ['items' => $campaigns])

    </div>
</div>

@include('admin.campaigns.modal-detail')

<script>
function loadCampaignDetail(id) {
    fetch(`/admin/campaigns/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Server bermasalah (Error 500)');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('modalTitle').innerText = data.title;
            document.getElementById('cTitle').innerText = data.title;
            document.getElementById('cCategory').innerText = data.category ? data.category.category_name : '-';
            document.getElementById('cDeadline').innerText = new Date(data.end_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            document.getElementById('cTarget').innerText = 'Rp' + new Intl.NumberFormat('id-ID').format(data.target_amount);
            document.getElementById('cCreated').innerText = new Date(data.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

            let imgElement = document.getElementById('mCampaignImage');
            let placeholderElement = document.getElementById('mCampaignImagePlaceholder');

            let primaryImage = data.images.find(img => img.is_primary === 'yes') || data.images[0];

            if (primaryImage && primaryImage.image) {
                imgElement.src = `/storage/${primaryImage.image}`;
                imgElement.classList.remove('hidden');
                placeholderElement.classList.add('hidden');
            } else {
                imgElement.classList.add('hidden');
                placeholderElement.classList.remove('hidden');
            }

            let statusDiv = document.getElementById('cStatus');
            if(data.verification_status === 'pending') {
                statusDiv.innerHTML = `<span class="inline-flex px-3 py-0.5 bg-[#FBF4E4] text-[#D4A343] rounded-full text-xs font-medium">Menunggu</span>`;
                document.getElementById('modalFooter').classList.remove('hidden');
            } else {
                statusDiv.innerHTML = data.verification_status === 'approved' ? 
                    `<span class="inline-flex px-3 py-0.5 bg-[#E6ECE9] text-[#55A08E] rounded-full text-xs font-medium">Terverifikasi</span>` :
                    `<span class="inline-flex px-3 py-0.5 bg-[#FDE8E7] text-[#FA6B6B] rounded-full text-xs font-medium">Ditolak</span>`;
                document.getElementById('modalFooter').classList.add('hidden');
            }

            let type = data.user.entity_type;
            let badge = document.getElementById('ownerBadge');
            let container = document.getElementById('ownerContainer');
            badge.innerText = type;

            let bankName = data.user.bank_account ? data.user.bank_account.bank_name : '-';
            let bankNum = data.user.bank_account ? data.user.bank_account.account_number : '-';

            if(type === 'individual') {
                let individual = data.user.detail_individual;
                container.innerHTML = `
                    <div><p class="text-xs text-gray-400">Nama</p><p class="font-semibold text-gray-800 mt-1">${individual ? individual.full_name : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Email</p><p class="font-semibold text-gray-800 mt-1">${data.user.email}</p></div>
                    <div><p class="text-xs text-gray-400">No. Rekening</p><p class="font-semibold text-gray-800 mt-1">${bankNum}</p></div>
                    <div><p class="text-xs text-gray-400">Nomor Telepon</p><p class="font-semibold text-gray-800 mt-1">${data.user.contact_number}</p></div>
                    <div><p class="text-xs text-gray-400">NIK</p><p class="font-semibold text-gray-800 mt-1">${individual ? individual.national_id_number : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Nama Bank</p><p class="font-semibold text-gray-800 mt-1">${bankName}</p></div>`;
            } else if(type === 'foundation') {
                let foundation = data.user.detail_foundation;
                container.innerHTML = `
                    <div><p class="text-xs text-gray-400">Nama PIC</p><p class="font-semibold text-gray-800 mt-1">${foundation ? foundation.pic_name : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Nama Foundation</p><p class="font-semibold text-gray-800 mt-1">${foundation ? foundation.foundation_name : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">SK Kemenkumham</p><p class="font-semibold text-gray-800 mt-1">${foundation ? foundation.sk_kemenkumham_number : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">NIK PIC</p><p class="font-semibold text-gray-800 mt-1">${foundation ? foundation.pic_national_id_number : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Alamat</p><p class="font-semibold text-gray-800 mt-1">${foundation ? foundation.foundation_address : '-'}</p></div>
                    <!-- 🟢 KOREKSI: Menghapus class 'truncate' agar baris otomatis turun (wrap) -->
                    <div><p class="text-xs text-gray-400">Kontak</p><p class="font-semibold text-gray-800 mt-1">${data.user.contact_number} / ${data.user.email}</p></div>`;
            } else if(type === 'community') {
                let community = data.user.detail_community;
                container.innerHTML = `
                    <div><p class="text-xs text-gray-400">Nama PIC</p><p class="font-semibold text-gray-800 mt-1">${community ? community.pic_name : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Nama Komunitas</p><p class="font-semibold text-gray-800 mt-1">${community ? community.community_name : '-'}</p></div>
                    <!-- 🟢 KOREKSI: Mengganti 'truncate' dengan 'break-all' agar link panjang terpotong ke bawah dengan aman -->
                    <div><p class="text-xs text-gray-400">URL Sosial Media</p><p class="font-semibold text-blue-600 mt-1 break-all"><a href="${community ? community.social_media_url : '#'}" target="_blank">${community ? community.social_media_url : '-'}</a></p></div>
                    <div><p class="text-xs text-gray-400">NIK PIC</p><p class="font-semibold text-gray-800 mt-1">${community ? community.pic_national_id_number : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Tipe Komunitas</p><p class="font-semibold text-gray-800 mt-1">${community ? community.community_type : '-'}</p></div>
                    <!-- 🟢 KOREKSI: Menghapus class 'truncate' -->
                    <div><p class="text-xs text-gray-400">Kontak</p><p class="font-semibold text-gray-800 mt-1">${data.user.contact_number} / ${data.user.email}</p></div>`;
            } else if(type === 'corporate') {
                let corporate = data.user.detail_corporate;
                container.innerHTML = `
                    <div><p class="text-xs text-gray-400">Nama PIC</p><p class="font-semibold text-gray-800 mt-1">${corporate ? corporate.pic_name : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Nama Perusahaan</p><p class="font-semibold text-gray-800 mt-1">${corporate ? corporate.company_name : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">Alamat</p><p class="font-semibold text-gray-800 mt-1">${corporate ? corporate.company_address : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">NIK PIC</p><p class="font-semibold text-gray-800 mt-1">${corporate ? corporate.pic_national_id_number : '-'}</p></div>
                    <div><p class="text-xs text-gray-400">NIB / NPWP</p><p class="font-semibold text-gray-800 mt-1">${corporate ? corporate.nib : '-'} / ${corporate ? corporate.npwp : '-'}</p></div>
                    <!-- 🟢 KOREKSI: Menghapus class 'truncate' -->
                    <div><p class="text-xs text-gray-400">Kontak</p><p class="font-semibold text-gray-800 mt-1">${data.user.contact_number} / ${data.user.email}</p></div>`;
            }

            document.getElementById('beneficiaryBadge').innerText = data.beneficiary ? data.beneficiary.beneficiary_type : '-';
            document.getElementById('bName').innerText = data.beneficiary ? data.beneficiary.name : '-';
            document.getElementById('bIdentity').innerText = data.beneficiary ? data.beneficiary.identity_number : '-';
            document.getElementById('bContact').innerText = data.beneficiary ? data.beneficiary.contact_number : '-';
            document.getElementById('bAddress').innerText = data.beneficiary ? data.beneficiary.address : '-';
            document.getElementById('bStory').innerText = data.beneficiary ? data.beneficiary.description : '-';

            let docContainer = document.getElementById('documentsContainer');
            docContainer.innerHTML = '';

            if(data.beneficiary && data.beneficiary.document_path) {
                let fileName = data.beneficiary.document_path.split('/').pop();

                docContainer.innerHTML = `
                    <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-gray-300 transition">
                        <div class="flex items-center space-x-3">
                            <div class="text-red-500 text-lg"><i class="fa-solid fa-file-pdf"></i></div>
                            <div>
                                <p class="text-sm text-gray-800">${fileName}</p>
                            </div>
                        </div>
                        <a href="/storage/${data.beneficiary.document_path}" download class="text-gray-400 hover:text-[#2D1622] transition-colors p-2 rounded-lg hover:bg-gray-50">
                            <i class="fa-solid fa-download text-base"></i>
                        </a>
                    </div>`;
            } else {
                docContainer.innerHTML = `
                    <div class="p-4 bg-gray-50 rounded-xl text-center text-xs text-gray-400 border border-dashed border-gray-200">
                        <i class="fa-regular fa-folder-open text-base mb-1 block text-gray-300"></i> Tidak ada dokumen pendukung yang diunggah.
                    </div>`;
            }

            let rejectSection = document.getElementById('rejectReasonSection');
            let rejectText = document.getElementById('rejectReasonText');

            if (data.verification_status === 'rejected' && data.admin_notes) {
                rejectText.innerText = data.admin_notes;
                rejectSection.classList.remove('hidden'); // Membuka kotak merah catatan
            } else {
                rejectSection.classList.add('hidden'); // Menyembunyikan jika tidak ditolak
            }

            document.getElementById('verifyForm').action = `/admin/campaigns/${data.campaign_id}/verify`;
            document.getElementById('campaignModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data. Pastikan Model & Route backend sudah sinkron.');
        });
}

function closeModal() {
    document.getElementById('campaignModal').classList.add('hidden');
}

function submitVerification(status) {
    document.getElementById('formStatus').value = status;

    if (status === 'approved') {
        document.getElementById('confirmApproveModal').classList.remove('hidden');
    } else if (status === 'rejected') {
        document.getElementById('modalAdminNotes').value = '';
        document.getElementById('rejectError').classList.add('hidden');
        document.getElementById('confirmRejectModal').classList.remove('hidden');
    }
}

function closeConfirmModal(status) {
    if (status === 'approved') {
        document.getElementById('confirmApproveModal').classList.add('hidden');
    } else if (status === 'rejected') {
        document.getElementById('confirmRejectModal').classList.add('hidden');
    }
}

function executeSubmit(status) {
    let form = document.getElementById('verifyForm');

    if (status === 'rejected') {
        let notesValue = document.getElementById('modalAdminNotes').value.trim();
        let errorTxt = document.getElementById('rejectError');

        if (notesValue === '') {
            errorTxt.classList.remove('hidden');
            return;
        }

        let inputNotes = document.createElement('input');
        inputNotes.type = 'hidden';
        inputNotes.name = 'admin_notes';
        inputNotes.value = notesValue;
        form.appendChild(inputNotes);
    }

    form.submit();
}
</script>
@endsection