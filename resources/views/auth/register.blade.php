<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/assets/img/logo_mv.png') }}" rel="icon">
    <title>Register | PSMTPJ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-300 to-blue-500 px-4">

    <div class="w-full max-w-md p-6 sm:p-8 bg-white rounded-lg shadow-xl animate-fade-in space-y-6">
        <!-- Heading -->
        <div class="text-center">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-blue-700 drop-shadow-md">Create an Account</h1>
            <p class="mt-2 text-gray-700">Join us and start managing logistics easily.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="mt-6 text-left">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-gray-700 font-semibold">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-blue-400">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mt-4">
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-blue-400">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mt-4">
                <label for="password" class="block text-gray-700 font-semibold">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-blue-400 pr-10">
                    <span class="absolute right-3 top-3 cursor-pointer" onclick="togglePassword('password', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </span>
                </div>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mt-4">
                <label for="password_confirmation" class="block text-gray-700 font-semibold">Confirm Password</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-blue-400 pr-10">
                    <span class="absolute right-3 top-3 cursor-pointer" onclick="togglePassword('password_confirmation', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Already registered?</a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-transform transform hover:scale-105">
                    Register
                </button>
            </div>
        </form>

        <!-- Footer -->
        <footer class="pt-6 text-center text-gray-500 text-sm animate-fade-in">
            <p>&copy; PSMTPJ 2025</p>
            <p>Fullstack Developer | Raditya Marantika</p>
        </footer>
    </div>

    <!-- Toggle Password Script -->
    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            const isVisible = input.type === 'text';
            input.type = isVisible ? 'password' : 'text';

            // Optional: Ganti ikon kalau mau (tidak dilakukan di sini)
        }
    </script>

    <!-- Animasi -->
    <style>
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in {
            animation: fade-in 1.5s ease-out;
        }
    </style>
</body>
</html>
