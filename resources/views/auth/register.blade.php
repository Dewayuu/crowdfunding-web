<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Crowdfunding Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <div x-data="registerForm()" class="w-full min-h-screen flex">

        {{-- Sisi Kiri: Foto --}}
        <div class="hidden md:flex md:w-1/2 relative overflow-hidden">
            <img src="{{ asset('images/pexels-tahir-33963829.jpg') }}"
                 alt="Crowdfunding"
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-[#2D1622]/30"></div>
        </div>

        {{-- Sisi Kanan: Form --}}
        <div class="w-full md:w-1/2 flex flex-col justify-center px-8 sm:px-16 lg:px-20 bg-white overflow-y-auto py-12">
            <div class="max-w-md w-full mx-auto">

                {{-- Step Indicator --}}
                <p class="text-xs text-gray-400 font-medium mb-1">
                    Step <span x-text="step"></span> dari 2
                </p>

                {{-- Judul --}}
                <h2 class="text-3xl font-bold text-[#2D1622] mb-1" x-text="step === 1 ? 'Buat Akun Anda' : 'Informasi Rekening'"></h2>
                <p class="text-sm text-gray-500 mb-6" x-text="step === 1 ? 'Jadilah bagian dari perubahan yang berarti.' : 'Data rekening digunakan untuk proses pengembalian dana jika diperlukan.'"></p>

                {{-- Link Login --}}
                <p x-show="step === 1" class="text-sm text-gray-600 mb-6">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="text-[#6B7A4A] font-medium hover:underline">Log in</a>
                </p>

                {{-- Error dari server --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 text-red-600 rounded-lg text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm">
                    @csrf

                    {{-- ======================== STEP 1 ======================== --}}
                    <div x-show="step === 1" x-cloak class="space-y-5">

                        {{-- Nama Lengkap --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="username" x-model="form.username"
                                   placeholder="Masukkan Nama Lengkap Anda"
                                   :class="errors.username ? 'border-red-400 focus:ring-red-300' : 'border-gray-300 focus:ring-[#2D1622] focus:border-[#2D1622]'"
                                   class="w-full px-4 py-2.5 border rounded-md transition outline-none text-gray-700 placeholder-gray-400">
                            <p x-show="errors.username" x-text="errors.username" class="text-red-500 text-xs mt-1"></p>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                            <input type="email" name="email" x-model="form.email"
                                   placeholder="Masukkan Email Anda"
                                   :class="errors.email ? 'border-red-400 focus:ring-red-300' : 'border-gray-300 focus:ring-[#2D1622] focus:border-[#2D1622]'"
                                   class="w-full px-4 py-2.5 border rounded-md transition outline-none text-gray-700 placeholder-gray-400">
                            <p x-show="errors.email" x-text="errors.email" class="text-red-500 text-xs mt-1"></p>
                        </div>

                        {{-- Nomor Kontak --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Kontak</label>
                            <input type="text" name="contact_number" x-model="form.contact_number"
                                   placeholder="Masukan Nomor Kontak Anda"
                                   :class="errors.contact_number ? 'border-red-400 focus:ring-red-300' : 'border-gray-300 focus:ring-[#2D1622] focus:border-[#2D1622]'"
                                   class="w-full px-4 py-2.5 border rounded-md transition outline-none text-gray-700 placeholder-gray-400">
                            <p x-show="errors.contact_number" x-text="errors.contact_number" class="text-red-500 text-xs mt-1"></p>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" x-model="form.password"
                                       :class="errors.password ? 'border-red-400 focus:ring-red-300' : 'border-gray-300 focus:ring-[#2D1622] focus:border-[#2D1622]'"
                                       class="w-full px-4 py-2.5 border rounded-md transition outline-none text-gray-700 pr-10">
                                <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <i :class="showPassword ? 'fa-eye' : 'fa-eye-slash'" class="fa-regular text-sm"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter</p>
                            <p x-show="errors.password" x-text="errors.password" class="text-red-500 text-xs mt-1"></p>
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                            <div class="relative">
                                <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" x-model="form.password_confirmation"
                                       :class="errors.password_confirmation ? 'border-red-400 focus:ring-red-300' : 'border-gray-300 focus:ring-[#2D1622] focus:border-[#2D1622]'"
                                       class="w-full px-4 py-2.5 border rounded-md transition outline-none text-gray-700 pr-10">
                                <button type="button" @click="showConfirm = !showConfirm"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <i :class="showConfirm ? 'fa-eye' : 'fa-eye-slash'" class="fa-regular text-sm"></i>
                                </button>
                            </div>
                            <p x-show="errors.password_confirmation" x-text="errors.password_confirmation" class="text-red-500 text-xs mt-1"></p>
                        </div>

                        {{-- Tombol Selanjutnya --}}
                        <div class="flex justify-end pt-2">
                            <button type="button" @click="nextStep"
                                    class="bg-[#6B7A4A] hover:bg-[#5a6840] text-white px-6 py-2.5 rounded-md font-semibold transition duration-200">
                                Selanjutnya
                            </button>
                        </div>
                    </div>

                    {{-- ======================== STEP 2 ======================== --}}
                    <div x-show="step === 2" x-cloak class="space-y-5">

                        {{-- Tipe Akun --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Akun</label>
                            <select name="entity_type" x-model="form.entity_type"
                                    :class="errors.entity_type ? 'border-red-400' : 'border-gray-300'"
                                    class="w-full px-4 py-2.5 border rounded-md outline-none text-gray-700 bg-white focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622]">
                                <option value="">Pilih Tipe Akun</option>
                                <option value="individual">Individual (Perorangan)</option>
                                <option value="foundation">Foundation (Yayasan)</option>
                                <option value="corporate">Corporate (PT/CV)</option>
                                <option value="community">Community (Komunitas)</option>
                            </select>
                            <p x-show="errors.entity_type" x-text="errors.entity_type" class="text-red-500 text-xs mt-1"></p>
                        </div>

                        {{-- Dokumen tambahan sesuai tipe --}}

                        {{-- Foundation: SK Kemenkumham + NIK/KTP PIC --}}
                        <template x-if="form.entity_type === 'foundation'">
                            <div class="space-y-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Dokumen Yayasan</p>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">SK Kemenkumham</label>
                                    <input type="file" name="sk_kemenkumham" accept=".pdf,.jpg,.jpeg,.png"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">KTP Penanggung Jawab (PIC)</label>
                                    <input type="file" name="pic_ktp" accept=".jpg,.jpeg,.png"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                </div>
                            </div>
                        </template>

                        {{-- Corporate: NIB + NPWP + KTP PIC --}}
                        <template x-if="form.entity_type === 'corporate'">
                            <div class="space-y-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Dokumen Perusahaan</p>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">NIB (Nomor Induk Berusaha)</label>
                                    <input type="text" name="nib" placeholder="1234567890123"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-md outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">NPWP</label>
                                    <input type="text" name="npwp" placeholder="00.000.000.0-000.000"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-md outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">KTP Penanggung Jawab (PIC)</label>
                                    <input type="file" name="pic_ktp" accept=".jpg,.jpeg,.png"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                </div>
                            </div>
                        </template>

                        {{-- Community: URL medsos + SS profil + KTP PIC --}}
                        <template x-if="form.entity_type === 'community'">
                            <div class="space-y-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Dokumen Komunitas</p>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">URL Media Sosial Komunitas</label>
                                    <input type="url" name="social_media_url" placeholder="https://instagram.com/komunitas"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-md outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Screenshot Profil Media Sosial</label>
                                    <input type="file" name="social_media_screenshot" accept=".jpg,.jpeg,.png"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">KTP Penanggung Jawab (PIC)</label>
                                    <input type="file" name="pic_ktp" accept=".jpg,.jpeg,.png"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                </div>
                            </div>
                        </template>

                        {{-- Info Rekening (semua tipe wajib) --}}
                        <div class="space-y-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Informasi Rekening Bank</p>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Nama Bank
                                </label>
                                <select name="bank_name"
                                        x-model="form.bank_name"
                                        :class="errors.bank_name ? 'border-red-400' : 'border-gray-300'"
                                        class="w-full px-4 py-2.5 border rounded-md outline-none text-gray-700 bg-white focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622]">
                                    <option value="">-- Pilih Bank --</option>
                                    <option value="BCA">BCA</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BRI">BRI</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BTN">BTN</option>
                                    <option value="CIMB Niaga">CIMB Niaga</option>
                                    <option value="Permata">Permata</option>
                                    <option value="Danamon">Danamon</option>
                                    <option value="OCBC">OCBC</option>
                                    <option value="Bank Syariah Indonesia">Bank Syariah Indonesia (BSI)</option>
                                    <option value="Panin Bank">Panin Bank</option>
                                    <option value="Maybank">Maybank</option>
                                    <option value="Bank Mega">Bank Mega</option>
                                </select>
                                <p x-show="errors.bank_name"
                                   x-text="errors.bank_name"
                                   class="text-red-500 text-xs mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Rekening</label>
                                <input type="text" name="account_number" x-model="form.account_number"
                                       placeholder="Masukkan Nomor Rekening Anda"
                                       :class="errors.account_number ? 'border-red-400' : 'border-gray-300'"
                                       class="w-full px-4 py-2.5 border rounded-md outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622]">
                                <p x-show="errors.account_number" x-text="errors.account_number" class="text-red-500 text-xs mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Pemilik Rekening</label>
                                <input type="text" name="account_holder" x-model="form.account_holder"
                                       placeholder="Masukkan Nama Pemilik Rekening"
                                       :class="errors.account_holder ? 'border-red-400' : 'border-gray-300'"
                                       class="w-full px-4 py-2.5 border rounded-md outline-none text-gray-700 focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622]">
                                <p x-show="errors.account_holder" x-text="errors.account_holder" class="text-red-500 text-xs mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Buku Tabungan / Bukti Rekening</label>
                                <input type="file" name="bank_proof" accept=".jpg,.jpeg,.png,.pdf"
                                       :class="errors.bank_proof ? 'border-red-400' : ''"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#2D1622] file:text-white hover:file:bg-[#422132]">
                                <p x-show="errors.bank_proof" x-text="errors.bank_proof" class="text-red-500 text-xs mt-1"></p>
                            </div>
                        </div>

                        {{-- Syarat & Ketentuan --}}
                        <div class="flex items-start gap-2">
                            <input type="checkbox" id="agree" x-model="form.agree" class="mt-0.5 accent-[#6B7A4A]">
                            <label for="agree" class="text-sm text-gray-600">
                                Saya menyetujui
                                <a href="#" class="text-[#6B7A4A] hover:underline">Syarat</a>
                                &
                                <a href="#" class="text-[#6B7A4A] hover:underline">Ketentuan dan Kebijakan Privasi</a>
                            </label>
                        </div>
                        <p x-show="errors.agree" x-text="errors.agree" class="text-red-500 text-xs -mt-3"></p>

                        {{-- Tombol Kembali & Daftar --}}
                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" @click="step = 1"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-md font-semibold transition duration-200">
                                Kembali
                            </button>
                            <button type="submit"
                                    class="bg-[#6B7A4A] hover:bg-[#5a6840] text-white px-6 py-2.5 rounded-md font-semibold transition duration-200">
                                Daftar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        {{-- ======================== MODAL ERROR ======================== --}}
        <div x-show="showErrorModal" x-cloak
             class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
             @click.self="showErrorModal = false">
            <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full mx-4 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-xmark text-red-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Pendaftaran Belum Dapat Dilanjutkan</h3>
                <p class="text-sm text-gray-500 mb-6">Mohon periksa kembali dan lengkapi data yang diperlukan.</p>
                <button @click="showErrorModal = false"
                        class="w-full bg-[#2D1622] hover:bg-[#422132] text-white py-2.5 rounded-lg font-semibold transition">
                    Periksa Kembali
                </button>
            </div>
        </div>

        {{-- ======================== MODAL SUCCESS ======================== --}}
        <div x-show="showSuccessModal" x-cloak
             class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full mx-4 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-check text-green-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-6">Akun Berhasil Dibuat</h3>
                <a href="{{ route('login') }}"
                   class="block w-full bg-[#2D1622] hover:bg-[#422132] text-white py-2.5 rounded-lg font-semibold transition">
                    Login
                </a>
            </div>
        </div>

    </div>

    <script>
        function registerForm() {
            return {
                step: 1,
                showPassword: false,
                showConfirm: false,
                showErrorModal: false,
                showSuccessModal: false,
                form: {
                    username: '',
                    email: '',
                    contact_number: '',
                    password: '',
                    password_confirmation: '',
                    entity_type: '',
                    bank_name: '',
                    account_number: '',
                    account_holder: '',
                    agree: false,
                },
                errors: {},

                nextStep() {
                    this.errors = {};
                    let hasError = false;

                    if (!this.form.username.trim()) {
                        this.errors.username = 'Nama lengkap wajib diisi.';
                        hasError = true;
                    }

                    if (this.form.username && /\d/.test(this.form.username)) {
                    this.errors.username = 'Nama tidak boleh mengandung angka.';
                    hasError = true;
                    }

                    if (this.form.contact_number && !/^\d{10,15}$/.test(this.form.contact_number)) {
                    this.errors.contact_number = 'Nomor kontak harus angka, 10-15 digit.';
                    hasError = true;
                    }

                    if (!this.form.email.trim()) {
                        this.errors.email = 'Email wajib diisi.';
                        hasError = true;
                    }
                    if (!this.form.contact_number.trim()) {
                        this.errors.contact_number = 'Nomor kontak wajib diisi.';
                        hasError = true;
                    }
                    if (!this.form.password) {
                        this.errors.password = 'Password wajib diisi.';
                        hasError = true;
                    }
                    if (this.form.password !== this.form.password_confirmation) {
                        this.errors.password_confirmation = 'Password Tidak Sesuai';
                        hasError = true;
                    }

                    if (this.form.password && this.form.password.length < 8) {
                        this.errors.password = 'Password minimal 8 karakter.';
                        hasError = true;
                    }

                    if (hasError) {
                        this.showErrorModal = true;
                        return;
                    }
                    this.step = 2;
                },

                submitForm() {
                    this.errors = {};
                    let hasError = false;

                    if (!this.form.entity_type) {
                        this.errors.entity_type = 'Tipe akun wajib dipilih.';
                        hasError = true;
                    }
                    if (!this.form.bank_name.trim()) {
                        this.errors.bank_name = 'Nama bank wajib diisi.';
                        hasError = true;
                    }
                    if (!this.form.account_number.trim()) {
                        this.errors.account_number = 'Nomor rekening wajib diisi.';
                        hasError = true;
                    }
                    if (!this.form.account_holder.trim()) {
                        this.errors.account_holder = 'Nama pemilik rekening wajib diisi.';
                        hasError = true;
                    }
                    if (!this.form.agree) {
                        this.errors.agree = 'Anda harus menyetujui syarat dan ketentuan.';
                        hasError = true;
                    }

                    if (hasError) {
                        this.showErrorModal = true;
                        return;
                    }

                    // Submit via FormData (support file upload)
                    const formEl = this.$el.closest('form');
                    const formData = new FormData(formEl);

                    fetch('/register', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                                ?? document.querySelector('input[name="_token"]').value
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
                        }
                    })
                    .catch(() => {
                        this.showErrorModal = true;
                    });
                }
            }
        }
    </script>

</body>
</html>