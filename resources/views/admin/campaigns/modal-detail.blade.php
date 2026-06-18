<div id="campaignModal" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-[#F8F9FA] rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-100 flex flex-col">
        
        <div class="p-6 border-b border-gray-200 bg-white flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-start space-x-3">
                <div class="p-3 bg-[#F6ECEF] rounded-xl text-[#2D1622]"><i class="fa-solid fa-bullhorn text-lg"></i></div>
                <div>
                    <h2 id="modalTitle" class="text-xl font-bold text-[#2D1622]">Campaign 1</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Tinjau informasi lengkap sebelum memberi keputusan</p>
                </div>
            </div>
            <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>

        <div class="p-8 space-y-8 flex-1">
            <div>
                <h3 class="text-base font-bold text-[#2D1622] mb-4 border-l-4 border-[#2D1622] pl-3">Informasi Campaign</h3>
                
                <div class="w-full h-64 bg-gray-100 rounded-2xl overflow-hidden border border-gray-200 shadow-inner mb-6">
                    <img id="mCampaignImage" src="" alt="Foto Utama Campaign" class="w-full h-full object-cover hidden">
                    <div id="mCampaignImagePlaceholder" class="w-full h-full flex items-center justify-center text-gray-400 text-sm font-medium bg-gray-200">
                        <i class="fa-regular fa-image text-xl mr-2"></i> Tidak ada foto dokumentasi campaign
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm">
                    <div><p class="text-xs text-gray-400">Nama Campaign</p><p id="cTitle" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Kategori</p><p id="cCategory" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Deadline</p><p id="cDeadline" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Status Saat Ini</p><div id="cStatus" class="mt-1"></div></div>
                    <div><p class="text-xs text-gray-400">Target Dana</p><p id="cTarget" class="font-bold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Tanggal Dibuat</p><p id="cCreated" class="font-semibold text-gray-800 mt-1">-</p></div>
                </div>
            </div>

            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <h3 class="text-base font-bold text-[#2D1622] border-l-4 border-[#2D1622] pl-3">Identitas Owner</h3>
                    <span id="ownerBadge" class="text-[10px] font-bold text-white px-3 py-0.5 rounded-full uppercase tracking-wider bg-gray-600">-</span>
                </div>
                <div id="ownerContainer" class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm"></div>
            </div>

            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <h3 class="text-base font-bold text-[#2D1622] border-l-4 border-[#2D1622] pl-3">Identitas Penerima</h3>
                    <span id="beneficiaryBadge" class="text-[10px] font-bold text-white px-3 py-0.5 rounded-full uppercase tracking-wider bg-[#2D1622]">-</span>
                </div>
                <div class="grid grid-cols-2 gap-6 text-sm mb-4">
                    <div><p class="text-xs text-gray-400">Nama</p><p id="bName" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">NIK/No. Organisasi</p><p id="bIdentity" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Nomor Telepon</p><p id="bContact" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Alamat</p><p id="bAddress" class="font-semibold text-gray-800 mt-1">-</p></div>
                </div>
                <div class="text-sm"><p class="text-xs text-gray-400 mb-1">Deskripsi</p><p id="bStory" class="text-gray-600 leading-relaxed bg-white p-4 rounded-xl border border-gray-100 shadow-sm">-</p></div>
            </div>

            <div>
                <h3 class="text-base font-bold text-[#2D1622] mb-4 border-l-4 border-[#2D1622] pl-3">Dokumen Pendukung</h3>
                <div id="documentsContainer" class="space-y-2"></div>
            </div>

            <div id="rejectReasonSection" class="hidden animate-fade-in">
                <h3 class="text-base font-bold text-red-700 mb-3 border-l-4 border-red-600 pl-3">Catatan / Alasan Ditolak</h3>
                <div class="bg-red-50/60 border border-red-200 rounded-2xl p-4 shadow-sm flex items-start space-x-3">
                    <div class="text-red-500 mt-0.5"><i class="fa-solid fa-circle-exclamation text-base"></i></div>
                    <div>
                        <p id="rejectReasonText" class="text-sm text-gray-700 leading-relaxed font-medium">-</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="modalFooter" class="p-6 border-t border-gray-200 bg-white flex items-center justify-end space-x-3 sticky bottom-0">
            <form id="verifyForm" action="" method="POST" class="flex space-x-3 w-full justify-end">
                @csrf
                <input type="hidden" name="status" id="formStatus" value="">
                <button type="button" onclick="submitVerification('rejected')" class="bg-[#FA6B6B] hover:bg-red-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">Tolak Campaign</button>
                <button type="button" onclick="submitVerification('approved')" class="bg-[#55A08E] hover:bg-teal-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">Setujui Campaign</button>
            </form>
        </div>
    </div>
</div>

<div id="confirmApproveModal" class="hidden fixed inset-0 z-[60] bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-[#F8F9FA] rounded-2xl max-w-xl w-full p-6 shadow-xl border border-gray-100">
        <div class="flex items-center space-x-3 border-b border-gray-200 pb-3 mb-4">
            <div class="text-gray-700"><i class="fa-solid fa-circle-check text-lg"></i></div>
            <h4 class="text-lg font-bold text-[#2D1622]">Konfirmasi Verifikasi Campaign</h4>
        </div>
        <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin memverifikasi campaign ini?</p>
        <div class="flex justify-end space-x-2">
            <button type="button" onclick="closeConfirmModal('approved')" class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold rounded-xl transition">Batalkan</button>
            <button type="button" onclick="executeSubmit('approved')" class="px-5 py-2 bg-[#55A08E] hover:bg-teal-700 text-white text-xs font-semibold rounded-xl transition">Ya, Verifikasi</button>
        </div>
    </div>
</div>

<div id="confirmRejectModal" class="hidden fixed inset-0 z-[60] bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-[#F8F9FA] rounded-2xl max-w-xl w-full p-6 shadow-xl border border-gray-100">
        <div class="flex items-center space-x-3 border-b border-gray-200 pb-3 mb-4">
            <div class="text-gray-700"><i class="fa-solid fa-circle-xmark text-lg"></i></div>
            <h4 class="text-lg font-bold text-[#2D1622]">Konfirmasi Penolakan Campaign</h4>
        </div>
        <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menolak campaign ini?</p>
        
        <div class="mb-6">
            <label class="block text-xs font-semibold text-[#2D1622] mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
            <textarea id="modalAdminNotes" rows="3" placeholder="Berikan catatan.." class="w-full px-3 py-2 bg-[#FBF4E4]/30 border border-amber-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#2D1622] transition"></textarea>
            <p id="rejectError" class="hidden text-xs text-red-500 mt-1"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Alasan penolakan wajib diisi!</p>
        </div>

        <div class="flex justify-end space-x-2">
            <button type="button" onclick="closeConfirmModal('rejected')" class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold rounded-xl transition">Batalkan</button>
            <button type="button" onclick="executeSubmit('rejected')" class="px-5 py-2 bg-[#FA6B6B] hover:bg-red-600 text-white text-xs font-semibold rounded-xl transition">Ya, Tolak</button>
        </div>
    </div>
</div>