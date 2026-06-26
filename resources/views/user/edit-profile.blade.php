@extends('layouts.sidebar.user')

@section('title', 'Edit Profil')

@section('content')
<div x-data="editProfile()" class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-[#2D1622] transition">
            <i class="fa-solid fa-circle-arrow-left text-2xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-[#2D1622]">Edit Profil</h1>
    </div>

    {{-- Card Utama --}}
    <div class="bg-white rounded-2xl shadow-sm p-8">

        {{-- Judul Section --}}
        <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-200">
            <i class="fa-regular fa-user text-[#2D1622] text-lg"></i>
            <h2 class="text-xl font-bold text-[#2D1622]">Profil Pengguna</h2>
        </div>

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" @submit.prevent="handleSubmit">
            @csrf
            @method('PUT')

            {{-- Foto Profil --}}
            <div class="flex flex-col items-center mb-8">
                <div class="relative w-32 h-32 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center mb-3 border-4 border-white shadow-md">
                    <template x-if="previewPhoto">
                        <img :src="previewPhoto" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!previewPhoto">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-regular fa-user text-gray-400 text-4xl"></i>
                        @endif
                    </template>
                </div>
                <label class="bg-[#2D1622] hover:bg-[#422132] text-white text-sm px-4 py-2 rounded-lg cursor-pointer transition font-medium">
                    Ganti Foto
                    <input type="file" name="profile_photo" accept="image/*" class="hidden"
                           @change="previewPhoto = URL.createObjectURL($event.target.files[0])">
                </label>
            </div>

            {{-- Grid 2 Kolom --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Kiri: Informasi Pribadi --}}
                <div>
                    <h3 class="text-base font-semibold text-gray-700 mb-4">Informasi Pribadi</h3>
                    <div class="space-y-4">

                        {{-- Nama Lengkap --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="username"
                                   value="{{ old('username', Auth::user()->username) }}"
                                   placeholder="Nama Pengguna"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                            @error('username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', Auth::user()->email) }}"
                                   placeholder="Email Pengguna"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor Telepon --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon</label>
                            <input type="text" name="contact_number"
                                   value="{{ old('contact_number', Auth::user()->contact_number) }}"
                                   placeholder="Nomor Telepon Pengguna"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                            @error('contact_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Bio --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Bio</label>
                            <textarea name="bio" rows="3"
                                      placeholder="Bio Pengguna"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition resize-none">{{ old('bio', Auth::user()->bio) }}</textarea>
                            @error('bio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Kanan: Password + Rekening --}}
                <div class="space-y-6">

                    {{-- Password --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-700 mb-4">Password</h3>
                        <div class="space-y-4">

                            {{-- Password Lama --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Lama</label>
                                <div class="relative">
                                    <input :type="showOld ? 'text' : 'password'" name="current_password"
                                           placeholder="Password Lama"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition pr-10">
                                    <button type="button" @click="showOld = !showOld"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i :class="showOld ? 'fa-eye' : 'fa-eye-slash'" class="fa-regular text-sm"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password Baru --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                                <div class="relative">
                                    <input :type="showNew ? 'text' : 'password'" name="password"
                                           x-model="newPassword"
                                           placeholder="Password Baru"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition pr-10">
                                    <button type="button" @click="showNew = !showNew"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i :class="showNew ? 'fa-eye' : 'fa-eye-slash'" class="fa-regular text-sm"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password Baru --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                                <div class="relative">
                                    <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                                           x-model="confirmPassword"
                                           placeholder="Konfirmasi Password Baru"
                                           :class="newPassword && confirmPassword && newPassword !== confirmPassword ? 'border-red-400' : 'border-gray-300'"
                                           class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition pr-10">
                                    <button type="button" @click="showConfirm = !showConfirm"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i :class="showConfirm ? 'fa-eye' : 'fa-eye-slash'" class="fa-regular text-sm"></i>
                                    </button>
                                </div>
                                <p x-show="newPassword && confirmPassword && newPassword !== confirmPassword"
                                   class="text-red-500 text-xs mt-1">Password tidak sesuai</p>
                            </div>
                        </div>
                    </div>

                    {{-- Rekening Bank --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-700 mb-4">Rekening Bank (Refund)</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Bank</label>
                                <select name="bank_name"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 bg-white focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                    @php $bankNow = Auth::user()->bankAccount?->bank_name; @endphp
                                    <option value="">-- Pilih Bank --</option>
                                    @foreach(['BCA','Mandiri','BRI','BNI','BTN','CIMB Niaga','Permata','Danamon','OCBC','Bank Syariah Indonesia','Panin Bank','Maybank','Bank Mega'] as $bank)
                                        <option value="{{ $bank }}" {{ $bankNow === $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                    @endforeach
                                </select>
                                @error('bank_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Rekening</label>
                                <input type="text" name="account_number"
                                       value="{{ old('account_number', Auth::user()->bankAccount?->account_number) }}"
                                       placeholder="Nomor Rekening"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                @error('account_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Pemilik Rekening</label>
                                <input type="text" name="account_holder"
                                       value="{{ old('account_holder', Auth::user()->bankAccount?->account_name) }}"
                                       placeholder="Nama Pemilik Rekening"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                @error('account_holder')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('user.dashboard') }}"
                   class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-lg font-semibold transition">
                    Batal
                </a>
                <button type="button" @click="showConfirmModal = true"
                        class="bg-[#6B7A4A] hover:bg-[#5a6840] text-white px-6 py-2.5 rounded-lg font-semibold transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Modal Konfirmasi --}}
    <div x-show="showConfirmModal" x-cloak
         class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
         @click.self="showConfirmModal = false">
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full mx-4">
            <div class="flex items-center gap-2 mb-4 pb-4 border-b border-gray-200">
                <i class="fa-solid fa-floppy-disk text-[#2D1622]"></i>
                <h3 class="text-lg font-bold text-gray-800">Simpan Perubahan?</h3>
            </div>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menyimpan perubahan ini?</p>
            <div class="flex justify-end gap-3">
                <button @click="showConfirmModal = false"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg font-semibold transition">
                    Batalkan
                </button>
                <button @click="submitForm"
                        class="bg-[#6B7A4A] hover:bg-[#5a6840] text-white px-5 py-2.5 rounded-lg font-semibold transition">
                    Ya, Simpan
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Berhasil --}}
    <div x-show="showSuccessModal" x-cloak
         class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full mx-4 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-check text-green-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-6">Perubahan Berhasil Disimpan!</h3>
            <a href="{{ route('user.dashboard') }}"
               class="block w-full bg-[#2D1622] hover:bg-[#422132] text-white py-2.5 rounded-lg font-semibold transition">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- Modal Gagal --}}
    <div x-show="showErrorModal" x-cloak
         class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
         @click.self="showErrorModal = false">
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full mx-4 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-xmark text-red-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Perubahan Gagal Disimpan!</h3>
            <p class="text-sm text-gray-500 mb-6">Mohon periksa kembali data yang diisi.</p>
            <button @click="showErrorModal = false"
                    class="w-full bg-[#2D1622] hover:bg-[#422132] text-white py-2.5 rounded-lg font-semibold transition">
                Periksa Kembali
            </button>
        </div>
    </div>

</div>

<script>
function editProfile() {
    return {
        showConfirmModal: false,
        showSuccessModal: false,
        showErrorModal: false,
        showOld: false,
        showNew: false,
        showConfirm: false,
        previewPhoto: null,
        newPassword: '',
        confirmPassword: '',

        handleSubmit() {
            // Cegah submit langsung, munculkan confirm modal
            this.showConfirmModal = true;
        },

        submitForm() {
            this.showConfirmModal = false;

            // Cek password match dulu
            if (this.newPassword && this.newPassword !== this.confirmPassword) {
                this.showErrorModal = true;
                return;
            }

            const form = document.querySelector('form');
            const formData = new FormData(form);

            fetch('{{ route('user.profile.update') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.showSuccessModal = true;
                } else {
                    this.showErrorModal = true;
                }
            })
            .catch(() => {
                this.showErrorModal = true;
            });
        }
    }
}
</script>
@endsection