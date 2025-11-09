<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/assets/img/logo_ldp.png') }}" rel="icon">
    <title>Lavanaa Deva Perkasa</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }

        :root {
            --coklat: #795C32;
            --coklat-tua: #5E4526;
            --coklat-muda: #BFA87A;
            --abu: #a79776;
        }
    </style>
</head>

<body
    class="flex items-center justify-center min-h-screen bg-gradient-to-r from-[var(--abu)] to-[var(--coklat)] font-[Poppins]">

    <div class="flex w-11/12 max-w-5xl overflow-hidden bg-white rounded-2xl shadow-2xl animate-fade-in">

        {{-- BAGIAN KIRI --}}
        <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-[var(--coklat)] text-white p-10">
            <img src="{{ asset('/assets/img/logo_ldp.png') }}" alt="Logo" class="w-auto h-auto mb-50 drop-shadow-lg">
        </div>

        {{-- BAGIAN KANAN (FORM) --}}
        <div class="w-full md:w-1/2 p-10 bg-white/90 backdrop-blur-md flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-[var(--coklat)] mb-2 text-center">Login Form</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-[var(--coklat-tua)] font-semibold">Email</label>
                    <input id="email" type="email" name="email" required autofocus autocomplete="username"
                        class="w-full px-4 py-2 mt-1 border rounded-lg border-[var(--coklat-muda)] focus:ring-2 focus:ring-[var(--coklat)] focus:outline-none">
                </div>

                <div>
                    <label for="password" class="block text-[var(--coklat-tua)] font-semibold">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-2 mt-1 border rounded-lg border-[var(--coklat-muda)] focus:ring-2 focus:ring-[var(--coklat)] focus:outline-none">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="rounded border-gray-300 text-[var(--coklat)] focus:ring-[var(--coklat)]">
                        <label for="remember_me" class="ml-2 text-sm text-[var(--coklat-tua)]">Ingat saya</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-[var(--coklat)] hover:underline font-semibold">Lupa password?</a>
                    @endif
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('register') }}"
                        class="text-sm text-[var(--coklat)] hover:underline font-semibold">
                        Buat akun baru
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-[var(--coklat)] text-white font-semibold rounded-lg shadow-md hover:bg-[var(--coklat-tua)] transition-transform transform hover:scale-105">
                        Login
                    </button>
                </div>
            </form>

            {{-- Divider --}}
            <div class="flex items-center my-6">
                <hr class="flex-grow border-t border-[var(--coklat-muda)]">
                <hr class="flex-grow border-t border-[var(--coklat-muda)]">
            </div>



            <footer class="mt-8 text-[var(--coklat-tua)] text-xs text-center">
                <p>&copy; 2025 <span class="font-semibold">LDP WORKS SYSTEM</span></p>
                <p>Fullstack Developer | <span class="font-semibold">ToeDev.id</span></p>
            </footer>
        </div>
    </div>

</body>

</html>
