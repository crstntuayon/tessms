<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-pink-100 to-purple-200 p-6">

    <!-- Header -->
    <header class="max-w-7xl mx-auto flex items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo.png') }}" class="h-16 w-16 rounded-full shadow" alt="School Logo">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Student Dashboard</h1>
                <p class="text-gray-600 mt-1">Welcome, {{ $student->first_name }}!</p>
            </div>
        </div>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </header>

    <!-- Student Information -->
    <main class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Student Information</h2>
            <p><span class="font-medium">Name:</span> {{ $student->first_name }} {{ $student->last_name }}</p>
            <p><span class="font-medium">Section:</span> {{ $section->name }}</p>
            <p><span class="font-medium">Teacher:</span> {{ $teacher->name ?? 'Not Assigned' }}</p>
        </div>

        <!-- Classmates -->
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="bg-purple-600 text-white px-6 py-4 font-semibold text-lg">
                Classmates
            </div>
            <div class="p-6">
                @if($classmates->isEmpty())
                    <p class="text-gray-600">No classmates found.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($classmates as $mate)
                            <li class="py-2 px-4 hover:bg-purple-50 rounded">
                                {{ $mate->first_name }} {{ $mate->last_name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </main>

</body>
</html>
