<div id="disbursementModal" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-[#F8F9FA] rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-100 flex flex-col">
        
        <div class="p-6 border-b border-gray-200 bg-white flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-start space-x-3">
                <div class="p-3 bg-[#F6ECEF] rounded-xl text-[#2D1622]"><i class="fa-solid fa-money-bill-transfer text-lg"></i></div>
                <div>
                    <h2 id="mModalTitle" class="text-xl font-bold text-[#2D1622]">Detail Pengajuan Dana</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Tinjau informasi lengkap sebelum memberi keputusan</p>
                </div>
            </div>
            <button type="button" onclick="closeDisbursementModal()" class="text-gray-400 hover:text-gray-600 transition"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>

        <div class="p-8 space-y-8 flex-1">
            <div>
                <h3 class="text-base font-bold text-[#2D1622] mb-4 border-l-4 border-[#2D1622] pl-3">Informasi Campaign</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm">
                    <div><p class="text-xs text-gray-400">Nama Campaign</p><p id="mdCampaignTitle" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Kategori</p><p id="mdCategory" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Deadline</p><p id="mdDeadline" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Status Saat Ini</p><div id="mdStatus" class="mt-1"></div></div>
                    <div><p class="text-xs text-gray-400">Target Dana</p><p id="mdTarget" class="font-bold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Total Dana Terkumpul</p><p id="mdCurrent" class="font-bold text-emerald-600 mt-1">-</p></div>
                </div>
            </div>

            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <h3 class="text-base font-bold text-[#2D1622] border-l-4 border-[#2D1622] pl-3">Identitas Owner</h3>
                    <span id="mdOwnerBadge" class="text-[10px] font-bold text-white px-3 py-0.5 rounded-full uppercase tracking-wider bg-gray-600">-</span>
                </div>
                <div id="mdOwnerContainer" class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm"></div>
            </div>

            <div>
                <h3 class="text-base font-bold text-[#2D1622] mb-4 border-l-4 border-[#2D1622] pl-3">Informasi Rekening Tujuan</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm">
                    <div><p class="text-xs text-gray-400">Nama Pemilik</p><p id="mdBankOwner" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">No. Rekening</p><p id="mdBankNumber" class="font-semibold text-gray-800 mt-1">-</p></div>
                    <div><p class="text-xs text-gray-400">Nama Bank</p><p id="mdBankName" class="font-semibold text-gray-800 mt-1">-</p></div>
                </div>
            </div>

            <div>
                <h3 class="text-base font-bold text-[#2D1622] mb-4 border-l-4 border-[#2D1622] pl-3">Informasi Pengajuan Dana</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm mb-4">
                    <div><p class="text-xs text-gray-400">Nominal Pencairan</p><p id="mdAmount" class="font-bold text-gray-800 mt-1 text-lg">-</p></div>
                </div>
                <div class="text-sm"><p class="text-xs text-gray-400 mb-1">Deskripsi/Tujuan</p><p id="mdPurpose" class="text-gray-600 leading-relaxed bg-white p-4 rounded-xl border border-gray-100 shadow-sm">-</p></div>
            </div>

            <div id="mdActionSection" class="space-y-4">
                <h3 class="text-base font-bold text-[#2D1622] border-l-4 border-[#2D1622] pl-3">Bukti Transfer</h3>
                <form id="disbursementActionForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" id="mdFormStatus">
                    <input type="hidden" name="campaign_id" id="mdFormCampaignId">
                    <input type="hidden" name="rejection_reason" id="mdFormRejectionReason">
                    
                    <div id="mdUploadContainer" class="hidden">
                        <label class="block text-xs text-gray-400 mb-2">Unggah Bukti Transfer Resmi <span class="text-red-500">*</span></label>
                        <input type="file" name="transfer_proof" id="mdTransferProofInput" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#F6ECEF] file:text-[#2D1622] hover:file:bg-[#ebd5dd] border border-gray-200 bg-white p-3 rounded-2xl shadow-inner">
                    </div>

                    <div id="mdRejectedContainer" class="hidden bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm">
                        <p class="font-semibold"><i class="fa-solid fa-circle-xmark mr-1"></i> Alasan Penolakan:</p>
                        <p id="mdRejectionText" class="mt-1 text-gray-600">-</p>
                    </div>

                    <div id="mdViewProofContainer" class="hidden">
                        <p class="text-xs text-gray-400 mb-2">Bukti Pembayaran Terlampir:</p>
                        <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl shadow-sm">
                            <div class="flex items-center space-x-3">
                                <div class="text-orange-500 text-2xl"><i class="fa-solid fa-file-image"></i></div>
                                <div>
                                    <p id="mdProofFileName" class="text-sm font-semibold text-gray-800">Bukti Transfer.jpg</p>
                                    <p class="text-xs text-gray-400">Berkas Terverifikasi Sistem</p>
                                </div>
                            </div>
                            <a id="mdProofLink" href="#" target="_blank" class="text-gray-400 hover:text-[#2D1622] transition p-2">
                                <i class="fa-solid fa-download text-base"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="mdModalFooter" class="p-6 border-t border-gray-200 bg-white flex items-center justify-end space-x-3 sticky bottom-0">
            <div id="mdFooterPending" class="flex space-x-3 hidden">
                <button type="button" onclick="submitDisbursementDecision('rejected')" class="bg-[#FA6B6B] hover:bg-red-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">Tolak</button>
                <button type="button" onclick="submitDisbursementDecision('approved')" class="bg-[#55A08E] hover:bg-teal-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">Setujui</button>
            </div>
            
            <div id="mdFooterApproved" class="flex space-x-3 hidden">
                <button type="button" onclick="closeDisbursementModal()" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">Batal</button>
                <button type="button" onclick="submitDisbursementDecision('transferred')" class="bg-[#9AB36B] hover:bg-olive-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div id="confirmApproveModal" class="hidden fixed inset-0 z-[60] bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-[#F8F9FA] rounded-2xl max-w-xl w-full p-6 shadow-xl border border-gray-100">
        <div class="flex items-center space-x-3 border-b border-gray-200 pb-3 mb-4">
            <div class="text-emerald-600"><i class="fa-solid fa-circle-check text-lg"></i></div>
            <h4 class="text-lg font-bold text-[#2D1622]">Konfirmasi Persetujuan Dana</h4>
        </div>
        <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menyetujui pengajuan dana ini? Status akan diperbarui menjadi <span class="font-bold text-emerald-600">Approved</span> agar Anda dapat mengunggah bukti transfer nanti.</p>
        <div class="flex justify-end space-x-2">
            <button type="button" onclick="closeConfirmModal('approved')" class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold rounded-xl transition">Batalkan</button>
            <button type="button" onclick="executeSubmit('approved')" class="px-5 py-2 bg-[#55A08E] hover:bg-teal-700 text-white text-xs font-semibold rounded-xl transition">Ya, Setujui</button>
        </div>
    </div>
</div>

<!-- SUB-MODAL 2: KONFIRMASI TOLAK -->
<div id="confirmRejectModal" class="hidden fixed inset-0 z-[60] bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-[#F8F9FA] rounded-2xl max-w-xl w-full p-6 shadow-xl border border-gray-100">
        <div class="flex items-center space-x-3 border-b border-gray-200 pb-3 mb-4">
            <div class="text-red-500"><i class="fa-solid fa-circle-xmark text-lg"></i></div>
            <h4 class="text-lg font-bold text-[#2D1622]">Konfirmasi Penolakan Pengajuan</h4>
        </div>
        <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menolak permintaan pengajuan dana ini?</p>
        
        <div class="mb-6">
            <label class="block text-xs font-semibold text-[#2D1622] mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
            <textarea id="modalAdminNotes" rows="3" placeholder="Tulis alasan penolakan secara mendetail.." class="w-full px-3 py-2 bg-[#FBF4E4]/30 border border-amber-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#2D1622] transition"></textarea>
            <p id="rejectError" class="hidden text-xs text-red-500 mt-1"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Alasan penolakan wajib diisi!</p>
        </div>

        <div class="flex justify-end space-x-2">
            <button type="button" onclick="closeConfirmModal('rejected')" class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold rounded-xl transition">Batalkan</button>
            <button type="button" onclick="executeSubmit('rejected')" class="px-5 py-2 bg-[#FA6B6B] hover:bg-red-600 text-white text-xs font-semibold rounded-xl transition">Ya, Tolak</button>
        </div>
    </div>
</div>