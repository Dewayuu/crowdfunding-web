@extends('layouts.sidebar.user')

@section('title', 'Edit Profil')

@section('content')
<<<<<<< HEAD
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
                                   x-model="username"
                                   placeholder="Nama Pengguna"
                                   :class="errors.username ? 'border-red-400' : 'border-gray-300'"
                                   class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                            <p x-show="errors.username" x-text="Array.isArray(errors.username) ? errors.username[0] : errors.username" class="text-red-500 text-xs mt-1"></p>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                            <input type="email" name="email"
                                   x-model="email"
                                   placeholder="Email Pengguna"
                                   :class="errors.email ? 'border-red-400' : 'border-gray-300'"
                                   class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                            <p x-show="errors.email" x-text="Array.isArray(errors.email) ? errors.email[0] : errors.email" class="text-red-500 text-xs mt-1"></p>
                        </div>

                        {{-- Nomor Telepon --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon</label>
                            <input type="text" name="contact_number"
                                   x-model="contact_number"
                                   placeholder="Nomor Telepon Pengguna"
                                   :class="errors.contact_number ? 'border-red-400' : 'border-gray-300'"
                                   class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                            <p x-show="errors.contact_number" x-text="Array.isArray(errors.contact_number) ? errors.contact_number[0] : errors.contact_number" class="text-red-500 text-xs mt-1"></p>
                        </div>

                        {{-- Bio --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Bio</label>
                            <textarea name="bio" rows="3"
                                      x-model="bio"
                                      placeholder="Bio Pengguna"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition resize-none"></textarea>
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
                                           x-model="currentPassword"
                                           placeholder="Password Lama"
                                           :class="errors.current_password ? 'border-red-400' : 'border-gray-300'"
                                           class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition pr-10">
                                    <button type="button" @click="showOld = !showOld"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i :class="showOld ? 'fa-eye' : 'fa-eye-slash'" class="fa-regular text-sm"></i>
                                    </button>
                                </div>
                                <p x-show="errors.current_password"
                                   x-text="Array.isArray(errors.current_password) ? errors.current_password[0] : errors.current_password"
                                   class="text-red-500 text-xs mt-1"></p>
                            </div>

                            {{-- Password Baru --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                                <div class="relative">
                                    <input :type="showNew ? 'text' : 'password'" name="password"
                                           x-model="newPassword"
                                           placeholder="Password Baru"
                                           :class="errors.password ? 'border-red-400' : 'border-gray-300'"
                                           class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition pr-10">
                                    <button type="button" @click="showNew = !showNew"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i :class="showNew ? 'fa-eye' : 'fa-eye-slash'" class="fa-regular text-sm"></i>
                                    </button>
                                </div>
                                <p x-show="errors.password"
                                   x-text="Array.isArray(errors.password) ? errors.password[0] : errors.password"
                                   class="text-red-500 text-xs mt-1"></p>
                                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah password</p>
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

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Buku Tabungan / Bukti Rekening</label>
                                @if(Auth::user()->bankAccount)
                                    <p class="text-xs text-gray-400 mb-2">Sudah ada foto sebelumnya. Upload baru hanya jika ingin mengganti.</p>
                                @endif
                                <input type="file" name="bank_proof" accept=".jpg,.jpeg,.png,.pdf"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                @error('bank_proof')
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
        errors: {},
        currentPassword: '',
        newPassword: '',
        confirmPassword: '',
        username: '{{ Auth::user()->username }}',
        email: '{{ Auth::user()->email }}',
        contact_number: '{{ Auth::user()->contact_number }}',
        bio: '{{ Auth::user()->bio }}',

        handleSubmit() {
            this.showConfirmModal = true;
        },

        submitForm() {
            this.showConfirmModal = false;

            if (this.newPassword && this.newPassword !== this.confirmPassword) {
                this.showErrorModal = true;
                return;
            }

            const form = document.querySelector('form');
            const formData = new FormData(form);
            formData.set('username', this.username);
            formData.set('email', this.email);
            formData.set('contact_number', this.contact_number);
            formData.set('bio', this.bio);
            formData.set('current_password', this.currentPassword);
            formData.set('password', this.newPassword);
            formData.set('password_confirmation', this.confirmPassword);
            formData.set('bank_name', document.querySelector('select[name="bank_name"]').value);
            formData.set('account_number', document.querySelector('input[name="account_number"]').value);
            formData.set('account_holder', document.querySelector('input[name="account_holder"]').value);

            // Tambahkan file foto jika ada
            const photoInput = document.querySelector('input[name="profile_photo"]');
            if (photoInput && photoInput.files[0]) {
                formData.set('profile_photo', photoInput.files[0]);
            }

            formData.append('_method', 'PUT');

            fetch('{{ route('user.profile.update') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.showSuccessModal = true;
                } else if (data.errors) {
                    this.errors = data.errors;
                    this.showErrorModal = true;
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
=======
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
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="username"
                                       x-model="username"
                                       placeholder="Nama Pengguna"
                                       :class="errors.username ? 'border-red-400' : 'border-gray-300'"
                                       class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                <p x-show="errors.username" x-text="Array.isArray(errors.username) ? errors.username[0] : errors.username" class="text-red-500 text-xs mt-1"></p>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email"
                                       x-model="email"
                                       placeholder="Email Pengguna"
                                       :class="errors.email ? 'border-red-400' : 'border-gray-300'"
                                       class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                <p x-show="errors.email" x-text="Array.isArray(errors.email) ? errors.email[0] : errors.email" class="text-red-500 text-xs mt-1"></p>
                            </div>

                            {{-- Nomor Telepon --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon <span class="text-red-500">*</span></label>
                                <input type="text" name="contact_number"
                                       x-model="contact_number"
                                       placeholder="Nomor Telepon Pengguna"
                                       :class="errors.contact_number ? 'border-red-400' : 'border-gray-300'"
                                       class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                <p x-show="errors.contact_number" x-text="Array.isArray(errors.contact_number) ? errors.contact_number[0] : errors.contact_number" class="text-red-500 text-xs mt-1"></p>
                            </div>

                            {{-- Bio --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bio</label>
                                <textarea name="bio" rows="3"
                                          x-model="bio"
                                          placeholder="Bio Pengguna"
                                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition resize-none"></textarea>
                                @error('bio')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Data Identitas Individual --}}
                            @if(Auth::user()->entity_type === 'individual')
                                <div class="mt-6">
                                    <h3 class="text-base font-semibold text-gray-700 mb-4">Data Identitas (Wajib untuk membuat Campaign)</h3>
                                    <div class="space-y-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">NIK (Nomor Induk Kependudukan)</label>
                                            <input type="text" name="nik"
                                                   x-model="nik"
                                                   placeholder="16 digit NIK"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto KTP</label>

                                            {{-- Preview file tersimpan --}}
                                            @php $ktpDoc = Auth::user()->documents()->where('document_type', 'ktp')->first(); @endphp
                                            @if($ktpDoc)
                                                <div class="mb-2">
                                                    <p class="text-xs text-gray-400 mb-1">File tersimpan:</p>
                                                    <a href="{{ asset('storage/' . $ktpDoc->file) }}" target="_blank"
                                                       class="inline-flex items-center gap-1 text-xs text-[#2D1622] hover:underline">
                                                        <i class="fa-regular fa-file-image"></i> Lihat KTP tersimpan
                                                    </a>
                                                </div>
                                            @endif

                                            {{-- Preview sebelum upload --}}
                                            <div x-show="ktpPreview" x-cloak class="mb-2">
                                                <p class="text-xs text-gray-400 mb-1">Preview:</p>
                                                <img :src="ktpPreview" class="w-40 h-24 object-cover rounded-lg border border-gray-200">
                                            </div>

                                            <input type="file" name="ktp_photo" accept=".jpg,.jpeg,.png"
                                                   @change="ktpPreview = URL.createObjectURL($event.target.files[0])"
                                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Foundation --}}
                            @if(Auth::user()->entity_type === 'foundation')
                                <div class="mt-6">
                                    <h3 class="text-base font-semibold text-gray-700 mb-4">Data Yayasan</h3>
                                    <div class="space-y-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Yayasan</label>
                                            <input type="text" name="foundation_name"
                                                   value="{{ old('foundation_name', Auth::user()->detailFoundation?->foundation_name) }}"
                                                   placeholder="Nama Yayasan"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor SK Kemenkumham</label>
                                            <input type="text" name="sk_kemenkumham_number"
                                                   value="{{ old('sk_kemenkumham_number', Auth::user()->detailFoundation?->sk_kemenkumham_number) }}"
                                                   placeholder="Nomor SK Kemenkumham"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">File SK Kemenkumham</label>
                                            @php $skDoc = Auth::user()->documents()->where('document_type', 'sk_kemenkumham')->first(); @endphp
                                            @if($skDoc)
                                                <a href="{{ asset('storage/' . $skDoc->file) }}" target="_blank"
                                                   class="inline-flex items-center gap-1 text-xs text-[#2D1622] hover:underline mb-2 block">
                                                    <i class="fa-regular fa-file"></i> Lihat file tersimpan
                                                </a>
                                            @endif
                                            <div x-show="skPreview" x-cloak class="mb-2">
                                                <img :src="skPreview" class="w-40 h-24 object-cover rounded-lg border border-gray-200">
                                            </div>
                                            <input type="file" name="sk_kemenkumham" accept=".jpg,.jpeg,.png,.pdf"
                                                   @change="skPreview = $event.target.files[0].type.startsWith('image') ? URL.createObjectURL($event.target.files[0]) : null"
                                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Yayasan</label>
                                            <textarea name="foundation_address" rows="2"
                                                      placeholder="Alamat Yayasan"
                                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition resize-none">{{ Auth::user()->detailFoundation?->foundation_address }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Penanggung Jawab (PIC)</label>
                                            <input type="text" name="pic_name_foundation"
                                                   value="{{ Auth::user()->detailFoundation?->pic_name }}"
                                                   placeholder="Nama sesuai KTP"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">KTP Penanggung Jawab (PIC)</label>
                                            @php $ktpDoc = Auth::user()->documents()->where('document_type', 'ktp')->first(); @endphp
                                            @if($ktpDoc)
                                                <a href="{{ asset('storage/' . $ktpDoc->file) }}" target="_blank"
                                                   class="inline-flex items-center gap-1 text-xs text-[#2D1622] hover:underline mb-2 block">
                                                    <i class="fa-regular fa-file-image"></i> Lihat KTP tersimpan
                                                </a>
                                            @endif
                                            <div x-show="ktpPicPreview" x-cloak class="mb-2">
                                                <img :src="ktpPicPreview" class="w-40 h-24 object-cover rounded-lg border border-gray-200">
                                            </div>
                                            <input type="file" name="pic_ktp" accept=".jpg,.jpeg,.png"
                                                   @change="ktpPicPreview = URL.createObjectURL($event.target.files[0])"
                                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Corporate --}}
                            @if(Auth::user()->entity_type === 'corporate')
                                <div class="mt-6">
                                    <h3 class="text-base font-semibold text-gray-700 mb-4">Data Perusahaan</h3>
                                    <div class="space-y-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Perusahaan</label>
                                            <input type="text" name="company_name"
                                                   value="{{ old('company_name', Auth::user()->detailCorporate?->company_name) }}"
                                                   placeholder="Nama Perusahaan"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">NIB</label>
                                            <input type="text" name="nib"
                                                   value="{{ old('nib', Auth::user()->detailCorporate?->nib) }}"
                                                   placeholder="Nomor Induk Berusaha"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">NPWP</label>
                                            <input type="text" name="npwp"
                                                   value="{{ old('npwp', Auth::user()->detailCorporate?->npwp) }}"
                                                   placeholder="NPWP"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Perusahaan</label>
                                            <textarea name="company_address" rows="2"
                                                      placeholder="Alamat Perusahaan"
                                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition resize-none">{{ Auth::user()->detailCorporate?->company_address }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Penanggung Jawab (PIC)</label>
                                            <input type="text" name="pic_name_corporate"
                                                   value="{{ Auth::user()->detailCorporate?->pic_name }}"
                                                   placeholder="Nama sesuai KTP"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">KTP Penanggung Jawab (PIC)</label>
                                            @php $ktpDoc = Auth::user()->documents()->where('document_type', 'ktp')->first(); @endphp
                                            @if($ktpDoc)
                                                <a href="{{ asset('storage/' . $ktpDoc->file) }}" target="_blank"
                                                   class="inline-flex items-center gap-1 text-xs text-[#2D1622] hover:underline mb-2 block">
                                                    <i class="fa-regular fa-file-image"></i> Lihat KTP tersimpan
                                                </a>
                                            @endif
                                            <div x-show="ktpPicPreview" x-cloak class="mb-2">
                                                <img :src="ktpPicPreview" class="w-40 h-24 object-cover rounded-lg border border-gray-200">
                                            </div>
                                            <input type="file" name="pic_ktp" accept=".jpg,.jpeg,.png"
                                                   @change="ktpPicPreview = URL.createObjectURL($event.target.files[0])"
                                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Community --}}
                            @if(Auth::user()->entity_type === 'community')
                                <div class="mt-6">
                                    <h3 class="text-base font-semibold text-gray-700 mb-4">Data Komunitas</h3>
                                    <div class="space-y-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Komunitas</label>
                                            <input type="text" name="community_name"
                                                   value="{{ old('community_name', Auth::user()->detailCommunity?->community_name) }}"
                                                   placeholder="Nama Komunitas"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">URL Media Sosial</label>
                                            <input type="url" name="social_media_url"
                                                   value="{{ old('social_media_url', Auth::user()->detailCommunity?->social_media_url) }}"
                                                   placeholder="https://instagram.com/komunitas"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Screenshot Profil Media Sosial</label>
                                            @php $ssDoc = Auth::user()->documents()->where('document_type', 'social_media')->first(); @endphp
                                            @if($ssDoc)
                                                <a href="{{ asset('storage/' . $ssDoc->file) }}" target="_blank"
                                                   class="inline-flex items-center gap-1 text-xs text-[#2D1622] hover:underline mb-2 block">
                                                    <i class="fa-regular fa-file-image"></i> Lihat file tersimpan
                                                </a>
                                            @endif
                                            <div x-show="ssPreview" x-cloak class="mb-2">
                                                <img :src="ssPreview" class="w-40 h-24 object-cover rounded-lg border border-gray-200">
                                            </div>
                                            <input type="file" name="social_media_screenshot" accept=".jpg,.jpeg,.png"
                                                   @change="ssPreview = URL.createObjectURL($event.target.files[0])"
                                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Komunitas</label>
                                            <input type="text" name="community_type"
                                                   value="{{ Auth::user()->detailCommunity?->community_type }}"
                                                   placeholder="Contoh: Pecinta Alam, Ikatan Alumni, dll"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Penanggung Jawab (PIC)</label>
                                            <input type="text" name="pic_name_community"
                                                   value="{{ Auth::user()->detailCommunity?->pic_name }}"
                                                   placeholder="Nama sesuai KTP"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">KTP Penanggung Jawab (PIC)</label>
                                            @php $ktpDoc = Auth::user()->documents()->where('document_type', 'ktp')->first(); @endphp
                                            @if($ktpDoc)
                                                <a href="{{ asset('storage/' . $ktpDoc->file) }}" target="_blank"
                                                   class="inline-flex items-center gap-1 text-xs text-[#2D1622] hover:underline mb-2 block">
                                                    <i class="fa-regular fa-file-image"></i> Lihat KTP tersimpan
                                                </a>
                                            @endif
                                            <div x-show="ktpPicPreview" x-cloak class="mb-2">
                                                <img :src="ktpPicPreview" class="w-40 h-24 object-cover rounded-lg border border-gray-200">
                                            </div>
                                            <input type="file" name="pic_ktp" accept=".jpg,.jpeg,.png"
                                                   @change="ktpPicPreview = URL.createObjectURL($event.target.files[0])"
                                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                                               x-model="currentPassword"
                                               placeholder="Password Lama"
                                               :class="errors.current_password ? 'border-red-400' : 'border-gray-300'"
                                               class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition pr-10">
                                        <button type="button" @click="showOld = !showOld"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                            <i :class="showOld ? 'fa-eye' : 'fa-eye-slash'" class="fa-regular text-sm"></i>
                                        </button>
                                    </div>
                                    <p x-show="errors.current_password"
                                       x-text="Array.isArray(errors.current_password) ? errors.current_password[0] : errors.current_password"
                                       class="text-red-500 text-xs mt-1"></p>
                                </div>

                                {{-- Password Baru --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                                    <div class="relative">
                                        <input :type="showNew ? 'text' : 'password'" name="password"
                                               x-model="newPassword"
                                               placeholder="Password Baru"
                                               :class="errors.password ? 'border-red-400' : 'border-gray-300'"
                                               class="w-full px-4 py-2.5 border rounded-lg outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition pr-10">
                                        <button type="button" @click="showNew = !showNew"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                            <i :class="showNew ? 'fa-eye' : 'fa-eye-slash'" class="fa-regular text-sm"></i>
                                        </button>
                                    </div>
                                    <p x-show="errors.password"
                                       x-text="Array.isArray(errors.password) ? errors.password[0] : errors.password"
                                       class="text-red-500 text-xs mt-1"></p>
                                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah password</p>
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

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Buku Tabungan / Bukti Rekening</label>

                                    {{-- Preview file tersimpan --}}
                                    @php $bankDoc = Auth::user()->documents()->where('document_type', 'bank_book')->latest('uploaded_at')->first(); @endphp
                                    @if($bankDoc)
                                        <div class="mb-2">
                                            <p class="text-xs text-gray-400 mb-1">File tersimpan:</p>
                                            <a href="{{ asset('storage/' . $bankDoc->file) }}" target="_blank"
                                               class="inline-flex items-center gap-1 text-xs text-[#2D1622] hover:underline">
                                                <i class="fa-regular fa-file-image"></i> Lihat buku tabungan tersimpan
                                            </a>
                                        </div>
                                    @endif

                                    {{-- Preview sebelum upload --}}
                                    <div x-show="bankPreview" x-cloak class="mb-2">
                                        <p class="text-xs text-gray-400 mb-1">Preview:</p>
                                        <img :src="bankPreview" class="w-40 h-24 object-cover rounded-lg border border-gray-200">
                                    </div>

                                    <input type="file" name="bank_proof" accept=".jpg,.jpeg,.png,.pdf"
                                           @change="bankPreview = $event.target.files[0].type.startsWith('image') ? URL.createObjectURL($event.target.files[0]) : null"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                    <p class="text-xs text-gray-400 mt-1">Preview hanya tersedia untuk file gambar (bukan PDF)</p>
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
                errors: {},
                currentPassword: '',
                newPassword: '',
                confirmPassword: '',
                username: '{{ Auth::user()->username }}',
                email: '{{ Auth::user()->email }}',
                contact_number: '{{ Auth::user()->contact_number }}',
                bio: '{{ Auth::user()->bio }}',
                nik: '{{ Auth::user()->detailIndividual?->national_id_number ?? '' }}',
                skPreview: null,
                ssPreview: null,
                ktpPreview: null,
                ktpPicPreview: null,
                bankPreview: null,

                handleSubmit() {
                    this.showConfirmModal = true;
                },

                submitForm() {
                    this.showConfirmModal = false;

                    if (this.newPassword && this.newPassword !== this.confirmPassword) {
                        this.showErrorModal = true;
                        return;
                    }

                    const form = document.querySelector('form');
                    const formData = new FormData(form);
                    formData.set('username', this.username);
                    formData.set('email', this.email);
                    formData.set('contact_number', this.contact_number);
                    formData.set('bio', this.bio);
                    formData.set('nik', this.nik);
                    formData.set('current_password', this.currentPassword);
                    formData.set('password', this.newPassword);
                    formData.set('password_confirmation', this.confirmPassword);
                    formData.set('bank_name', document.querySelector('select[name="bank_name"]').value);
                    formData.set('account_number', document.querySelector('input[name="account_number"]').value);
                    formData.set('account_holder', document.querySelector('input[name="account_holder"]').value);
                    // Foundation
                    formData.set('foundation_address', document.querySelector('textarea[name="foundation_address"]')?.value ?? '');
                    formData.set('pic_name_foundation', document.querySelector('input[name="pic_name_foundation"]')?.value ?? '');
                    formData.set('sk_kemenkumham_number', document.querySelector('input[name="sk_kemenkumham_number"]')?.value ?? '');

                    // Corporate
                    formData.set('company_address', document.querySelector('textarea[name="company_address"]')?.value ?? '');
                    formData.set('pic_name_corporate', document.querySelector('input[name="pic_name_corporate"]')?.value ?? '');
                    formData.set('company_name', document.querySelector('input[name="company_name"]')?.value ?? '');
                    formData.set('nib', document.querySelector('input[name="nib"]')?.value ?? '');
                    formData.set('npwp', document.querySelector('input[name="npwp"]')?.value ?? '');

                    // Community
                    formData.set('community_type', document.querySelector('input[name="community_type"]')?.value ?? '');
                    formData.set('pic_name_community', document.querySelector('input[name="pic_name_community"]')?.value ?? '');
                    formData.set('community_name', document.querySelector('input[name="community_name"]')?.value ?? '');
                    formData.set('social_media_url', document.querySelector('input[name="social_media_url"]')?.value ?? '');

                    // Tambahkan file foto jika ada
                    const photoInput = document.querySelector('input[name="profile_photo"]');
                    if (photoInput && photoInput.files[0]) {
                        formData.set('profile_photo', photoInput.files[0]);
                    }

                    // Tambahkan file KTP jika ada
                    const ktpInput = document.querySelector('input[name="ktp_photo"]');
                    if (ktpInput && ktpInput.files[0]) {
                        formData.set('ktp_photo', ktpInput.files[0]);
                    }

                    // Tambahkan file SK Kemenkumham jika ada
                    const skInput = document.querySelector('input[name="sk_kemenkumham"]');
                    if (skInput && skInput.files[0]) {
                        formData.set('sk_kemenkumham', skInput.files[0]);
                    }

                    // Tambahkan file screenshot media sosial jika ada
                    const ssInput = document.querySelector('input[name="social_media_screenshot"]');
                    if (ssInput && ssInput.files[0]) {
                        formData.set('social_media_screenshot', ssInput.files[0]);
                    }

                    // Tambahkan file KTP PIC jika ada
                    const picKtpInput = document.querySelector('input[name="pic_ktp"]');
                    if (picKtpInput && picKtpInput.files[0]) {
                        formData.set('pic_ktp', picKtpInput.files[0]);
                    }

                    // Tambahkan file bukti rekening jika ada   
                    const bankProofInput = document.querySelector('input[name="bank_proof"]');
                    if (bankProofInput && bankProofInput.files[0]) {
                        formData.set('bank_proof', bankProofInput.files[0]);
                    }

                    formData.append('_method', 'PUT');

                    fetch('{{ route('user.profile.update') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.showSuccessModal = true;
                        } else if (data.errors) {
                            this.errors = data.errors;
                            this.showErrorModal = true;
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
>>>>>>> main
@endsection