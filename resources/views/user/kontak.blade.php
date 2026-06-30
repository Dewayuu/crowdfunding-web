<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kontak</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F5F5F5]">

<!-- Navbar -->
<nav class="bg-[#3A1D2E] text-white px-10 py-5 flex justify-between items-center">

    <h1 class="text-2xl font-bold">
        Crowdfunding
    </h1>

    <div class="flex gap-8">
        <a href="{{ route('beranda') }}">Beranda</a>
        <a href="{{ route('donasi') }}">Donasi</a>
        <a href="{{ route('tentang') }}">Tentang</a>
        <a href="{{ route('kontak') }}" class="font-bold border-b-2 border-white">
            Kontak
        </a>
    </div>

</nav>

<!-- Content -->
<div class="max-w-5xl mx-auto py-14">

    <h1 class="text-4xl font-bold text-[#3A1D2E] mb-3">
        Hubungi Kami
    </h1>

    <p class="text-gray-600 mb-10">
        Jika memiliki pertanyaan, kendala, atau membutuhkan bantuan mengenai campaign maupun donasi,
        silakan hubungi kami melalui informasi berikut.
    </p>

    <div class="bg-white rounded-2xl shadow p-10">

        <div class="space-y-8">

            <div>
                <h2 class="font-bold text-lg text-[#3A1D2E]">
                    📍 Alamat
                </h2>

                <p class="text-gray-600 mt-2">
                    Jl. Raya Kampus Udayana, Jimbaran,<br>
                    Badung, Bali, Indonesia
                </p>
            </div>

            <div>
                <h2 class="font-bold text-lg text-[#3A1D2E]">
                    📞 Telepon
                </h2>

                <p class="text-gray-600 mt-2">
                    +62 812-3456-7890
                </p>
            </div>

            <div>
                <h2 class="font-bold text-lg text-[#3A1D2E]">
                    ✉ Email
                </h2>

                <p class="text-gray-600 mt-2">
                    support@crowdfunding.com
                </p>
            </div>

            <div>
                <h2 class="font-bold text-lg text-[#3A1D2E]">
                    🕒 Jam Operasional
                </h2>

                <p class="text-gray-600 mt-2">
                    Senin - Jumat<br>
                    08.00 - 17.00 WITA
                </p>
            </div>

            <div>
                <h2 class="font-bold text-lg text-[#3A1D2E]">
                    🌐 Media Sosial
                </h2>

                <ul class="mt-2 space-y-2 text-gray-600">
                    <li>Instagram : @crowdfunding.id</li>
                    <li>Facebook : Crowdfunding Indonesia</li>
                    <li>X (Twitter) : @crowdfundingID</li>
                    <li>LinkedIn : Crowdfunding Indonesia</li>
                </ul>
            </div>

        </div>

    </div>

</div>

</body>
</html>