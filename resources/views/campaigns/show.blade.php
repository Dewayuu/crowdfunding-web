<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Campaign - HatiNurani</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FFFDF8] text-[#2D1622]">

    {{-- NAVBAR --}}
    <header class="bg-[#2D0B18] text-white">
        <div class="max-w-[1180px] mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-2xl font-extrabold tracking-tight">
                Hati<span class="text-[#F47A2A]">Nurani</span>
            </a>

            <div class="flex items-center gap-8">
                <nav class="hidden md:flex items-center gap-7 text-sm font-semibold">
                    <a href="#" class="hover:text-[#F47A2A] transition">Donasi</a>
                    <a href="#" class="hover:text-[#F47A2A] transition">Tentang</a>
                    <a href="{{ route('login') }}" class="hover:text-[#F47A2A] transition">Masuk</a>
                </nav>

                <a href="#"
                   class="bg-[#F47A2A] hover:bg-[#e86d1e] transition text-white text-sm font-bold px-7 py-3 rounded-full">
                    Daftar
                </a>
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="max-w-[1180px] mx-auto px-6 py-8">

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-2 text-sm text-[#57516E] mb-6">
            <a href="{{ url('/') }}" class="font-semibold hover:text-[#F47A2A]">Beranda</a>
            <span>/</span>
            <a href="#" class="font-semibold hover:text-[#F47A2A]">Pendidikan</a>
            <span>/</span>
            <span>Beasiswa untuk 50 Anak Kurang Mampu di Papua</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_390px] gap-8 items-start">

            {{-- LEFT CONTENT --}}
            <section class="space-y-7">

                {{-- CAMPAIGN IMAGE --}}
                <div class="relative min-h-[360px] md:min-h-[440px] rounded-3xl overflow-hidden bg-gradient-to-br from-[#7D536F] via-[#6E2B40] to-[#8C6A46] shadow-sm">
                    <div class="absolute inset-0 opacity-15"
                         style="background-image: repeating-linear-gradient(115deg, rgba(255,255,255,.35) 0px, rgba(255,255,255,.35) 1px, transparent 1px, transparent 16px);">
                    </div>

                    <div class="absolute top-6 left-6">
                        <span class="inline-flex items-center gap-2 bg-[#B9C66A] text-[#2D1622] text-sm font-bold px-4 py-2 rounded-full">
                            <span class="w-4 h-4 rounded-full border border-[#2D1622] flex items-center justify-center text-[10px]">✓</span>
                            Terverifikasi
                        </span>
                    </div>

                    <div class="absolute left-6 bottom-6 bg-[#35121D]/75 text-white text-sm font-bold px-4 py-2 rounded-full">
                        Foto 1 dari 5 · Dokumentasi lapangan, Jayapura
                    </div>

                    <div class="absolute right-6 bottom-7 flex items-center gap-2">
                        <span class="w-8 h-2 rounded-full bg-white"></span>
                        <span class="w-2 h-2 rounded-full bg-white/50"></span>
                        <span class="w-2 h-2 rounded-full bg-white/50"></span>
                        <span class="w-2 h-2 rounded-full bg-white/50"></span>
                        <span class="w-2 h-2 rounded-full bg-white/50"></span>
                    </div>
                </div>

                {{-- TITLE AREA --}}
                <div>
                    <span class="inline-flex bg-[#FDE7D7] text-[#E46522] text-xs font-extrabold tracking-widest px-4 py-2 rounded-full mb-5">
                        PENDIDIKAN
                    </span>

                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight text-[#2D0B18] max-w-4xl">
                        Beasiswa untuk 50 Anak Kurang Mampu di Papua
                    </h1>

                    <div class="flex items-center gap-4 mt-6">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-[#C7C2E5] to-[#6B6695] flex items-center justify-center text-white text-sm font-bold">
                            YS
                        </div>

                        <div class="text-sm md:text-base text-[#6F6A7D]">
                            Dibuat oleh
                            <span class="font-bold text-[#2D1622]">Yayasan Sinar Harapan</span>
                            <span class="inline-flex items-center gap-1 text-[#78913E] font-semibold ml-1">
                                <span>✓</span> Akun terverifikasi
                            </span>
                        </div>
                    </div>
                </div>

                {{-- TABS --}}
                <div class="border-b border-[#E8DDCC]">
                    <div class="flex items-center gap-8 md:gap-14 text-sm md:text-base font-bold text-[#6F6A7D]">
                        <button class="pb-4 border-b-3 border-[#F47A2A] text-[#2D1622]">
                            Deskripsi
                        </button>
                        <button class="pb-4 hover:text-[#2D1622]">
                            Dokumen Pendukung
                        </button>
                        <button class="pb-4 hover:text-[#2D1622]">
                            Update Campaign
                        </button>
                    </div>
                </div>

                {{-- DESCRIPTION --}}
                <article class="space-y-6 text-[17px] leading-8 text-[#34304A]">
                    <p>
                        Di pedalaman Jayapura, lebih dari <strong class="text-[#2D1622]">50 anak usia sekolah</strong>
                        harus berhenti belajar karena keluarga mereka tidak mampu membiayai seragam, buku,
                        dan transportasi menuju sekolah terdekat yang berjarak hingga 8 km. Yayasan Sinar
                        Harapan telah mendampingi anak-anak ini selama 3 tahun terakhir.
                    </p>

                    <p>
                        Donasi yang terkumpul akan dialokasikan untuk biaya pendidikan satu tahun ajaran penuh
                        — meliputi SPP, seragam, alat tulis, dan uang transportasi. Setiap rupiah yang masuk
                        akan dilaporkan secara berkala melalui menu
                        <strong class="text-[#2D1622]">Update Campaign</strong> di bawah, lengkap dengan bukti penyaluran.
                    </p>
                </article>

                {{-- INFO CARDS --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-[#FFF9E7] border border-[#EFE3BF] rounded-2xl p-5">
                        <h3 class="text-3xl font-extrabold text-[#2D0B18]">50</h3>
                        <p class="text-sm text-[#57516E] mt-2">Anak penerima manfaat</p>
                    </div>

                    <div class="bg-[#FFF9E7] border border-[#EFE3BF] rounded-2xl p-5">
                        <h3 class="text-3xl font-extrabold text-[#2D0B18]">3 thn</h3>
                        <p class="text-sm text-[#57516E] mt-2">Rekam jejak yayasan</p>
                    </div>

                    <div class="bg-[#FFF9E7] border border-[#EFE3BF] rounded-2xl p-5">
                        <h3 class="text-3xl font-extrabold text-[#2D0B18]">12</h3>
                        <p class="text-sm text-[#57516E] mt-2">Campaign sebelumnya</p>
                    </div>
                </div>

                {{-- DATE INFO --}}
                <div class="text-[17px] text-[#34304A]">
                    Tanggal campaign dibuat:
                    <strong class="text-[#2D1622]">3 Juni 2026</strong>
                    <span class="mx-1">·</span>
                    Tanggal verifikasi:
                    <strong class="text-[#2D1622]">5 Juni 2026</strong>
                </div>

                {{-- DOCUMENT SUPPORT --}}
                <section class="bg-white border border-[#E8DDCC] rounded-3xl p-6 shadow-sm">
                    <h2 class="text-xl font-extrabold mb-4">Dokumen Pendukung</h2>

                    <div class="bg-[#EEF4E4] border border-[#DCE8C8] rounded-2xl p-5 text-[#78913E]">
                        <p class="font-bold">✓ Dokumen telah diperiksa admin</p>
                        <p class="text-sm mt-1">
                            Dokumen identitas penerima, legalitas lembaga, dan bukti kebutuhan campaign telah diverifikasi
                            oleh tim HatiNurani sebelum campaign dipublikasikan.
                        </p>
                    </div>

                    <p class="text-sm text-[#6F6A7D] mt-4">
                        Catatan: dokumen sensitif tidak ditampilkan penuh kepada publik untuk menjaga keamanan data penerima donasi.
                    </p>
                </section>

                {{-- UPDATE CAMPAIGN --}}
                <section class="bg-white border border-[#E8DDCC] rounded-3xl p-6 shadow-sm">
                    <h2 class="text-xl font-extrabold mb-4">Update Campaign</h2>

                    <div class="space-y-5">
                        <div class="border-l-4 border-[#F47A2A] pl-4">
                            <p class="text-sm text-[#6F6A7D]">10 Juni 2026</p>
                            <h3 class="font-bold text-[#2D1622] mt-1">Pendataan penerima manfaat selesai</h3>
                            <p class="text-sm text-[#57516E] mt-1">
                                Tim yayasan telah menyelesaikan validasi data 50 anak penerima bantuan pendidikan.
                            </p>
                        </div>

                        <div class="border-l-4 border-[#B9C66A] pl-4">
                            <p class="text-sm text-[#6F6A7D]">7 Juni 2026</p>
                            <h3 class="font-bold text-[#2D1622] mt-1">Campaign mulai dipublikasikan</h3>
                            <p class="text-sm text-[#57516E] mt-1">
                                Campaign telah lolos pemeriksaan admin dan dapat menerima donasi dari masyarakat.
                            </p>
                        </div>
                    </div>
                </section>
            </section>

            {{-- RIGHT SIDEBAR --}}
            <aside class="space-y-5 lg:sticky lg:top-6">

                {{-- DONATION CARD --}}
                <div class="bg-white border border-[#E8DDCC] rounded-3xl p-6 shadow-[0_18px_45px_rgba(45,11,24,0.08)]">
                    <div>
                        <p class="text-[#F47A2A] font-bold">
                            Rp
                            <span class="text-4xl font-extrabold text-[#2D0B18] ml-1">8.300.000</span>
                        </p>

                        <p class="text-sm text-[#6F6A7D] mt-2">
                            terkumpul dari target
                            <strong class="text-[#2D1622]">Rp 16.600.000</strong>
                        </p>
                    </div>

                    <div class="mt-5">
                        <div class="w-full h-3 bg-[#FFF5DB] rounded-full overflow-hidden">
                            <div class="w-1/2 h-full bg-[#84964D] rounded-full relative">
                                <span class="absolute left-full -translate-x-1/2 -top-1 text-[11px] text-white font-bold">
                                    50%
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-3 text-sm">
                            <p><strong>243</strong> <span class="text-[#6F6A7D]">donatur</span></p>
                            <p><strong>20</strong> <span class="text-[#6F6A7D]">hari lagi</span></p>
                        </div>
                    </div>

                    <div class="mt-6 bg-[#FDE9DA] text-[#E46522] rounded-xl px-4 py-3 text-sm font-bold">
                        ⏱ Batas waktu: 12 Juli 2026
                    </div>

                    <div class="grid grid-cols-3 gap-2 mt-6">
                        <button class="bg-[#FFF9E7] hover:bg-[#FFF2C9] rounded-xl py-3 text-sm font-bold">
                            Rp 25rb
                        </button>

                        <button class="bg-[#56517E] text-white rounded-xl py-3 text-sm font-bold">
                            Rp 50rb
                        </button>

                        <button class="bg-[#FFF9E7] hover:bg-[#FFF2C9] rounded-xl py-3 text-sm font-bold">
                            Rp 100rb
                        </button>
                    </div>

                    <div class="mt-4 border border-[#E8DDCC] rounded-xl px-4 py-3">
                        <span class="text-[#6F6A7D] font-bold mr-2">Rp</span>
                        <span class="font-bold">50.000</span>
                    </div>

                    <button class="w-full bg-[#F47A2A] hover:bg-[#e86d1e] text-white font-extrabold rounded-xl py-4 mt-5 transition">
                        Donasi Sekarang
                    </button>

                    <div class="grid grid-cols-2 gap-2 mt-3">
                        <button class="bg-[#FFF9E7] hover:bg-[#FFF2C9] rounded-xl py-3 text-sm font-bold">
                            ↗ Bagikan
                        </button>

                        <button class="bg-[#FFF9E7] hover:bg-[#FFF2C9] rounded-xl py-3 text-sm font-bold">
                            ♡ Simpan
                        </button>
                    </div>
                </div>

                {{-- RECIPIENT PROFILE --}}
                <div class="bg-white border border-[#E8DDCC] rounded-3xl p-6 shadow-sm">
                    <h2 class="text-xl font-extrabold flex items-center gap-2 mb-6">
                        <span class="text-[#56517E]">♙</span>
                        Profil Penerima Donasi
                    </h2>

                    <div class="space-y-0 text-sm">
                        <div class="flex items-center justify-between border-b border-[#E8DDCC] py-3 gap-4">
                            <span class="text-[#6F6A7D]">Tipe penerima</span>
                            <strong class="text-right">Organisasi / Lembaga Resmi</strong>
                        </div>

                        <div class="flex items-center justify-between border-b border-[#E8DDCC] py-3 gap-4">
                            <span class="text-[#6F6A7D]">Nama penerima</span>
                            <strong class="text-right">Yayasan Sinar Harapan</strong>
                        </div>

                        <div class="flex items-center justify-between border-b border-[#E8DDCC] py-3 gap-4">
                            <span class="text-[#6F6A7D]">Identitas legalitas</span>
                            <strong class="text-right">Terverifikasi admin</strong>
                        </div>
                    </div>

                    <div class="bg-[#EEF4E4] rounded-xl px-4 py-4 mt-4 text-sm text-[#78913E]">
                        <p class="font-bold">
                            ✓ Dokumen identitas penerima telah diperiksa tim HatiNurani sebelum campaign dipublikasikan.
                        </p>
                    </div>
                </div>

                {{-- LATEST DONORS --}}
                <div class="bg-white border border-[#E8DDCC] rounded-3xl p-6 shadow-sm">
                    <h2 class="text-xl font-extrabold mb-6">Donatur Terbaru</h2>

                    <div class="space-y-5">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#B9C66A] to-[#D7D7E1]"></div>
                                <div>
                                    <p class="font-bold text-sm">Budi Santoso</p>
                                    <p class="text-xs text-[#6F6A7D]">2 jam lalu</p>
                                </div>
                            </div>
                            <p class="font-bold text-[#78913E] text-sm">Rp 100rb</p>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#B9C66A] to-[#D7D7E1]"></div>
                                <div>
                                    <p class="font-bold text-sm">Hamba Allah</p>
                                    <p class="text-xs text-[#6F6A7D]">5 jam lalu</p>
                                </div>
                            </div>
                            <p class="font-bold text-[#78913E] text-sm">Rp 50rb</p>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#B9C66A] to-[#D7D7E1]"></div>
                                <div>
                                    <p class="font-bold text-sm">Ratna Wijaya</p>
                                    <p class="text-xs text-[#6F6A7D]">1 hari lalu</p>
                                </div>
                            </div>
                            <p class="font-bold text-[#78913E] text-sm">Rp 250rb</p>
                        </div>
                    </div>

                    <div class="border-t border-[#E8DDCC] mt-6 pt-4 text-center">
                        <a href="#" class="text-[#56517E] font-bold text-sm hover:text-[#F47A2A]">
                            Lihat semua 243 donatur
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>