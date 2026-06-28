<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Crowdfunding Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <div class="w-full min-h-screen flex">
        
        <div class="hidden md:flex md:w-1/2 bg-[#000000] items-center justify-center p-12 relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&q=80&w=1000" 
                 alt="Crowdfunding Illustration" 
                 class="absolute inset-0 w-full h-full object-cover opacity-90">
        </div>

        <div class="w-full md:w-1/2 flex flex-col justify-center px-8 sm:px-16 lg:px-24 xl:px-36 bg-white">
            
            <div class="max-w-md w-full mx-auto">
                <h2 class="text-3xl font-bold text-[#2D1622] mb-2">Masuk</h2>
                <p class="text-sm text-gray-600 mb-8">
                    Belum memiliki akun? 
                    <a href="#" class="text-[#F15A24] font-medium hover:underline">Daftar sekarang</a>
                </p>

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 text-red-600 rounded-lg text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               placeholder="user@email.com" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition outline-none text-gray-700 placeholder-gray-400">
                    </div>

                    <div class="relative">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2D1622] focus:border-[#2D1622] transition outline-none text-gray-700 pr-10">
                            
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" id="eye-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 17.772 17.772m0 0a10.47 10.47 0 0 1-5.772 1.728c-4.756 0-8.773-3.162-10.065-7.498a10.523 10.523 0 0 1 4.293-5.774M17.772 17.772l4.228 4.228M5.636 5.636l-1.414-1.414M9 10.5a3 3 0 1 1 3 3 3 3 0 0 1-3-3Z" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="text-right mt-2">
                            <a href="{{ route('forgot.password') }}" class="text-sm text-[#F15A24] hover:underline">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-[#2D1622] hover:bg-[#422132] text-white py-3 px-4 rounded-md font-semibold shadow-md transition duration-200 transform active:scale-[0.98]">
                        Masuk
                    </button>
                </form>
            </div>

        </div>

    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('text-gray-400');
                eyeIcon.classList.add('text-[#F15A24]');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('text-[#F15A24]');
                eyeIcon.classList.add('text-gray-400');
            }
        }
    </script>
</body>
</html>