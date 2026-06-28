<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Campaign - Crowdfunding</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-white min-h-screen">

    {{-- ======================== NAVBAR ======================== --}}
    @include('layouts.navbar')

    {{-- ======================== HERO ======================== --}}
    <div class="bg-[#2D1622] text-white py-16 px-6">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl font-bold mb-3">Jelajahi Campaign</h1>
            <p class="text-gray-300 mb-8">Temukan berbagai campaign yang membutuhkan dukunganmu</p>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('campaigns.index') }}" class="mb-8">
                <div class="relative max-w-xl mx-auto">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Search"
                           class="w-full pl-11 pr-4 py-3 rounded-full text-gray-800 text-sm outline-none focus:ring-2 focus:ring-[#6B7A4A]">
                    @if($selectedCategory !== 'semua')
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    @endif
                    @if($sort !== 'latest')
                        <input type="hidden" name="sort" value="{{ $sort }}">
                    @endif
                </div>
            </form>

            {{-- Filter Kategori --}}
            <div class="flex flex-wrap justify-center gap-2">
                <a href="{{ route('campaigns.index', array_merge(request()->except('category', 'page'), ['category' => 'semua'])) }}"
                   class="px-4 py-1.5 rounded-full text-sm font-medium transition border {{ $selectedCategory === 'semua' ? 'bg-white text-[#2D1622] border-white' : 'border-gray-500 text-gray-300 hover:border-white hover:text-white' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('campaigns.index', array_merge(request()->except('category', 'page'), ['category' => $cat->slug])) }}"
                       class="px-4 py-1.5 rounded-full text-sm font-medium transition border {{ $selectedCategory === $cat->slug ? 'bg-white text-[#2D1622] border-white' : 'border-gray-500 text-gray-300 hover:border-white hover:text-white' }}">
                        {{ $cat->category_name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ======================== KONTEN ======================== --}}
    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- Header hasil + filter sort --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-800">
                    {{ $selectedCategory === 'semua' ? 'Semua Kategori' : '"' . ucfirst($selectedCategory) . '"' }}
                </h2>
                <p class="text-sm text-gray-500">
                    Menampilkan {{ $campaigns->count() }} dari {{ $campaigns->total() }} campaign
                </p>
            </div>

            {{-- Filter Dropdown --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="flex items-center gap-2 text-sm font-medium text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition">
                    <i class="fa-solid fa-filter text-xs"></i>
                    Filter
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>
                <div x-show="open" x-cloak @click.outside="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-xl shadow-lg z-10 overflow-hidden">
                    <a href="{{ route('campaigns.index', array_merge(request()->except('sort', 'page'), ['sort' => 'latest'])) }}"
                       class="block px-4 py-3 text-sm hover:bg-gray-50 {{ $sort === 'latest' ? 'font-semibold text-[#2D1622]' : 'text-gray-700' }}">
                        Terbaru
                    </a>
                    <a href="{{ route('campaigns.index', array_merge(request()->except('sort', 'page'), ['sort' => 'most_donated'])) }}"
                       class="block px-4 py-3 text-sm hover:bg-gray-50 {{ $sort === 'most_donated' ? 'font-semibold text-[#2D1622]' : 'text-gray-700' }}">
                        Paling banyak didonasi
                    </a>
                    <a href="{{ route('campaigns.index', array_merge(request()->except('sort', 'page'), ['sort' => 'deadline'])) }}"
                       class="block px-4 py-3 text-sm hover:bg-gray-50 {{ $sort === 'deadline' ? 'font-semibold text-[#2D1622]' : 'text-gray-700' }}">
                        Hampir deadline
                    </a>
                </div>
            </div>
        </div>

        {{-- Grid Campaign --}}
        @if($campaigns->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($campaigns as $campaign)
                    @php
                        $progress = $campaign->target_amount > 0
                            ? min(100, ($campaign->current_amount / $campaign->target_amount) * 100)
                            : 0;
                        $daysLeft = (int) now()->diffInDays($campaign->end_date, false);
                        $primaryImage = $campaign->images->where('is_primary', 'yes')->first()
                            ?? $campaign->images->first();
                        $donorCount = $campaign->donations->where('payment_status', 'success')->count();
                    @endphp
                    <a href="#" class="bg-[#2D1622] rounded-2xl overflow-hidden shadow hover:shadow-lg transition group block flex flex-col">

                        {{-- Foto --}}
                        <div class="relative h-44 overflow-hidden">
                            @if($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage->image) }}"
                                     alt="{{ $campaign->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                    <i class="fa-regular fa-image text-gray-500 text-3xl"></i>
                                </div>
                            @endif

                            {{-- Badge verifikasi --}}
                            <div class="absolute top-2 left-2">
                                @if($campaign->verification_status === 'approved')
                                    <span class="bg-green-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check text-[8px]"></i> Terverifikasi
                                    </span>
                                @else
                                    <span class="bg-orange-400 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1">
                                        <i class="fa-solid fa-circle-exclamation text-[8px]"></i> Belum Terverifikasi
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="p-4 flex flex-col flex-1 justify-between">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ $campaign->category->category_name ?? '-' }}</p>
                                <h3 class="text-sm font-bold text-white leading-snug mb-1 line-clamp-2">{{ $campaign->title }}</h3>
                                <p class="text-xs text-gray-400 mb-3">oleh {{ $campaign->user->username ?? '-' }}</p>
                            </div>

                            <div>
                                {{-- Progress --}}
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-xs text-gray-300">{{ number_format($progress, 0) }}% dari Rp {{ number_format($campaign->target_amount / 1000000, 0) }}jt</p>
                                    <p class="text-xs text-gray-400 flex items-center gap-1">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $daysLeft > 0 ? $daysLeft . ' Hari' : 'Berakhir' }}
                                    </p>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-1.5 mb-3">
                                    <div class="bg-orange-400 h-1.5 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="flex items-center justify-between text-[10px] text-gray-400">
                                    <span>Rp {{ number_format($campaign->current_amount / 1000000, 0) }}jt Terkumpul</span>
                                    <span>{{ $donorCount }} donatur</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($campaigns->hasPages())
                <div class="mt-10 flex justify-center items-center gap-1">
                    {{-- Sebelumnya --}}
                    @if($campaigns->onFirstPage())
                        <span class="px-3 py-1.5 border border-gray-200 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed text-sm">‹</span>
                    @else
                        <a href="{{ $campaigns->previousPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition text-sm">‹</a>
                    @endif

                    {{-- Nomor halaman --}}
                    @foreach($campaigns->getUrlRange(max(1, $campaigns->currentPage() - 2), min($campaigns->lastPage(), $campaigns->currentPage() + 2)) as $page => $url)
                        @if($page == $campaigns->currentPage())
                            <span class="px-3 py-1.5 bg-[#2D1622] text-white font-bold rounded-lg text-sm">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition text-sm">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Selanjutnya --}}
                    @if($campaigns->hasMorePages())
                        <a href="{{ $campaigns->nextPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition text-sm">›</a>
                    @else
                        <span class="px-3 py-1.5 border border-gray-200 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed text-sm">›</span>
                    @endif
                </div>
            @endif

        @else
            <div class="text-center py-20">
                <i class="fa-regular fa-folder-open text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 font-medium">Belum ada campaign yang tersedia</p>
                <p class="text-gray-400 text-sm mt-1">Coba ubah kata kunci atau kategori pencarian</p>
            </div>
        @endif
    </div>

    {{-- FOOTER --}}
    @include('layouts.footer')

</body>
</html>