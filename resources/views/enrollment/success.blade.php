<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Submitted</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full text-center">
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check-circle text-5xl text-green-600"></i>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Enrollment Submitted!</h1>
        <p class="text-gray-600 mb-6">Your enrollment application has been received and is pending review.</p>
        
        <div class="bg-gray-50 rounded-xl p-6 mb-6 text-left">
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Reference Number:</span>
                <span class="font-bold text-gray-800">#{{ $enrollment->id }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Student Name:</span>
                <span class="font-bold text-gray-800">{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Grade Level:</span>
                <span class="font-bold text-gray-800">{{ $enrollment->gradeLevel->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Status:</span>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-bold">PENDING</span>
            </div>
        </div>
        
        <p class="text-sm text-gray-500 mb-6">
            <i class="fas fa-info-circle mr-1"></i>
            Please save your reference number. You will be notified once your enrollment is approved.
        </p>
        
        <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-gray-800 text-white rounded-xl font-semibold hover:bg-gray-900 transition-colors">
            <i class="fas fa-home mr-2"></i>Go to Login
        </a>
    </div>
</body>
</html>