<!DOCTYPE html>
<html lang="id">
<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Crowdfunding</title>
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
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-3">Admin Panel</p>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-white text-[#2D1622] flex items-center justify-center font-bold text-sm shadow-md">
                    AD
                </div>
                <div>
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
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                   class="flex items-center space-x-3 py-2.5 px-4 rounded-lg transition duration-200 font-medium {{ Request::routeIs('admin.dashboard') ? 'bg-[#FFF9F3] text-[#2D1622]' : 'text-gray-300 hover:bg-[#422132] hover:text-white' }}">
                    <i class="fa-solid fa-house text-sm w-5"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="flex-1 space-y-1">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest px-3 mb-2">Menu</p>
                
                <a href="{{ route('admin.campaigns') }}" wire:navigate
                class="flex items-center space-x-3 py-2.5 px-4 rounded-lg transition duration-200 font-medium {{ Request::routeIs('admin.campaigns') ? 'bg-[#FFF9F3] text-[#2D1622]' : 'text-gray-300 hover:bg-[#422132] hover:text-white' }}">
                    <i class="fa-solid fa-bullhorn text-sm w-5"></i>
                    <span>Kelola Campaign</span>
                </a>
                
                <a href="#" wire:navigate class="flex items-center space-x-3 py-2.5 px-4 rounded-lg text-gray-300 hover:bg-[#422132] hover:text-white transition duration-200 font-medium">
                    <i class="fa-solid fa-users text-sm w-5"></i>
                    <span>Kelola User</span>
                </a>
                
                <a href="#" wire:navigate class="flex items-center space-x-3 py-2.5 px-4 rounded-lg text-gray-300 hover:bg-[#422132] hover:text-white transition duration-200 font-medium">
                    <i class="fa-solid fa-money-bill-transfer text-sm w-5"></i>
                    <span>Pengajuan Dana</span>
                </a>
                
                <a href="#" wire:navigate class="flex items-center space-x-3 py-2.5 px-4 rounded-lg text-gray-300 hover:bg-[#422132] hover:text-white transition duration-200 font-medium">
                    <i class="fa-solid fa-hand-holding-dollar text-sm w-5"></i>
                    <span>Data Donasi</span>
                </a>
            </div>

            <div class="border-t border-gray-700 pt-4">
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
        x-init="setTimeout(() => show = true, 50)"
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0">
        
        @yield('content')
        
    </div>

</body>
</html>