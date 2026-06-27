@extends('layouts.sidebar.admin')

@section('title', 'Manage User')

@section('content')
@php
    $users = [
        [
            'initial' => 'SR',
            'name' => 'Siti Rahma',
            'email' => 'siti12@gmail.com',
            'role' => 'User',
            'role_color' => 'bg-[#A3B565] text-white',
            'status' => 'Aktif',
            'status_color' => 'bg-[#F1642E] text-white',
            'joined' => 'Jan, 2024',
            'campaign' => 3,
            'total_donasi' => 'Rp300.000',
            'rekening' => 'Lengkap',
            'rekening_color' => 'bg-[#A5A5A5] text-white',
        ],
        [
            'initial' => 'AD',
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'role' => 'Admin',
            'role_color' => 'bg-[#C4C3E3] text-white',
            'status' => 'Tidak Aktif',
            'status_color' => 'bg-[#FCD99D] text-white',
            'joined' => 'Jan, 2024',
            'campaign' => 0,
            'total_donasi' => '-',
            'rekening' => 'Tidak Berlaku',
            'rekening_color' => 'bg-[#504E76] text-white',
        ],
        [
            'initial' => 'BR',
            'name' => 'Budi Rahma',
            'email' => 'budi@gmail.com',
            'role' => 'User',
            'role_color' => 'bg-[#A3B565] text-white',
            'status' => 'Tidak Aktif',
            'status_color' => 'bg-[#F1642E] text-white',
            'joined' => 'Jan, 2024',
            'campaign' => 3,
            'total_donasi' => 'Rp300.000',
            'rekening' => 'Belum Lengkap',
            'rekening_color' => 'bg-[#351528] text-white',
        ],
    ];

    for ($i = 0; $i < 7; $i++) {
        $users[] = [
            'initial' => 'SR',
            'name' => 'Siti Rahma',
            'email' => 'siti12@gmail.com',
            'role' => 'User',
            'role_color' => 'bg-[#A3B565] text-white',
            'status' => 'Tidak Aktif',
            'status_color' => 'bg-[#F1642E] text-white',
            'joined' => 'Jan, 2024',
            'campaign' => 3,
            'total_donasi' => 'Rp300.000',
            'rekening' => 'Lengkap',
            'rekening_color' => 'bg-[#A5A5A5] text-white',
        ];
    }
@endphp

<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-[#2D1622] tracking-wide mb-8">Manage User</h1>

    {{-- Search dan Filter --}}
    <form action="{{ route('admin.users') }}" method="GET" class="mb-4">
        <div class="flex flex-col lg:flex-row bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau email user..."
                    class="w-full pl-11 pr-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none"
                >
            </div>

            <div class="relative w-full lg:w-64 border-t lg:border-t-0 lg:border-l border-gray-200">
                <select
                    name="rekening"
                    onchange="this.form.submit()"
                    class="w-full appearance-none px-4 py-3 bg-white text-sm text-gray-400 focus:outline-none pr-10"
                >
                    <option value="">Semua Data Rekening</option>
                    <option value="lengkap" {{ request('rekening') == 'lengkap' ? 'selected' : '' }}>Lengkap</option>
                    <option value="belum_lengkap" {{ request('rekening') == 'belum_lengkap' ? 'selected' : '' }}>Belum Lengkap</option>
                    <option value="tidak_berlaku" {{ request('rekening') == 'tidak_berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                </select>
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-300 pointer-events-none">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </span>
            </div>

            <div class="relative w-full lg:w-52 border-t lg:border-t-0 lg:border-l border-gray-200">
                <select
                    name="role"
                    onchange="this.form.submit()"
                    class="w-full appearance-none px-4 py-3 bg-white text-sm text-gray-400 focus:outline-none pr-10"
                >
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-300 pointer-events-none">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </span>
            </div>

            <div class="relative w-full lg:w-52 border-t lg:border-t-0 lg:border-l border-gray-200">
                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="w-full appearance-none px-4 py-3 bg-white text-sm text-gray-400 focus:outline-none pr-10"
                >
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-300 pointer-events-none">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </span>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F6ECEF] border-b border-gray-200">
                        <th class="px-5 py-4 text-xs font-bold uppercase text-[#2D1622]">User</th>
                        <th class="px-5 py-4 text-xs font-bold uppercase text-[#2D1622]">Role</th>
                        <th class="px-5 py-4 text-xs font-bold uppercase text-[#2D1622]">Status Akun</th>
                        <th class="px-5 py-4 text-xs font-bold uppercase text-[#2D1622]">Bergabung</th>
                        <th class="px-5 py-4 text-xs font-bold uppercase text-[#2D1622] text-center">Campaign</th>
                        <th class="px-5 py-4 text-xs font-bold uppercase text-[#2D1622] text-center">Total Donasi</th>
                        <th class="px-5 py-4 text-xs font-bold uppercase text-[#2D1622] text-center">Data Rekening</th>
                        <th class="px-5 py-4 text-xs font-bold uppercase text-[#2D1622] text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#D8EFFD] flex items-center justify-center text-[#2D1622] text-sm font-semibold shrink-0">
                                        {{ $user['initial'] }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-[#2D1622] leading-tight">
                                            {{ $user['name'] }}
                                        </p>
                                        <p class="text-xs text-gray-400 leading-tight max-w-[110px] break-all">
                                            {{ $user['email'] }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-3">
                                <span class="inline-flex justify-center min-w-20 px-3 py-1 rounded-full text-xs font-medium {{ $user['role_color'] }}">
                                    {{ $user['role'] }}
                                </span>
                            </td>

                            <td class="px-5 py-3">
                                <span class="inline-flex justify-center min-w-24 px-3 py-1 rounded-full text-xs font-medium {{ $user['status_color'] }}">
                                    {{ $user['status'] }}
                                </span>
                            </td>

                            <td class="px-5 py-3 text-sm text-[#2D1622]">
                                {{ $user['joined'] }}
                            </td>

                            <td class="px-5 py-3 text-sm text-[#2D1622] text-center">
                                {{ $user['campaign'] }}
                            </td>

                            <td class="px-5 py-3 text-sm text-[#2D1622] text-center">
                                {{ $user['total_donasi'] }}
                            </td>

                            <td class="px-5 py-3 text-center">
                                <span class="inline-flex justify-center min-w-32 px-3 py-1 rounded-full text-xs font-medium {{ $user['rekening_color'] }}">
                                    {{ $user['rekening'] }}
                                </span>
                            </td>

                            <td class="px-5 py-3">
                                <div class="flex items-center justify-center gap-2 text-gray-300">
                                    <button type="button" class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center hover:text-[#2D1622] hover:border-gray-300 transition">
                                        <i class="fa-regular fa-eye text-xs"></i>
                                    </button>
                                    <button type="button" class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center hover:text-[#2D1622] hover:border-gray-300 transition">
                                        <i class="fa-regular fa-pen-to-square text-xs"></i>
                                    </button>
                                    <button type="button" class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center hover:text-[#2D1622] hover:border-gray-300 transition">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination Statis --}}
        <div class="px-6 py-8 border-t border-gray-100 flex flex-col lg:flex-row lg:items-center lg:justify-center gap-5">
            <div class="flex items-center justify-center gap-2">
                <button class="px-4 py-2 rounded-md bg-gray-50 text-gray-300 text-sm cursor-not-allowed">
                    ‹ Back
                </button>

                <button class="w-9 h-9 rounded-md bg-black text-white text-sm font-semibold">
                    1
                </button>
                <button class="w-9 h-9 rounded-md bg-[#FBF4E4] text-[#2D1622] text-sm">
                    2
                </button>
                <button class="w-9 h-9 rounded-md bg-[#FBF4E4] text-[#2D1622] text-sm">
                    3
                </button>
                <button class="w-9 h-9 rounded-md bg-[#FBF4E4] text-[#2D1622] text-sm">
                    4
                </button>
                <button class="w-9 h-9 rounded-md bg-[#FBF4E4] text-[#2D1622] text-sm">
                    5
                </button>
                <button class="w-9 h-9 rounded-md bg-[#FBF4E4] text-[#2D1622] text-sm">
                    6
                </button>
                <button class="w-9 h-9 rounded-md bg-[#FBF4E4] text-[#2D1622] text-sm">
                    7
                </button>
                <button class="w-9 h-9 rounded-md bg-[#FBF4E4] text-[#2D1622] text-sm">
                    8
                </button>
                <button class="w-9 h-9 rounded-md bg-[#FBF4E4] text-[#2D1622] text-sm">
                    ...
                </button>
                <button class="w-12 h-9 rounded-md bg-[#FBF4E4] text-[#2D1622] text-sm">
                    25
                </button>

                <button class="px-4 py-2 rounded-md bg-[#FBF4E4] text-[#2D1622] text-sm">
                    Next ›
                </button>
            </div>

            <div class="flex items-center justify-center gap-3 text-sm text-[#2D1622]">
                <span>Result per page</span>
                <select class="border border-gray-200 rounded-md px-3 py-2 bg-white focus:outline-none">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
            </div>
        </div>

        <div class="px-6 pb-8 text-sm text-[#2D1622]">
            1-10 of 1,250
        </div>
    </div>
</div>
@endsection