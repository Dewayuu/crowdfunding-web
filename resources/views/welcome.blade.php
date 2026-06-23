<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HatiNurani - Platform Donasi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-display {
            font-family: Georgia, 'Times New Roman', serif;
        }
    </style>
</head>

<body class="bg-[#FDFBE2] text-[#351528]">

    {{-- NAVBAR --}}
    <header class="bg-[#351528] text-white">
        <nav class="max-w-7xl mx-auto px-10 lg:px-16 py-6 flex items-center justify-between border-b border-white/25">
            <a href="/" class="font-display text-2xl font-bold">
                Hati<span class="text-[#F1642E]">Nurani</span>
            </a>

            <div class="hidden md:flex items-center gap-10 text-sm font-semibold">
                <a href="#campaign" class="hover:text-[#F1642E] transition">Donasi</a>
                <a href="#trust" class="hover:text-[#F1642E] transition">Tentang</a>
                <a href="{{ route('login') }}" class="hover:text-[#F1642E] transition">Masuk</a>
                <a href="#" class="bg-[#F1642E] px-8 py-3 rounded-lg text-white hover:opacity-90 transition">
                    Daftar
                </a>
            </div>
        </nav>
    </header>

    {{-- HERO --}}
    <section class="bg-[#351528] text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-10 lg:px-16 py-20 lg:py-24 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Hero Text --}}
            <div class="relative z-10">
                <p class="text-[#F1642E] font-bold tracking-[0.18em] text-sm mb-5">
                    PLATFORM CROWDFUNDING TERPERCAYA
                </p>

                <h1 class="font-display text-5xl lg:text-6xl font-bold leading-tight mb-8">
                    Bersama Kita <br>
                    Wujudkan <span class="text-[#A3B565]">Perubahan</span>
                </h1>

                <p class="max-w-xl text-[#FDFBE2] text-base leading-relaxed mb-12">
                    HatiNurani menghubungkan donatur dengan campaign yang telah melalui proses verifikasi
                    agar bantuan dapat diberikan secara lebih aman dan tepat sasaran.
                </p>

                <div class="flex flex-wrap gap-6">
                    <a href="#campaign" class="bg-[#F1642E] px-8 py-4 rounded-lg font-bold text-white hover:opacity-90 transition">
                        Lihat Campaign
                    </a>
                    <a href="#" class="border border-white/80 px-8 py-4 rounded-lg font-bold text-white hover:bg-white hover:text-[#351528] transition">
                        Mulai Galang Dana
                    </a>
                </div>
            </div>

            {{-- Hero Visual --}}
            <div class="relative min-h-[380px] hidden lg:block">
                <div class="absolute right-0 top-0 w-[520px] h-[520px] bg-[#504E76]/45 rounded-full"></div>

                <div class="absolute right-4 top-0 w-64 h-32 rounded-2xl bg-[#FDFBE2]/80 shadow-lg overflow-hidden flex items-center justify-center">
                    <div class="text-center">
                        <div class="text-5xl mb-2">🤝</div>
                        <p class="font-bold text-[#351528]">CHARITY</p>
                    </div>
                </div>

                <div class="absolute right-20 top-28 w-80 h-36 rounded-2xl bg-[#C4C3E3]/80 shadow-xl overflow-hidden flex items-center justify-center border-4 border-[#2EA8FF]">
                    <div class="text-center px-6">
                        <div class="text-5xl mb-2">👩‍🏫</div>
                        <p class="font-semibold text-[#351528]">Relawan membantu masyarakat</p>
                    </div>
                </div>

                <div class="absolute right-48 top-64 w-80 h-36 rounded-2xl bg-[#FCDDD0]/80 shadow-xl overflow-hidden flex items-center justify-center">
                    <div class="text-center px-6">
                        <div class="text-5xl mb-2">📦</div>
                        <p class="font-semibold text-[#351528]">Dukungan untuk campaign</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATISTICS --}}
    <section class="relative -mt-12 z-20">
        <div class="max-w-6xl mx-auto px-6">
            <div class="bg-white rounded-2xl shadow-xl px-8 py-5 grid grid-cols-2 lg:grid-cols-4 gap-6 items-center">

                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#E66AA3] flex items-center justify-center text-3xl">👤</div>
                    <div>
                        <h3 class="text-3xl font-bold">12.400+</h3>
                        <p class="text-sm">Donatur</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#F4F4F4] flex items-center justify-center text-3xl">📣</div>
                    <div>
                        <h3 class="text-3xl font-bold">345</h3>
                        <p class="text-sm">Campaign Aktif</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#FCDDD0] flex items-center justify-center text-3xl">💰</div>
                    <div>
                        <h3 class="text-3xl font-bold">Rp8,2 M</h3>
                        <p class="text-sm">Dana Terkumpul</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#4B95FF] flex items-center justify-center text-3xl text-white">✓</div>
                    <div>
                        <h3 class="text-3xl font-bold">97%</h3>
                        <p class="text-sm">Campaign Terverifikasi</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- SEARCH --}}
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="font-display text-3xl font-bold mb-8">
                Temukan Campaign yang Ingin Kamu Dukung
            </h2>

            <div class="bg-white border border-[#E8DDD6] rounded-xl p-2 flex items-center shadow-sm">
                <input
                    type="text"
                    placeholder="Cari campaign, kategori, atau pembuat..."
                    class="flex-1 px-5 py-3 outline-none text-sm bg-transparent text-[#351528]"
                >
                <button class="bg-[#F1642E] text-white px-6 py-3 rounded-lg font-bold flex items-center gap-2">
                    <span>⌕</span> Cari
                </button>
            </div>
        </div>
    </section>

    {{-- CAMPAIGN TERVERIFIKASI --}}
    <section id="campaign" class="pb-20">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <p class="font-bold text-sm tracking-wide mb-3">TERVERIFIKASI</p>
                    <h2 class="font-display text-4xl font-bold">Campaign Terverifikasi</h2>
                </div>

                <a href="#" class="border border-[#351528] px-8 py-4 rounded-lg font-display text-2xl font-bold hover:bg-[#351528] hover:text-white transition">
                    Lihat Semua
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                {{-- Card 1 --}}
                <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                    <div class="h-48 bg-[#DDE8C2] flex items-center justify-center text-center px-6">
                        <div>
                            <div class="text-6xl mb-2">👧👦</div>
                            <p class="font-bold">Pendidikan Anak Papua</p>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="font-display font-bold text-lg leading-tight mb-2">
                            Beasiswa untuk 50 Anak Kurang Mampu di Papua
                        </h3>
                        <p class="text-xs mb-4">
                            oleh HatiNurani Foundation <span class="text-blue-500">♟</span>
                        </p>

                        <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden mb-3">
                            <div class="bg-[#FFC400] h-6 w-1/2 flex items-center justify-center text-sm font-bold">
                                50%
                            </div>
                        </div>

                        <div class="flex justify-between text-xs mb-6">
                            <span>Rp 188jt terkumpul</span>
                            <span>50% dari Rp 100jt</span>
                        </div>

                        <div class="flex justify-between text-xs">
                            <span>245 donatur</span>
                            <span>20 hari lagi</span>
                        </div>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                    <div class="h-48 bg-[#FCDDD0] flex items-center justify-center text-center px-6">
                        <div>
                            <div class="text-6xl mb-2">🏥</div>
                            <p class="font-bold">Bantuan Kesehatan</p>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="font-display font-bold text-lg leading-tight mb-2">
                            Operasi Katarak Gratis untuk Lansia Dhuafa
                        </h3>
                        <p class="text-xs mb-4">
                            oleh HatiNurani Foundation <span class="text-blue-500">♟</span>
                        </p>

                        <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden mb-3">
                            <div class="bg-[#FFC400] h-6 w-[45%] flex items-center justify-center text-sm font-bold">
                                45%
                            </div>
                        </div>

                        <div class="flex justify-between text-xs mb-6">
                            <span>Rp 54jt terkumpul</span>
                            <span>45% dari Rp 120jt</span>
                        </div>

                        <div class="flex justify-between text-xs">
                            <span>182 donatur</span>
                            <span>30 hari lagi</span>
                        </div>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                    <div class="h-48 bg-[#C4C3E3] flex items-center justify-center text-center px-6">
                        <div>
                            <div class="text-6xl mb-2">🌊</div>
                            <p class="font-bold">Bencana Alam</p>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="font-display font-bold text-lg leading-tight mb-2">
                            Bantu Korban Banjir Bandung 2024
                        </h3>
                        <p class="text-xs mb-4">
                            oleh HatiNurani Foundation <span class="text-blue-500">♟</span>
                        </p>

                        <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden mb-3">
                            <div class="bg-[#FFC400] h-6 w-[86%] flex items-center justify-center text-sm font-bold">
                                86%
                            </div>
                        </div>

                        <div class="flex justify-between text-xs mb-6">
                            <span>Rp 215jt terkumpul</span>
                            <span>86% dari Rp 250jt</span>
                        </div>

                        <div class="flex justify-between text-xs">
                            <span>891 donatur</span>
                            <span>5 hari lagi</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- TRUST SECTION --}}
    <section id="trust" class="pb-24">
        <div class="max-w-6xl mx-auto px-10 text-center">
            <h2 class="font-display text-3xl font-bold mb-16">
                Cara Kami Menjaga Kepercayaan Donatur
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 items-center">

                <div class="text-center">
                    <div class="mx-auto w-24 h-24 bg-white rounded-full flex items-center justify-center text-5xl mb-6 shadow">
                        📄
                    </div>
                    <h3 class="font-bold text-lg mb-3">Campaign Diajukan</h3>
                    <p class="text-base leading-relaxed">
                        Penggalang dana membuat campaign dan mengunggah data serta dokumen pendukung.
                    </p>
                </div>

                <div class="hidden md:block text-4xl font-bold">→</div>

                <div class="text-center">
                    <div class="mx-auto w-24 h-24 bg-white rounded-full flex items-center justify-center text-5xl mb-6 shadow">
                        ✅
                    </div>
                    <h3 class="font-bold text-lg mb-3">Diperiksa Admin</h3>
                    <p class="text-base leading-relaxed">
                        Admin memeriksa kelengkapan data, dokumen, dan kelayakan campaign.
                    </p>
                </div>

                <div class="hidden md:block text-4xl font-bold">→</div>

                <div class="text-center">
                    <div class="mx-auto w-24 h-24 bg-white rounded-full flex items-center justify-center text-5xl mb-6 shadow">
                        🛡️
                    </div>
                    <h3 class="font-bold text-lg mb-3">Terverifikasi</h3>
                    <p class="text-base leading-relaxed">
                        Campaign yang valid diberi badge terverifikasi dan ditampilkan kepada publik.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-[#351528] text-white pt-10 pb-20">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 pb-12 border-b border-white/20">

                <div>
                    <h2 class="font-display text-2xl font-bold mb-4">
                        Hati<span class="text-[#F1642E]">Nurani</span>
                    </h2>
                    <p class="text-sm leading-relaxed max-w-xs">
                        Platform crowdfunding terpercaya yang menghubungkan donatur dengan campaign yang membutuhkan dukungan.
                    </p>
                </div>

                <div>
                    <h3 class="font-display text-lg font-bold mb-4">PLATFORM</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#campaign">Semua Campaign</a></li>
                        <li><a href="#">Buat Campaign</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-display text-lg font-bold mb-4">AKUN</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                        <li><a href="#">Daftar</a></li>
                        <li><a href="#">Dashboard</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-display text-lg font-bold mb-4">KONTAK</h3>
                    <ul class="space-y-3 text-sm">
                        <li>📧 halo@hatinurani.id</li>
                        <li>📞 +62 812 3456 7890</li>
                        <li>📷 @hati_nurani</li>
                        <li>🌐 @hatinuraniofficial</li>
                    </ul>
                </div>

            </div>

            <p class="text-sm text-white/70 mt-6">
                © 2024 HatiNurani. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>