@extends('layouts.sidebar.admin')

@section('title', 'Detail User')

@section('content')
<div class="p-6 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail User</h1>
            <p class="text-sm text-gray-500 mt-1">
                Informasi lengkap akun user dan data rekening untuk kebutuhan administrasi/refund.
            </p>
        </div>

        <a href="{{ route('admin.users') }}"
           class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200">
            ← Kembali
        </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-2xl font-bold">
                    {{ strtoupper(substr($user->username, 0, 1)) }}
                </div>

                <h2 class="text-xl font-bold text-gray-800 mt-4">
                    {{ $user->username }}
                </h2>

                <p class="text-sm text-gray-500">
                    {{ $user->email }}
                </p>

                <div class="flex items-center gap-2 mt-4">
                    @if ($user->role === 'admin')
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                            Admin
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                            User
                        </span>
                    @endif

                    @if ($user->account_status === 'active')
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                            Aktif
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                            Tidak Aktif
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 space-y-3 text-sm">
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Bergabung</span>
                    <span class="font-semibold text-gray-800">
                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                    </span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Entity Type</span>
                    <span class="font-semibold text-gray-800 capitalize">
                        {{ $user->entity_type }}
                    </span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Nomor HP</span>
                    <span class="font-semibold text-gray-800">
                        {{ $user->contact_number ?? '-' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Detail Info --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Jumlah Campaign</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">
                        {{ $campaignCount }}
                    </h3>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Total Donasi</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">
                        Rp {{ number_format($totalDonation ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            {{-- Bank Account --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800">Data Rekening</h2>
                    <p class="text-sm text-gray-500">
                        Data rekening digunakan untuk kebutuhan refund atau pencairan dana.
                    </p>
                </div>

                <div class="p-6">
                    @if ($user->role === 'admin')
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm text-gray-600">
                            Data rekening tidak berlaku untuk akun admin.
                        </div>
                    @elseif ($user->bankAccount)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Nama Bank</p>
                                <p class="font-semibold text-gray-800 mt-1">
                                    {{ $user->bankAccount->bank_name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500">Nomor Rekening</p>
                                <p class="font-semibold text-gray-800 mt-1">
                                    {{ $user->bankAccount->account_number }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500">Nama Pemilik</p>
                                <p class="font-semibold text-gray-800 mt-1">
                                    {{ $user->bankAccount->account_name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 text-sm text-orange-700">
                            User belum memiliki data rekening.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Action --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-2">Aksi Akun</h2>
                <p class="text-sm text-gray-500 mb-4">
                    Admin dapat menonaktifkan akun user apabila terdapat indikasi penyalahgunaan sistem.
                </p>

                @if ($user->role !== 'admin')
                    {{-- Tombol buka modal --}}
                @if ($user->account_status === 'active')
                    <button type="button"
                            onclick="openStatusModal()"
                            class="px-5 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700">
                        Nonaktifkan User
                    </button>
                @else
                    <button type="button"
                            onclick="openStatusModal()"
                            class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
                        Aktifkan User
                    </button>
                @endif

                {{-- Modal Konfirmasi --}}
                <div id="statusModal"
                    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
                    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center
                                {{ $user->account_status === 'active' ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}">
                                @if ($user->account_status === 'active')
                                    <i class="fa-solid fa-ban"></i>
                                @else
                                    <i class="fa-solid fa-check"></i>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-800">
                                    {{ $user->account_status === 'active' ? 'Nonaktifkan Akun?' : 'Aktifkan Akun?' }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-2">
                                    @if ($user->account_status === 'active')
                                        User ini tidak akan dapat menggunakan akun sampai statusnya diaktifkan kembali.
                                    @else
                                        User ini akan dapat menggunakan akun kembali setelah diaktifkan.
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button"
                                    onclick="closeStatusModal()"
                                    class="px-4 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200">
                                Batal
                            </button>

                            <form action="{{ route('admin.users.toggle-status', $user->user_id) }}"
                                method="POST">
                                @csrf

                                <button type="submit"
                                        class="px-4 py-2.5 rounded-xl text-white text-sm font-semibold
                                        {{ $user->account_status === 'active' ? 'bg-red-600 hover:bg-red-700' : 'bg-emerald-600 hover:bg-emerald-700' }}">
                                    {{ $user->account_status === 'active' ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    function openStatusModal() {
                        const modal = document.getElementById('statusModal');
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    }

                    function closeStatusModal() {
                        const modal = document.getElementById('statusModal');
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                </script>
                @else
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm text-gray-600">
                        Akun admin tidak dapat dinonaktifkan dari halaman ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection