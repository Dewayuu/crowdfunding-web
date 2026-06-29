<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->title ?? 'Detail Campaign' }} - HatiNurani</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
    $targetAmount = (float) ($campaign->target_amount ?? 0);
    $currentAmount = (float) ($campaign->current_amount ?? 0);

    $percentage = $targetAmount > 0
        ? min(100, round(($currentAmount / $targetAmount) * 100))
        : 0;

    $daysLeft = $campaign->end_date
        ? max(0, (int) now()->startOfDay()->diffInDays($campaign->end_date, false))
        : null;

    $categoryName = $campaign->category->category_name ?? 'Campaign Sosial';

    $ownerName = $campaign->user->name ?? 'Fundraiser';
    $ownerInitial = strtoupper(substr($ownerName, 0, 1));

    $beneficiary = $campaign->beneficiary ?? null;

    $primaryImage = $campaign->images?->firstWhere('is_primary', 'yes') ?? $campaign->images?->first();
    $imageCaption = $primaryImage->caption ?? 'Dokumentasi campaign';

    $createdDate = $campaign->created_at
        ? $campaign->created_at->format('d M Y')
        : '-';

    $endDate = $campaign->end_date
        ? $campaign->end_date->format('d M Y')
        : '-';

    $donorCount = $campaign->donations_count ?? 0;
@endphp

<script
    type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<body class="bg-[#FFFDF8] text-[#2D1622]">

    {{-- NAVBAR --}}
    <header class="bg-[#2D0B18] text-white">
        <div class="max-w-[1180px] mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-2xl font-extrabold tracking-tight">
                Hati<span class="text-[#F47A2A]">Nurani</span>
            </a>

            <div class="flex items-center gap-8">
                <nav class="hidden md:flex items-center gap-7 text-sm font-semibold">
                    <a href="{{ route('campaigns.index') }}" class="hover:text-[#F47A2A] transition">
                        Donasi
                    </a>

                    <a href="{{ url('/#tentang') }}" class="hover:text-[#F47A2A] transition">
                        Tentang
                    </a>

                    @auth
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#F47A2A] transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="hover:text-[#F47A2A] transition">
                                Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="hover:text-[#F47A2A] transition">
                            Masuk
                        </a>
                    @endauth
                </nav>

                @guest
                    <a href="{{ route('register') }}"
                       class="bg-[#F47A2A] hover:bg-[#e86d1e] transition text-white text-sm font-bold px-7 py-3 rounded-full">
                        Daftar
                    </a>
                @endguest
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="max-w-[1180px] mx-auto px-6 py-8">

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-2 text-sm text-[#57516E] mb-6 flex-wrap">
            <a href="{{ url('/') }}" class="font-semibold hover:text-[#F47A2A]">
                Beranda
            </a>

            <span>/</span>

            <a href="{{ route('campaigns.index') }}" class="font-semibold hover:text-[#F47A2A]">
                {{ $categoryName }}
            </a>

            <span>/</span>

            <span>{{ $campaign->title }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_390px] gap-8 items-start">

            {{-- LEFT CONTENT --}}
            <section class="space-y-7">

                {{-- CAMPAIGN IMAGE / PLACEHOLDER --}}
                <div class="relative min-h-[360px] md:min-h-[440px] rounded-3xl overflow-hidden bg-gradient-to-br from-[#7D536F] via-[#6E2B40] to-[#8C6A46] shadow-sm">
                    <div class="absolute inset-0 opacity-15"
                         style="background-image: repeating-linear-gradient(115deg, rgba(255,255,255,.35) 0px, rgba(255,255,255,.35) 1px, transparent 1px, transparent 16px);">
                    </div>

                    <div class="absolute top-6 left-6">
                        <span class="inline-flex items-center gap-2 bg-[#B9C66A] text-[#2D1622] text-sm font-bold px-4 py-2 rounded-full">
                            <span class="w-4 h-4 rounded-full border border-[#2D1622] flex items-center justify-center text-[10px]">
                                ✓
                            </span>
                            Terverifikasi
                        </span>
                    </div>

                    <div class="absolute left-6 bottom-6 bg-[#35121D]/75 text-white text-sm font-bold px-4 py-2 rounded-full">
                        {{ $imageCaption }}
                    </div>

                    <div class="absolute right-6 bottom-7 flex items-center gap-2">
                        <span class="w-8 h-2 rounded-full bg-white"></span>
                        <span class="w-2 h-2 rounded-full bg-white/50"></span>
                        <span class="w-2 h-2 rounded-full bg-white/50"></span>
                    </div>
                </div>

                {{-- TITLE AREA --}}
                <div>
                    <span class="inline-flex bg-[#FDE7D7] text-[#E46522] text-xs font-extrabold tracking-widest px-4 py-2 rounded-full mb-5 uppercase">
                        {{ $categoryName }}
                    </span>

                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight text-[#2D0B18] max-w-4xl">
                        {{ $campaign->title }}
                    </h1>

                    <div class="flex items-center gap-4 mt-6">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-[#C7C2E5] to-[#6B6695] flex items-center justify-center text-white text-sm font-bold">
                            {{ $ownerInitial }}
                        </div>

                        <div class="text-sm md:text-base text-[#6F6A7D]">
                            Dibuat oleh
                            <span class="font-bold text-[#2D1622]">
                                {{ $ownerName }}
                            </span>

                            <span class="inline-flex items-center gap-1 text-[#78913E] font-semibold ml-1">
                                <span>✓</span> Akun terverifikasi
                            </span>
                        </div>
                    </div>
                </div>

                {{-- DESCRIPTION --}}
                <article class="space-y-6 text-[17px] leading-8 text-[#34304A]">
                    <h2 class="text-2xl font-extrabold text-[#2D0B18]">
                        Deskripsi Campaign
                    </h2>

                    <p>
                        {{ $campaign->story }}
                    </p>

                    @if (!empty($campaign->short_description))
                        <p>
                            {{ $campaign->short_description }}
                        </p>
                    @endif
                </article>

                {{-- INFO CARDS --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-[#FFF9E7] border border-[#EFE3BF] rounded-2xl p-5">
                        <h3 class="text-3xl font-extrabold text-[#2D0B18]">
                            {{ $percentage }}%
                        </h3>
                        <p class="text-sm text-[#57516E] mt-2">
                            Progress penggalangan dana
                        </p>
                    </div>

                    <div class="bg-[#FFF9E7] border border-[#EFE3BF] rounded-2xl p-5">
                        <h3 class="text-3xl font-extrabold text-[#2D0B18]">
                            {{ $donorCount }}
                        </h3>
                        <p class="text-sm text-[#57516E] mt-2">
                            Donatur berpartisipasi
                        </p>
                    </div>

                    <div class="bg-[#FFF9E7] border border-[#EFE3BF] rounded-2xl p-5">
                        <h3 class="text-3xl font-extrabold text-[#2D0B18]">
                            @if ($daysLeft !== null)
                                {{ $daysLeft }}
                            @else
                                -
                            @endif
                        </h3>
                        <p class="text-sm text-[#57516E] mt-2">
                            Hari tersisa
                        </p>
                    </div>
                </div>

                {{-- DATE INFO --}}
                <div class="text-[17px] text-[#34304A]">
                    Tanggal campaign dibuat:
                    <strong class="text-[#2D1622]">{{ $createdDate }}</strong>

                    <span class="mx-1">·</span>

                    Batas waktu:
                    <strong class="text-[#2D1622]">{{ $endDate }}</strong>
                </div>

                {{-- DOCUMENT SUPPORT --}}
                <section class="bg-white border border-[#E8DDCC] rounded-3xl p-6 shadow-sm">
                    <h2 class="text-xl font-extrabold mb-4">Dokumen Pendukung</h2>

                    <div class="bg-[#EEF4E4] border border-[#DCE8C8] rounded-2xl p-5 text-[#78913E]">
                        <p class="font-bold">✓ Dokumen telah diperiksa admin</p>

                        <p class="text-sm mt-1">
                            Dokumen identitas penerima, legalitas, dan data pendukung campaign telah diverifikasi
                            oleh tim HatiNurani sebelum campaign dipublikasikan.
                        </p>
                    </div>

                    @if ($beneficiary && $beneficiary->document_path)
                        <p class="text-sm text-[#6F6A7D] mt-4">
                            Dokumen tersimpan:
                            <span class="font-semibold text-[#2D1622]">
                                {{ $beneficiary->document_path }}
                            </span>
                        </p>
                    @endif

                    <p class="text-sm text-[#6F6A7D] mt-4">
                        Catatan: dokumen sensitif tidak ditampilkan penuh kepada publik untuk menjaga keamanan data penerima donasi.
                    </p>
                </section>

                {{-- UPDATE CAMPAIGN --}}
                <section class="bg-white border border-[#E8DDCC] rounded-3xl p-6 shadow-sm">
                    <h2 class="text-xl font-extrabold mb-4">Update Campaign</h2>

                    <div class="space-y-5">
                        <div class="border-l-4 border-[#F47A2A] pl-4">
                            <p class="text-sm text-[#6F6A7D]">{{ $createdDate }}</p>

                            <h3 class="font-bold text-[#2D1622] mt-1">
                                Campaign mulai dipublikasikan
                            </h3>

                            <p class="text-sm text-[#57516E] mt-1">
                                Campaign telah lolos pemeriksaan admin dan dapat menerima donasi dari masyarakat.
                            </p>
                        </div>

                        <div class="border-l-4 border-[#B9C66A] pl-4">
                            <p class="text-sm text-[#6F6A7D]">Status saat ini</p>

                            <h3 class="font-bold text-[#2D1622] mt-1">
                                Campaign terverifikasi
                            </h3>

                            <p class="text-sm text-[#57516E] mt-1">
                                Campaign ini telah melalui proses verifikasi dan ditampilkan kepada publik.
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
                            <span class="text-4xl font-extrabold text-[#2D0B18] ml-1">
                                {{ number_format($currentAmount, 0, ',', '.') }}
                            </span>
                        </p>

                        <p class="text-sm text-[#6F6A7D] mt-2">
                            terkumpul dari target
                            <strong class="text-[#2D1622]">
                                Rp {{ number_format($targetAmount, 0, ',', '.') }}
                            </strong>
                        </p>
                    </div>

                    <div class="mt-5">
                        <div class="w-full h-3 bg-[#FFF5DB] rounded-full overflow-hidden">
                            <div class="h-full bg-[#84964D] rounded-full relative"
                                 style="width: {{ $percentage }}%;">
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-3 text-sm">
                            <p>
                                <strong>{{ $donorCount }}</strong>
                                <span class="text-[#6F6A7D]">donatur</span>
                            </p>

                            <p>
                                @if ($daysLeft !== null)
                                    <strong>{{ $daysLeft }}</strong>
                                    <span class="text-[#6F6A7D]">hari lagi</span>
                                @else
                                    <strong>-</strong>
                                    <span class="text-[#6F6A7D]">tanpa batas waktu</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 bg-[#FDE9DA] text-[#E46522] rounded-xl px-4 py-3 text-sm font-bold">
                        ⏱ Batas waktu: {{ $endDate }}
                    </div>

                    <div class="alert alert-info">
                        <strong>Sisa target donasi:</strong>
                        Rp {{ number_format($campaign->remaining_target, 0, ',', '.') }}
                    </div>

                    {{-- FORM DONASI PLACEHOLDER UNTUK MIDTRANS --}}
                    <form id="donationForm" action="#" method="POST" class="mt-6">
                        @csrf

                        <input type="hidden" name="campaign_id" value="{{ $campaign->campaign_id }}">

                        <div class="grid grid-cols-3 gap-2">
                            <button type="button"
                                    data-amount="25000"
                                    class="donation-option bg-[#FFF9E7] hover:bg-[#FFF2C9] rounded-xl py-3 text-sm font-bold transition">
                                Rp 25rb
                            </button>

                            <button type="button"
                                    data-amount="50000"
                                    class="donation-option bg-[#56517E] text-white rounded-xl py-3 text-sm font-bold transition">
                                Rp 50rb
                            </button>

                            <button type="button"
                                    data-amount="100000"
                                    class="donation-option bg-[#FFF9E7] hover:bg-[#FFF2C9] rounded-xl py-3 text-sm font-bold transition">
                                Rp 100rb
                            </button>
                        </div>

                        <div class="mt-4 border border-[#E8DDCC] rounded-xl px-4 py-3 flex items-center">
                            <span class="text-[#6F6A7D] font-bold mr-2">Rp</span>

                            <input
                                id="donation_amount"
                                type="number"
                                name="amount"
                                value="50000"
                                min="5000"
                                max="{{ $campaign->remaining_target }}"
                                step="1000"
                                class="w-full outline-none font-bold bg-transparent text-[#2D1622]"
                                required
                            >
                        </div>

                        <p class="text-xs text-[#6F6A7D] mt-2">
                            Kamu juga bisa memasukkan nominal donasi secara manual. Minimal donasi Rp5.000.
                            <br> Maksimal Rp {{ number_format($campaign->remaining_target,0,',','.') }}
                        </p>

                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-[#2D1622] mb-2">
                                Pesan Dukungan (Opsional)
                            </label>

                            <textarea
                                name="support_message"
                                rows="3"
                                maxlength="500"
                                class="w-full border border-[#E8DDCC] rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#F47A2A]"
                                placeholder="Berikan pesan dukungan.."
                            ></textarea>
                        </div>

                        <div class="flex items-center gap-3 mt-4">
                            <input
                                type="checkbox"
                                id="is_anonymous"
                                name="is_anonymous"
                                value="yes"
                            >

                            <label for="is_anonymous">
                                Sembunyikan nama saya sebagai donatur
                            </label>

                        </div>
                        @auth
                        <button type="submit" 
                            id="donateButton"
                            class="w-full bg-[#F47A2A] hover:bg-[#e86d1e] text-white font-extrabold rounded-xl py-4 mt-5 transition
                            {{ $campaign->remaining_target <=0 ? 'disabled' : '' }}">
                            Donasi Sekarang
                        </button>
                        @endauth

                        @guest
                        <button
                            type="button" 
                            class="w-full bg-[#F47A2A] hover:bg-[#e86d1e] text-white font-extrabold rounded-xl py-4 mt-5 transition"
                            onclick="loginRequired()">
                            Donasi Sekarang
                        </button>
                        @endguest
                    </form>

                    <div class="grid grid-cols-2 gap-2 mt-3">
                        <button type="button" class="bg-[#FFF9E7] hover:bg-[#FFF2C9] rounded-xl py-3 text-sm font-bold">
                            ↗ Bagikan
                        </button>

                        <button type="button" class="bg-[#FFF9E7] hover:bg-[#FFF2C9] rounded-xl py-3 text-sm font-bold">
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
                            <strong class="text-right">
                                {{ $beneficiary->beneficiary_type ?? 'Belum tersedia' }}
                            </strong>
                        </div>

                        <div class="flex items-center justify-between border-b border-[#E8DDCC] py-3 gap-4">
                            <span class="text-[#6F6A7D]">Nama penerima</span>
                            <strong class="text-right">
                                {{ $beneficiary->name ?? 'Belum tersedia' }}
                            </strong>
                        </div>

                        <div class="flex items-center justify-between border-b border-[#E8DDCC] py-3 gap-4">
                            <span class="text-[#6F6A7D]">Identitas legalitas</span>
                            <strong class="text-right">
                                Terverifikasi admin
                            </strong>
                        </div>
                    </div>

                    @if ($beneficiary && $beneficiary->description)
                        <p class="text-sm text-[#57516E] mt-4 leading-relaxed">
                            {{ $beneficiary->description }}
                        </p>
                    @endif

                    <div class="bg-[#EEF4E4] rounded-xl px-4 py-4 mt-4 text-sm text-[#78913E]">
                        <p class="font-bold">
                            ✓ Dokumen identitas penerima telah diperiksa tim HatiNurani sebelum campaign dipublikasikan.
                        </p>
                    </div>
                </div>

                {{-- LATEST DONORS --}}
                <div class="bg-white border border-[#E8DDCC] rounded-3xl p-6 shadow-sm">
                    <h2 class="text-xl font-extrabold mb-6">Donatur Terbaru</h2>

                    <div class="bg-[#FFF9E7] border border-[#EFE3BF] rounded-2xl p-5 text-sm text-[#57516E]">
                        Data donatur terbaru akan tampil setelah fitur donasi dan Midtrans terhubung.
                    </div>

                    <div class="border-t border-[#E8DDCC] mt-6 pt-4 text-center">
                        <span class="text-[#56517E] font-bold text-sm">
                            Total {{ $donorCount }} donatur
                        </span>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <script>
        function loginRequired() {
            Swal.fire({
                icon: 'warning',
                title: 'Oops! Kamu belum login',
                text: 'Silahkan melakukan login terlebih dahulu untuk mulai berdonasi.',
                showCancelButton: true,
                confirmButtonColor: '#F47A2A', 
                cancelButtonColor: '#56517E',
                confirmButtonText: 'Masuk / Login',
                cancelButtonText: 'Nanti Saja'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }
        const donationOptions = document.querySelectorAll('.donation-option');
        const donationInput = document.getElementById('donation_amount');

        function setActiveDonationButton(selectedButton) {
            donationOptions.forEach((button) => {
                button.classList.remove('bg-[#56517E]', 'text-white');
                button.classList.add('bg-[#FFF9E7]', 'hover:bg-[#FFF2C9]');
            });

            if (selectedButton) {
                selectedButton.classList.remove('bg-[#FFF9E7]', 'hover:bg-[#FFF2C9]');
                selectedButton.classList.add('bg-[#56517E]', 'text-white');
            }
        }

        donationOptions.forEach((button) => {
            button.addEventListener('click', () => {
                donationInput.value = button.dataset.amount;
                setActiveDonationButton(button);
            });
        });

        donationInput.addEventListener('input', () => {
            const matchingButton = Array.from(donationOptions).find((button) => {
                return button.dataset.amount === donationInput.value;
            });

            setActiveDonationButton(matchingButton || null);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>

<script>
document
.getElementById('donationForm')
.addEventListener('submit', async function(e){

    e.preventDefault();

    const form = this;

    const formData = new FormData(form);

    try {

        const response = await fetch(
            "{{ route('donations.store') }}",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            }
        );

        const result = await response.json();

        if(result.success){

            snap.pay(result.snap_token,{

                onSuccess: function(result){
                    console.log(result);
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Pembayaran berhasil.',
                        confirmButtonColor: '#F47A2A'
                    }).then(() => {
                        location.reload();
                    });
                },

                onPending: function(result){
                    console.log(result);
                    
                    Swal.fire({
                        icon: 'info',
                        title: 'Tertunda',
                        text: 'Menunggu pembayaran.',
                        confirmButtonColor: '#F47A2A'
                    });
                },

                onError: function(result){
                    console.log(result);
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Pembayaran gagal.',
                        confirmButtonColor: '#F47A2A'
                    });
                },

                onClose: function(){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Dibatalkan',
                        text: 'Popup pembayaran ditutup.',
                        confirmButtonColor: '#F47A2A'
                    });
                }

            });

        }

    } catch(error) {
        console.error(error);
        
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan.',
            confirmButtonColor: '#F47A2A'
        });
    }

});
</script>