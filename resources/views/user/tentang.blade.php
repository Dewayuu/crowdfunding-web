<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tentang Kami</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<nav class="bg-[#3A1D2E] text-white px-10 py-5 flex justify-between">

    <h1 class="font-bold text-xl">
        Crowdfunding
    </h1>

    <div class="space-x-6">
        <a href="{{ route('beranda') }}">Beranda</a>
        <a href="{{ route('donasi') }}">Donasi</a>
        <a href="{{ route('tentang') }}" class="font-bold">Tentang</a>
        <a href="{{ route('kontak') }}">Kontak</a>
    </div>

</nav>

<section class="max-w-5xl mx-auto py-14">

    <h1 class="text-4xl font-bold text-[#3A1D2E] mb-6">
        Tentang Platform
    </h1>

    <p class="text-gray-700 leading-8">
        Platform Crowdfunding merupakan media penggalangan dana online
        yang mempertemukan masyarakat yang ingin berdonasi dengan individu,
        komunitas maupun yayasan yang membutuhkan bantuan.
    </p>

    <div class="grid grid-cols-3 gap-8 mt-12">

        <div class="bg-white rounded-xl p-6 shadow">

            <h2 class="font-bold text-xl mb-3">
                Visi
            </h2>

            <p>
                Menjadi platform crowdfunding terpercaya di Indonesia.
            </p>

        </div>

        <div class="bg-white rounded-xl p-6 shadow">

            <h2 class="font-bold text-xl mb-3">
                Misi
            </h2>

            <ul class="list-disc ml-5 space-y-2">
                <li>Mempermudah donasi.</li>
                <li>Transparansi dana.</li>
                <li>Mendukung aksi sosial.</li>
            </ul>

        </div>

        <div class="bg-white rounded-xl p-6 shadow">

            <h2 class="font-bold text-xl mb-3">
                Keamanan
            </h2>

            <p>
                Seluruh campaign melalui proses verifikasi sebelum dipublikasikan.
            </p>

        </div>

    </div>

</section>

</body>
</html>