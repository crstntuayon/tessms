<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pupil Login - Tugawe Elementary School</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Nunito', sans-serif; }
        
        .student-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .student-gradient-alt {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes wiggle {
            0%, 100% { transform: rotate(-3deg); }
            50% { transform: rotate(3deg); }
        }
        
        .float-anim { animation: float 3s ease-in-out infinite; }
        .wiggle-anim { animation: wiggle 2s ease-in-out infinite; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.5);
        }
        
        .input-focus:focus {
            transform: scale(1.02);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        }
    </style>
</head>
<body class="min-h-screen student-gradient flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Floating Decorative Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/20 rounded-full float-anim"></div>
    <div class="absolute top-20 right-20 w-16 h-16 bg-yellow-300/30 rounded-full float-anim" style="animation-delay: 0.5s;"></div>
    <div class="absolute bottom-20 left-20 w-24 h-24 bg-pink-300/30 rounded-full float-anim" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-10 right-10 w-14 h-14 bg-green-300/30 rounded-full float-anim" style="animation-delay: 1.5s;"></div>
    
    <!-- Stars -->
    <div class="absolute top-1/4 left-1/4 text-white/30 text-2xl wiggle-anim">⭐</div>
    <div class="absolute top-1/3 right-1/3 text-white/30 text-xl wiggle-anim" style="animation-delay: 0.3s;">✨</div>
    <div class="absolute bottom-1/3 left-1/3 text-white/30 text-lg wiggle-anim" style="animation-delay: 0.6s;">🌟</div>

    <div class="w-full max-w-md relative z-10">
        <!-- Back to Home -->
        <a href="/" class="inline-flex items-center gap-2 text-white/80 hover:text-white mb-6 transition-colors">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Home</span>
        </a>
        
        <!-- Login Card -->
        <div class="glass-card rounded-3xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-user-graduate text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-800 mb-1">Pupil Login</h1>
                <p class="text-slate-500 text-sm">Welcome back! Ready to learn?</p>
            </div>
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-r-xl mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-circle mt-0.5"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            
            @if(session('status'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl mb-6">
                    <p class="text-sm">{{ session('status') }}</p>
                </div>
            @endif
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('student.login.post') }}" class="space-y-5">
                @csrf
                
                <!-- Username -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fas fa-user text-indigo-500 mr-2"></i>Username
                    </label>
                    <input type="text" name="username" required 
                           class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:outline-none input-focus transition-all"
                           placeholder="Enter your username"
                           value="{{ old('username') }}">
                </div>
                
                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fas fa-lock text-indigo-500 mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required 
                               class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:outline-none input-focus transition-all"
                               placeholder="Enter your password">
                        <button type="button" onclick="togglePassword()" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-500 transition-colors">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                        <span class="text-sm text-slate-600">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        Forgot password?
                    </a>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white py-3.5 rounded-xl font-bold text-lg shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
            </form>
            
            <!-- Teacher Portal Link -->
            <div class="mt-6 pt-6 border-t border-slate-200 text-center">
                <p class="text-sm text-slate-500">
                    Are you a teacher or admin?
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold ml-1">
                        Login here <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </p>
            </div>
        </div>
        
        <!-- Help Text -->
        <p class="text-center text-white/70 text-sm mt-6">
            Need help? Contact your teacher or the school office
        </p>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
        

    </script>
</body>
</html>
