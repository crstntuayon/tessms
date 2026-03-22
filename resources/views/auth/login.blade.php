<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen relative overflow-hidden bg-gradient-to-br from-indigo-100 via-blue-100 to-indigo-200 flex items-center justify-center px-4">

    <!-- Background Glow -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-300 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute bottom-0 -right-24 w-96 h-96 bg-blue-300 rounded-full blur-3xl opacity-30"></div>

    <!-- Card -->
    <div class="relative w-full max-w-md bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-8 animate-[fadeUp_0.6s_ease-out]">

        <!-- Logo -->
        <div class="text-center mb-8">
        <img src="{{ asset('images/logo.jpg') }}"
             class="mx-auto h-20 w-20 rounded-full shadow-lg mb-4 ring-4 ring-indigo-200"
             alt="School Logo">
             
            <h1 class="text-2xl font-bold text-gray-800">Student Management System</h1>
            <p class="text-sm text-gray-500">Tugawe Elementary School</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" value="Email Address" />
                <x-text-input
                    id="email"
                    class="block w-full mt-1 rounded-xl focus:ring-2 focus:ring-indigo-500 transition"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" value="Password" />
                <div class="relative">
                    <x-text-input
                        id="password"
                        class="block w-full mt-1 rounded-xl pr-12 focus:ring-2 focus:ring-indigo-500 transition"
                        type="password"
                        name="password"
                        required
                    />
                    <button type="button"
                        onclick="togglePassword()"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-indigo-600">
                        👁
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-gray-600">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    Remember me
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Button -->
            <button type="submit"
                id="loginBtn"
                class="w-full flex justify-center items-center gap-2
                       bg-gradient-to-r from-indigo-600 to-blue-600
                       hover:from-indigo-700 hover:to-blue-700
                       text-white font-semibold py-3 rounded-xl
                       transition-all duration-200
                       shadow-lg hover:shadow-xl
                       active:scale-95">

                <span id="btnText">Log in</span>

                <!-- Spinner -->
                <svg id="spinner" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </button>
        </form>

        <!-- Register -->
        <p class="mt-6 text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">
                Register here
            </a>
        </p>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-400 mt-6">
            © {{ date('Y') }} Tugawe ES • Student Management System
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }

        document.getElementById('loginForm').addEventListener('submit', function () {
            document.getElementById('btnText').textContent = 'Signing in...';
            document.getElementById('spinner').classList.remove('hidden');
        });
    </script>

</body>
</html>
