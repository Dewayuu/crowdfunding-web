<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#EAEAEA]">

<div class="min-h-screen flex">

    <!-- LEFT SIDE -->
    <div class="hidden md:flex w-1/2 bg-[#3A1D2E] items-center justify-center px-24">

        <div class="max-w-md">
            <h1 class="text-white text-5xl font-extrabold mb-6">
                Lupa password?
            </h1>

            <p class="text-white text-lg leading-relaxed">
                Jangan khawatir! <br>
                Kami akan mengirimkan link reset password
                ke email yang terdaftar.
            </p>
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="w-full md:w-1/2 flex items-center justify-center px-10 lg:px-20">

        <div class="w-full max-w-md">

            <!-- ICON -->
            <div class="mb-6">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="w-12 h-12">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.5 0h12a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5h-12A1.5 1.5 0 014.5 19.5v-7.5A1.5 1.5 0 016 10.5z"/>
                </svg>
            </div>

            <!-- TITLE -->
            <h2 class="text-5xl font-extrabold text-black mb-6">
                Reset Password
            </h2>

            <p class="text-gray-700 mb-10 leading-relaxed">
                Masukkan email kamu dan kami akan
                mengirimkan instruksi untuk mengatur ulang
                password.
            </p>

            @if(session('success'))
                <div class="mb-5 p-3 rounded bg-green-100 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('forgot.password.send') }}" method="POST">
                @csrf

                <label class="block text-sm uppercase tracking-wide text-gray-700 mb-3">
                    ALAMAT EMAIL
                </label>

                <input
                    type="email"
                    name="email"
                    required
                    placeholder="nama@email.com"
                    class="w-full h-12 px-4 rounded-md border border-gray-300 bg-white mb-10 focus:outline-none focus:ring-2 focus:ring-orange-500">

                <button
                    type="submit"
                    class="w-full h-14 bg-[#F47B3A] hover:bg-[#eb6d2b] text-white font-semibold rounded-lg shadow-md transition">

                    Kirim Link Reset

                </button>
            </form>

            <div class="text-center mt-6 text-sm">

                <span class="text-gray-500">
                    Ingat password kamu?
                </span>

                <a href="{{ route('login') }}"
                   class="text-[#F47B3A] font-medium ml-2 hover:underline">
                    Kembali masuk
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>