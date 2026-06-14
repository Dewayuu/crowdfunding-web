@extends('layouts.sidebar.admin')

@section('title', 'Manage Campaign')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-[#2D1622] tracking-wide mb-8">Kelola Campaign /masih statis</h1>

    <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-3 md:space-y-0 mb-6">
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" 
                   placeholder="Cari nama campaign, pembuat, atau kategori..." 
                   class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2D1622] focus:border-transparent transition shadow-sm">
        </div>

        <div class="relative w-full md:w-48">
            <select class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-sm pr-10">
                <option>Semua Status</option>
                <option>Menunggu</option>
                <option>Terverifikasi</option>
                <option>Ditolak</option>
                <option>Selesai</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none">
                <i class="fa-solid fa-chevron-down text-xs"></i>
            </span>
        </div>

        <div class="relative w-full md:w-48">
            <select class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#2D1622] shadow-sm pr-10">
                <option>Semua Kategori</option>
                <option>Pendidikan</option>
                <option>Sosial</option>
                <option>Kesehatan</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none">
                <i class="fa-solid fa-chevron-down text-xs"></i>
            </span>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F6ECEF] border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#2D1622] w-2/5">Campaign</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#2D1622]">Owner</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#2D1622]">Target</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#2D1622]">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#2D1622]">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#2D1622] text-center">Aksi</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-gray-100 bg-white">
                    
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800 text-sm">Campaign 1</div>
                            <div class="text-xs text-gray-400 mt-0.5">Pendidikan</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">User 1</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">Rp10.000.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-4 py-1 text-xs font-medium bg-[#FBF4E4] text-[#D4A343] rounded-full">
                                Menunggu
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">8 Mei 2026</td>
                        <td class="px-6 py-4 text-center">
                            <a href="#" class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-50 border border-gray-200 text-gray-400 hover:text-[#2D1622] hover:border-gray-300 transition shadow-sm">
                                <i class="fa-regular fa-eye text-sm"></i>
                            </a>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800 text-sm">Campaign 2</div>
                            <div class="text-xs text-gray-400 mt-0.5">Sosial</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">User 2</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">Rp40.000.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-4 py-1 text-xs font-medium bg-[#E6ECE9] text-[#55A08E] rounded-full">
                                Terverifikasi
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">8 Mei 2026</td>
                        <td class="px-6 py-4 text-center">
                            <a href="#" class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-50 border border-gray-200 text-gray-400 hover:text-[#2D1622] hover:border-gray-300 transition shadow-sm">
                                <i class="fa-regular fa-eye text-sm"></i>
                            </a>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800 text-sm">Campaign 3</div>
                            <div class="text-xs text-gray-400 mt-0.5">Kesehatan</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">User 3</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">Rp60.000.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-4 py-1 text-xs font-medium bg-[#FDE8E7] text-[#FA6B6B] rounded-full">
                                Ditolak
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">8 Mei 2026</td>
                        <td class="px-6 py-4 text-center">
                            <a href="#" class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-50 border border-gray-200 text-gray-400 hover:text-[#2D1622] hover:border-gray-300 transition shadow-sm">
                                <i class="fa-regular fa-eye text-sm"></i>
                            </a>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800 text-sm">Campaign 4</div>
                            <div class="text-xs text-gray-400 mt-0.5">Pendidikan</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">User 4</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">Rp10.000.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-4 py-1 text-xs font-medium bg-[#EAEAEA] text-[#959595] rounded-full">
                                Selesai
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">8 Mei 2026</td>
                        <td class="px-6 py-4 text-center">
                            <a href="#" class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-50 border border-gray-200 text-gray-400 hover:text-[#2D1622] hover:border-gray-300 transition shadow-sm">
                                <i class="fa-regular fa-eye text-sm"></i>
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection