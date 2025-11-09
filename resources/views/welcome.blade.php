<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/assets/img/logo_mv.png') }}" rel="icon">
    <title>Welcome | NEFA System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-300 to-blue-500">
    <div class="w-full max-w-xl p-8 bg-white rounded-lg shadow-xl text-center animate-fade-in">
        <!-- Logo Perusahaan -->
        <div class="mb-6">
            {{-- <img src="{{ asset('/assets/img/logo_mv.png') }}" alt="Company Logo" class="mx-auto w-40 h-auto drop-shadow-lg"> --}}
        </div>
        
        <!-- Welcome Text -->
        <h1 class="text-4xl font-extrabold text-blue-700 drop-shadow-md">NEFA Management System</h1>
        <p class="mt-3 text-lg text-gray-700">Your trusted in Finance Management.</p>
        
        <!-- Navigation -->
        @if (Route::has('login'))
        <nav class="mt-8 flex justify-center space-x-6 animate-slide-up">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition-transform transform hover:scale-105">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition-transform transform hover:scale-105">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition-transform transform hover:scale-105">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
        @endif
        
        <!-- Footer -->
        <footer class="mt-12 text-gray-500 animate-fade-in">
            <p>&copy; 2025 NEFA Management System</p>
            <p class="text-sm">Fullstack Developer | Raditya Marantika</p>
        </footer>
    </div>
    
    <style>
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slide-up {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-fade-in { animation: fade-in 1.5s ease-out; }
        .animate-slide-up { animation: slide-up 1s ease-out; }
    </style>
</body>
</html>
