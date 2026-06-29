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

    {{-- ======================== NAVBAR ======================== --}}
    @include('layouts.navbar')

    {{-- ======================== HERO ======================== --}}
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

    {{-- ======================== STATISTICS ======================== --}}
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

    {{-- ======================== SEARCH ======================== --}}
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="font-display text-3xl font-bold mb-8">
                Temukan Campaign yang Ingin Kamu Dukung
            </h2>

            <form action="{{ route('campaigns.index') }}" method="GET" class="bg-white border border-[#E8DDD6] rounded-xl p-2 flex items-center shadow-sm">
                <input
                    type="text"
                    name="search"
                    placeholder="Cari campaign, kategori, atau pembuat..."
                    class="flex-1 px-5 py-3 outline-none text-sm bg-transparent text-[#351528]"
                >

                <button type="submit" class="bg-[#F1642E] text-white px-6 py-3 rounded-lg font-bold flex items-center gap-2">
                    <span>⌕</span> Cari
                </button>
            </form>
        </div>
    </section>

    {{-- ======================== CAMPAIGN TERVERIFIKASI ======================== --}}
    <section id="campaign" class="pb-20">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <p class="font-bold text-sm tracking-wide mb-3">TERVERIFIKASI</p>
                    <h2 class="font-display text-4xl font-bold">Campaign Terverifikasi</h2>
                </div>

                <a href="{{ route('campaigns.index') }}" class="border border-[#351528] px-8 py-4 rounded-lg font-display text-2xl font-bold hover:bg-[#351528] hover:text-white transition">
                    Lihat Semua
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                @forelse (($campaigns ?? collect()) as $campaign)
                    @php
                        $targetAmount = (float) $campaign->target_amount;
                        $currentAmount = (float) $campaign->current_amount;

                        $percentage = $targetAmount > 0
                            ? min(100, round(($currentAmount / $targetAmount) * 100))
                            : 0;

                        $daysLeft = $campaign->end_date
                            ? max(0, (int) now()->startOfDay()->diffInDays($campaign->end_date, false))
                            : null;

                        $categorySlug = $campaign->category->slug ?? '';

                        $categoryEmoji = match ($categorySlug) {
                            'pendidikan' => '👧👦',
                            'kesehatan' => '🏥',
                            'bencana-alam' => '🌊',
                            'bencana' => '🌊',
                            'sosial-kemanusiaan' => '🤝',
                            default => '🤝',
                        };

                        $cardBg = match ($categorySlug) {
                            'pendidikan' => 'bg-[#DDE8C2]',
                            'kesehatan' => 'bg-[#FCDDD0]',
                            'bencana-alam' => 'bg-[#C4C3E3]',
                            'bencana' => 'bg-[#C4C3E3]',
                            'sosial-kemanusiaan' => 'bg-[#FFF2C9]',
                            default => 'bg-[#FDFBE2]',
                        };

                        $ownerName = $campaign->user->name
                            ?? $campaign->user->full_name
                            ?? $campaign->user->username
                            ?? $campaign->user->email
                            ?? 'Fundraiser';
                    @endphp

                    <a href="{{ route('campaigns.show', $campaign->campaign_id) }}"
                       class="bg-white rounded-xl shadow-xl overflow-hidden hover:-translate-y-1 hover:shadow-2xl transition block">

                        <div class="h-48 {{ $cardBg }} flex items-center justify-center text-center px-6">
                            <div>
                                <div class="text-6xl mb-2">{{ $categoryEmoji }}</div>
                                <p class="font-bold">
                                    {{ $campaign->category->category_name ?? 'Campaign Sosial' }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="font-display font-bold text-lg leading-tight mb-2">
                                {{ $campaign->title }}
                            </h3>

                            <p class="text-xs mb-4">
                                oleh {{ $ownerName }}
                                <span class="text-blue-500">♟</span>
                            </p>

                            <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden mb-3">
                                <div class="bg-[#FFC400] h-6 flex items-center justify-center text-sm font-bold"
                                     style="width: {{ $percentage }}%;">
                                    {{ $percentage }}%
                                </div>
                            </div>

                            <div class="flex justify-between text-xs mb-6 gap-4">
                                <span>
                                    Rp {{ number_format($currentAmount, 0, ',', '.') }} terkumpul
                                </span>

                                <span>
                                    {{ $percentage }}% dari Rp {{ number_format($targetAmount, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between text-xs">
                                <span>{{ $campaign->donations_count ?? 0 }} donatur</span>

                                <span>
                                    @if ($daysLeft !== null)
                                        {{ $daysLeft }} hari lagi
                                    @else
                                        Tidak ada batas waktu
                                    @endif
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="md:col-span-3 bg-white rounded-xl shadow p-10 text-center">
                        <h3 class="font-display text-2xl font-bold mb-3">
                            Belum Ada Campaign Terverifikasi
                        </h3>

                        <p class="text-sm text-[#351528]/70">
                            Campaign yang telah disetujui admin akan tampil di halaman ini.
                        </p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

    {{-- ======================== TENTANG ======================== --}}
    <section id="tentang" class="py-20 bg-[#FFF8D8]">
        <div class="max-w-7xl mx-auto px-10 lg:px-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="font-bold text-sm tracking-[0.18em] text-[#F1642E] mb-4">
                        TENTANG HATINURANI
                    </p>

                    <h2 class="font-display text-4xl font-bold leading-tight mb-6">
                        Menghubungkan Donatur dengan Campaign yang Lebih Terpercaya
                    </h2>

                    <p class="text-base leading-relaxed mb-5">
                        HatiNurani adalah platform crowdfunding donasi yang membantu mempertemukan
                        donatur dengan campaign sosial yang membutuhkan dukungan. Platform ini
                        dirancang untuk membantu donatur berdonasi dengan lebih aman, jelas, dan
                        percaya.
                    </p>

                    <p class="text-base leading-relaxed">
                        Setiap campaign yang diajukan akan melalui proses pemeriksaan oleh admin,
                        mulai dari kelengkapan data, profil penerima donasi, hingga dokumen pendukung
                        sebelum ditampilkan kepada publik.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-8 shadow-xl border border-[#E8DDD6]">
                    <div class="space-y-6">
                        <div>
                            <h3 class="font-display text-2xl font-bold mb-2">Transparan</h3>
                            <p class="text-sm leading-relaxed">
                                Informasi campaign, penerima donasi, dan progress penggalangan dana
                                ditampilkan secara jelas agar donatur memahami tujuan donasi.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-display text-2xl font-bold mb-2">Terverifikasi</h3>
                            <p class="text-sm leading-relaxed">
                                Campaign diperiksa oleh admin sebelum mendapatkan badge terverifikasi
                                dan ditampilkan kepada publik.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-display text-2xl font-bold mb-2">Berorientasi Kepercayaan</h3>
                            <p class="text-sm leading-relaxed">
                                Sistem dirancang untuk membantu donatur merasa lebih yakin sebelum
                                memberikan dukungan kepada sebuah campaign.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== TRUST SECTION ======================== --}}
    <section id="trust" class="py-24">
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

    {{-- ======================== FOOTER ======================== --}}
    @include('layouts.footer')

</body>
</html>