<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-100 to-purple-200 flex items-center justify-center px-4 py-10">

<div class="w-full max-w-2xl backdrop-blur-xl bg-white/90 border border-white/40 rounded-3xl shadow-2xl p-8 md:p-10 animate-slide-up">

    <!-- Header -->
    <div class="text-center mb-8">
        <img src="{{ asset('images/logo.jpg') }}"
             class="mx-auto h-20 w-20 rounded-full shadow-lg mb-4 ring-4 ring-indigo-200"
             alt="School Logo">

        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">
            Student Management System
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Tugawe Elementary School
        </p>
    </div>

    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- LRN -->
        <div>
            <x-input-label for="lrn" value="LRN" />
            <x-text-input id="lrn" name="lrn"
                class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                required />
            <x-input-error :messages="$errors->get('lrn')" class="mt-1" />
        </div>

        <!-- Name Fields -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-input-label for="first_name" value="First Name" />
                <x-text-input id="first_name" name="first_name"
                    class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    required />
            </div>

            <div>
                <x-input-label for="middle_name" value="Middle Name" />
                <x-text-input id="middle_name" name="middle_name"
                    class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div>
                <x-input-label for="last_name" value="Last Name" />
                <x-text-input id="last_name" name="last_name"
                    class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    required />
            </div>
        </div>

        <!-- Suffix & Birthday -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="suffix" value="Suffix (optional)" />
                <x-text-input id="suffix" name="suffix"
                    class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Jr., III" />
            </div>

            <div>
                <x-input-label for="birthday" value="Birthday" />
                <x-text-input id="birthday" type="date" name="birthday"
                    class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    required />
            </div>
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" value="Username" />
            <x-text-input id="username" name="username"
                class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                required />
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email Address" />
            <x-text-input id="email" type="email" name="email"
                class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password"
                class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                required />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                required />
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700
                   text-white font-semibold py-3 rounded-xl shadow-lg transition-all duration-300
                   hover:scale-[1.03] hover:shadow-xl">
            Create Account
        </button>
    </form>

    <!-- Login -->
    <p class="mt-8 text-center text-sm text-gray-500">
        Already have an account?
        <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">
            Log in here
        </a>
    </p>

    <!-- Footer -->
    <p class="mt-6 text-center text-xs text-gray-400">
        © {{ date('Y') }} Tugawe Elementary School
    </p>

</div>

<!-- Animation -->
<style>
@keyframes slideUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-slide-up {
    animation: slideUp 0.6s ease-out;
}
</style>

</body>
</html>
