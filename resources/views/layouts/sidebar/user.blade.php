<!DOCTYPE html>
<html lang="id">
<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Portal') - Crowdfunding</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F8F9FA] min-h-screen flex flex-col md:flex-row">
    @livewireScripts

    <div class="w-full md:w-72 bg-[#2D1622] text-white flex flex-col min-h-screen px-6 py-8 shadow-xl shrink-0">
        <div class="text-xl font-bold mb-8 tracking-wide text-gray-200 px-2">
            Logo
        </div>

        <div class="mb-8 px-2">
            <h3 class="text-xl font-bold tracking-wide text-gray-100 mb-4">Halo!</h3>
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 rounded-full overflow-hidden bg-gray-600/50 flex items-center justify-center border border-gray-500/30 shadow-sm">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-regular fa-user text-gray-300 text-xl"></i>
                    @endif
                </div>
                <div class="overflow-hidden">
                    <h4 class="text-sm font-semibold tracking-wide text-gray-100">
                        {{ Auth::user()->detailIndividual()->first()?->full_name ?? Auth::user()->username }}
                    </h4>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex flex-col space-y-6">
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest px-3 mb-2">Overview</p>
                <a href="{{ route('user.dashboard') }}" wire:navigate
                   class="flex items-center space-x-3 py-2.5 px-4 rounded-lg transition duration-200 font-medium {{ Request::routeIs('user.dashboard') ? 'bg-[#FFF9F3] text-[#2D1622]' : 'text-gray-300 hover:bg-[#422132] hover:text-white' }}">
                    <i class="fa-solid fa-house text-sm w-5"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="flex-1 space-y-1">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest px-3 mb-2">Menu</p>

                <a href="#" wire:navigate
                   class="flex items-center space-x-3 py-2.5 px-4 rounded-lg transition duration-200 font-medium {{ Request::routeIs('user.campaigns') ? 'bg-[#FFF9F3] text-[#2D1622]' : 'text-gray-300 hover:bg-[#422132] hover:text-white' }}">
                    <i class="fa-regular fa-file-lines text-sm w-5"></i>
                    <span>Campaign Saya</span>
                </a>

                <a href="#" wire:navigate
                   class="flex items-center space-x-3 py-2.5 px-4 rounded-lg transition duration-200 font-medium {{ Request::routeIs('user.donations') ? 'bg-[#FFF9F3] text-[#2D1622]' : 'text-gray-300 hover:bg-[#422132] hover:text-white' }}">
                    <i class="fa-regular fa-clock text-sm w-5"></i>
                    <span>Riwayat Donasi</span>
                </a>

                <a href="{{ route('user.profile.edit') }}"
                   class="flex items-center space-x-3 py-2.5 px-4 rounded-lg transition duration-200 font-medium {{ Request::routeIs('user.profile.edit') ? 'bg-[#FFF9F3] text-[#2D1622]' : 'text-gray-300 hover:bg-[#422132] hover:text-white' }}">
                    <i class="fa-regular fa-user text-sm w-5"></i>
                    <span>Edit Profile</span>
                </a>
            </div>

            <div class="border-t border-gray-700/60 pt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 py-2.5 px-4 rounded-lg text-gray-300 hover:bg-red-950 hover:text-red-400 transition duration-200 font-medium text-left">
                        <i class="fa-solid fa-right-from-bracket text-sm w-5"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="flex-1 p-8 md:p-12 overflow-y-auto"
         x-data="{ show: false }"
         x-init="show = true"
         x-show="show"
         x-cloak
         x-transition:enter="transition opacity duration-150 ease-out"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">

        @yield('content')

    </div>

</body>
</html>