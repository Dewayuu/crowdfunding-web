@extends('layouts.sidebar.admin')

@section('title', 'Manage User')

@section('content')
<div class="p-6 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manage User</h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola data user, role, status akun, dan kelengkapan data rekening.
            </p>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total User</p>
            <h2 class="text-2xl font-bold text-gray-800 mt-2">
                {{ $summary['total_users'] }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <p class="text-sm text-gray-500">User Aktif</p>
            <h2 class="text-2xl font-bold text-emerald-600 mt-2">
                {{ $summary['active_users'] }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Data Rekening Lengkap</p>
            <h2 class="text-2xl font-bold text-blue-600 mt-2">
                {{ $summary['complete_bank_accounts'] }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Belum Lengkap</p>
            <h2 class="text-2xl font-bold text-orange-500 mt-2">
                {{ $summary['incomplete_bank_accounts'] }}
            </h2>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.users') }}">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Cari User</label>
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Cari nama atau email..."
                           class="w-full rounded-xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Role</label>
                    <select name="role"
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Status Akun</label>
                    <select name="status"
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Data Rekening</label>
                    <select name="bank_status"
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Semua Data</option>
                        <option value="complete" {{ request('bank_status') === 'complete' ? 'selected' : '' }}>Lengkap</option>
                        <option value="incomplete" {{ request('bank_status') === 'incomplete' ? 'selected' : '' }}>Belum Lengkap</option>
                        <option value="not_applicable" {{ request('bank_status') === 'not_applicable' ? 'selected' : '' }}>Tidak Berlaku</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-5">
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
                    Terapkan Filter
                </button>

                <a href="{{ route('admin.users') }}"
                   class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-600 text-sm font-semibold hover:bg-gray-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Daftar User</h2>
                <p class="text-sm text-gray-500">
                    Data user diambil dari database sistem HatiNurani.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-4">User</th>
                        <th class="px-5 py-4">Role</th>
                        <th class="px-5 py-4">Status Akun</th>
                        <th class="px-5 py-4">Bergabung</th>
                        <th class="px-5 py-4">Campaign</th>
                        <th class="px-5 py-4">Total Donasi</th>
                        <th class="px-5 py-4">Data Rekening</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        @php
                            if ($user->role === 'admin') {
                                $bankStatus = 'Tidak Berlaku';
                            } elseif ($user->bankAccount) {
                                $bankStatus = 'Lengkap';
                            } else {
                                $bankStatus = 'Belum Lengkap';
                            }
                        @endphp

                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">
                                        {{ strtoupper(substr($user->username, 0, 1)) }}
                                    </div>

                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $user->username }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                @if ($user->role === 'admin')
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                        Admin
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        User
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                @if ($user->account_status === 'active')
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-gray-600">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </td>

                            <td class="px-5 py-4 text-gray-600">
                                {{ $user->campaign_count ?? 0 }}
                            </td>

                            <td class="px-5 py-4 text-gray-600">
                                Rp {{ number_format($user->total_donation ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="px-5 py-4">
                                @if ($bankStatus === 'Lengkap')
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        Lengkap
                                    </span>
                                @elseif ($bankStatus === 'Belum Lengkap')
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                        Belum Lengkap
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Tidak Berlaku
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('admin.users.show', $user->user_id) }}"
                                    class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center"
                                    title="Lihat Detail User">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-gray-500">
                                Belum ada data user yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection