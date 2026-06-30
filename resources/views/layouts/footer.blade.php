{{-- ======================== FOOTER ======================== --}}
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
                    <li><a href="#campaign" class="hover:text-[#F1642E] transition">Semua Campaign</a></li>
                    <li>
                        @auth
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#F1642E] transition">Buat Campaign</a>
                            @else
                                <a href="{{ route('user.campaigns.create') }}" class="hover:text-[#F1642E] transition">Buat Campaign</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="hover:text-[#F1642E] transition">Buat Campaign</a>
                        @endauth
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="font-display text-lg font-bold mb-4">AKUN</h3>
                <ul class="space-y-2 text-sm">
                    @guest
                        <li><a href="{{ route('login') }}" class="hover:text-[#F1642E] transition">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-[#F1642E] transition">Daftar</a></li>
                    @endguest
                    <li>
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#F1642E] transition">Dashboard</a>
                            @else
                                <a href="{{ route('user.dashboard') }}" class="hover:text-[#F1642E] transition">Dashboard</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="hover:text-[#F1642E] transition">Dashboard</a>
                        @endauth
                    </li>
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