<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Inter',sans-serif;
        }
    </style>
</head>

<body class="bg-[#EAEAEA]">

@php
$user = Auth::user();
$userName = $user->username;
$userInitial = strtoupper(substr($userName, 0, 1));
@endphp

<div class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-[190px] bg-[#3A1D2E] text-white flex flex-col">

        <!-- LOGO -->
        <div class="px-6 py-8 font-bold text-xl">
            HatiNurani
        </div>

        <!-- PROFILE -->
<div class="px-6 mt-6 mb-8">
    <div class="flex items-center justify-center gap-3">

        <div class="w-14 h-14 rounded-full bg-white text-[#3A1D2E] flex items-center justify-center text-xl font-bold shrink-0">
            {{ $userInitial }}
        </div>

        <div class="flex flex-col justify-center">
            <span class="font-semibold text-base leading-none">
                {{ $userName }}
            </span>

            <span class="text-sm text-gray-300 mt-1">
                User
            </span>
        </div>

    </div>
</div>

        <!-- MENU -->
        <div class="px-6 mt-12">

            <p class="text-xs text-gray-400 mb-4 uppercase">
                Menu
            </p>

            <div class="space-y-2">

                <a href="{{ route('user.dashboard') }}"
                   class="flex items-center px-4 py-2 rounded bg-[#F3F0E8] text-[#3A1D2E] font-medium">
                    Dashboard
                </a>

                <a href="#"
                   class="block px-4 py-2 rounded hover:bg-[#4B2639]">
                    My Campaign
                </a>

                <a href="#"
                   class="block px-4 py-2 rounded hover:bg-[#4B2639]">
                    Donation History
                </a>

                <a href="#"
                   class="block px-4 py-2 rounded hover:bg-[#4B2639]">
                    Edit Profile
                </a>

            </div>

        </div>

        <!-- LOGOUT -->
        <div class="mt-auto px-6 py-8">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="w-full text-left px-4 py-2 rounded hover:bg-[#4B2639]">
                    Log Out
                </button>
            </form>

        </div>

    </aside>

    <!-- MAIN -->
    <div class="flex-1">

        <!-- TOPBAR -->
        <header class="h-20 bg-[#3A1D2E] flex items-center justify-end px-10">

    <div class="flex items-center gap-8 text-white text-sm">

        <a href="{{ route('beranda') }}">Beranda</a>

        <a href="{{ route('donasi') }}">Donasi</a>

        <a href="{{ route('tentang') }}">Tentang</a>

        <a href="{{ route('kontak') }}">Kontak</a>

        <div class="flex gap-3">

</div>

    </div>

</header>

        <!-- CONTENT -->
        <main class="p-8">

            <!-- WELCOME -->
            <div class="mb-8">

    <h1 class="text-[42px] font-bold text-[#3A1D2E]">
        Welcome, {{ $userName }}!
    </h1>

    <p class="text-gray-600 mt-2">
        Kelola campaign dan pantau perkembangan donasi.
    </p>

</div>

            <!-- STATISTICS -->
            <div class="grid grid-cols-4 gap-6 mb-8">

                <!-- CARD 1 -->
                <div class="bg-white rounded-2xl px-5 py-4 border border-gray-200">

                    <p class="text-gray-500 text-sm mb-4">
                        TOTAL CAMPAIGN
                    </p>

                    <h2 class="text-[48px] font-bold leading-none">
                        3
                    </h2>

                    <p class="text-sm text-gray-500 mt-3">
                        campaign dibuat
                    </p>

                </div>

                <!-- CARD 2 -->
                <div class="bg-white rounded-2xl px-5 py-4 border border-gray-200">

                    <p class="text-gray-500 text-sm mb-4">
                        TOTAL DONASI
                    </p>

                    <h2 class="text-[36px] font-bold text-[#F47B3A]">
                        Rp 2,4 jt
                    </h2>

                    <p class="text-sm text-gray-500 mt-3">
                        dari 8 donasi
                    </p>

                </div>

                <!-- CARD 3 -->
                <div class="bg-white rounded-2xl px-5 py-4 border border-gray-200">

                    <p class="text-gray-500 text-sm mb-4">
                        DANA TERKUMPUL
                    </p>

                    <h2 class="text-[36px] font-bold text-gray-700">
                        Rp 18 jt
                    </h2>

                    <p class="text-sm text-gray-500 mt-3">
                        dari campaign kamu
                    </p>

                </div>

                <!-- CARD 4 -->
                <div class="bg-white rounded-2xl px-5 py-4 border border-gray-200">

                    <p class="text-gray-500 text-sm mb-4">
                        TERVERIFIKASI
                    </p>

                    <h2 class="text-[48px] font-bold leading-none">
                        3
                    </h2>

                    <p class="text-sm text-gray-500 mt-3">
                        campaign disetujui
                    </p>

                </div>

            </div>

            <!-- ACTIVITY -->
            <div class="bg-white rounded-3xl p-6 border border-gray-200">

                <h2 class="text-[24px] font-bold mb-6">
                    Riwayat Aktivitas
                </h2>

                <div class="space-y-4">

                    <div class="bg-[#F6F4F3] rounded-2xl p-5 flex items-center gap-4">

                        <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center">
                            ✓
                        </div>

                        <div>
                            <div class="font-medium">
                                Campaign "Beasiswa Papua" berhasil diverifikasi
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                2 jam lalu
                            </div>
                        </div>

                    </div>

                    <div class="bg-[#F6F4F3] rounded-2xl p-5 flex items-center gap-4">

                        <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center">
                            Rp
                        </div>

                        <div>
                            <div class="font-medium">
                                Donasi diterima di "Beasiswa Papua"
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                Rp 500.000 | 2 jam lalu
                            </div>
                        </div>

                    </div>

                    <div class="bg-[#F6F4F3] rounded-2xl p-5 flex items-center gap-4">

                        <div class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center">
                            ❤
                        </div>

                        <div>
                            <div class="font-medium">
                                Kamu berdonasi ke "Operasi Katarak Gratis"
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                Rp 150.000 | 3 hari lalu
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

</body>
</html>