<header class="bg-[#351528] text-white sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-10 lg:px-16 py-6 flex items-center justify-between border-b border-white/25">
        <a href="{{ url('/') }}" style="font-family: Georgia, serif;" class="text-2xl font-bold">
            Hati<span class="text-[#F1642E]">Nurani</span>
        </a>

        <div class="hidden md:flex items-center gap-10 text-sm font-semibold">
            <a href="{{ url('/') }}" 
               class="hover:text-[#F1642E] transition {{ Request::is('/') ? 'text-[#F1642E] border-b-2 border-[#F1642E] pb-0.5' : '' }}">
                Beranda
            </a>
            <a href="{{ route('campaigns.index') }}" 
               class="hover:text-[#F1642E] transition {{ Request::routeIs('campaigns.index') ? 'text-[#F1642E] border-b-2 border-[#F1642E] pb-0.5' : '' }}">
                Donasi
            </a>
            <a href="#tentang" class="hover:text-[#F1642E] transition">Tentang</a>

            @guest
                <a href="{{ route('login') }}" class="hover:text-[#F1642E] transition">Masuk</a>
                <a href="{{ route('register') }}" class="bg-[#F1642E] px-8 py-3 rounded-lg text-white hover:opacity-90 transition">
                    Daftar
                </a>
            @else
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                    <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-600 flex items-center justify-center">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-regular fa-user text-gray-300 text-sm"></i>
                        @endif
                    </div>
                    <span>{{ Auth::user()->username }}</span>
                </a>
            @endguest
        </div>
    </nav>
</header>