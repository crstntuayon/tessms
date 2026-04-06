<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Continuing Student Enrollment - Tugawe Elementary School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.5);
        }
    </style>
</head>
<body class="min-h-screen gradient-bg">
    
    <!-- Header -->
    <header class="glass sticky top-0 z-50 shadow-sm">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white"></i>
                </div>
                <div>
                    <h1 class="font-bold text-slate-800">Tugawe Elementary School</h1>
                    <p class="text-xs text-slate-500">Online Enrollment</p>
                </div>
            </div>
            <a href="/" class="text-slate-600 hover:text-indigo-600">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>
    </header>

    <main class="py-12 px-4">
        <div class="max-w-xl mx-auto">
            
            <!-- Notice for New Students -->
            <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-amber-600 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">For New Students & Transferees</p>
                        <p class="text-xs text-amber-700 mt-1">
                            If you are a new student (Kindergarten) or transferee, please 
                            <a href="{{ route('login') }}?mode=register" class="underline font-semibold hover:text-amber-900">register here</a> instead.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                    <i class="fas fa-user-check text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Continuing Student Enrollment</h1>
                <p class="text-white/80">For old students enrolling in the new school year</p>
                @if($currentSchoolYear)
                    <div class="mt-3 inline-flex items-center gap-2 bg-white/20 px-4 py-1.5 rounded-full">
                        <i class="fas fa-calendar-alt text-white/90"></i>
                        <span class="text-white font-medium">{{ $currentSchoolYear->name }}</span>
                    </div>
                @endif
            </div>

            @if($errors->any())
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl p-4">
                    <ul class="text-sm text-rose-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class="glass rounded-3xl shadow-2xl p-8" x-data="continuingEnrollment()">
                
                <!-- Step 1: LRN Lookup -->
                <div x-show="step === 1" x-transition>
                    <h2 class="text-xl font-bold text-slate-800 mb-2">Find Your Record</h2>
                    <p class="text-slate-500 text-sm mb-6">Enter your Learner Reference Number (LRN) to retrieve your information</p>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-id-card text-indigo-500 mr-2"></i>LRN (Learner Reference Number)
                            </label>
                            <input type="text" x-model="lrn" placeholder="12-digit LRN" maxlength="12"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-center text-lg tracking-wider">
                        </div>
                        
                        <button @click="lookupStudent()" :disabled="loading" 
                                class="w-full py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-semibold transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-search" x-show="!loading"></i>
                            <i class="fas fa-spinner fa-spin" x-show="loading"></i>
                            <span x-text="loading ? 'Looking up...' : 'Find My Record'"></span>
                        </button>
                        
                        <p x-show="error" x-text="error" class="text-rose-600 text-sm text-center"></p>
                    </div>
                </div>

                <!-- Step 2: Confirm & Enroll -->
                <div x-show="step === 2" x-transition style="display: none;">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-slate-800">Confirm Enrollment</h2>
                        <button @click="step = 1" class="text-sm text-slate-500 hover:text-indigo-600">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </button>
                    </div>

                    <!-- Student Info Display -->
                    <div class="bg-indigo-50 rounded-xl p-4 mb-6">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-indigo-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800" x-text="studentName"></p>
                                <p class="text-sm text-slate-500">LRN: <span x-text="lrn"></span></p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-slate-500">Last Grade:</span>
                                <span class="font-medium ml-1" x-text="lastGrade"></span>
                            </div>
                            <div>
                                <span class="text-slate-500">School Year:</span>
                                <span class="font-medium ml-1" x-text="lastSchoolYear"></span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('enrollment.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="application_type" value="continuing">
                        <input type="hidden" name="school_year_id" value="{{ $currentSchoolYear->id ?? '' }}">
                        <input type="hidden" name="student_lrn" x-model="lrn">
                        <input type="hidden" name="student_id" x-model="studentId">

                        <!-- Active School Year Info -->
                        @if($currentSchoolYear)
                            <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                                <div class="flex items-center gap-2 text-emerald-700">
                                    <i class="fas fa-calendar-check"></i>
                                    <span class="font-semibold">Enrolling for: {{ $currentSchoolYear->name }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Grade Level to Enroll -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-slate-700 mb-3">
                                <i class="fas fa-award text-indigo-500 mr-2"></i>Grade Level to Enroll <span class="text-rose-500">*</span>
                            </label>
                            <select name="grade_level_id" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 appearance-none cursor-pointer">
                                <option value="">Select Grade Level</option>
                                @foreach($gradeLevels as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Select the grade level you will be enrolling in for the new school year
                            </p>
                        </div>

                        <!-- Parent Email -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-slate-700 mb-3">
                                <i class="fas fa-envelope text-indigo-500 mr-2"></i>Parent Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="parent_email" placeholder="parent@email.com" required
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                            <p class="text-xs text-slate-500 mt-1">We'll send enrollment confirmation to this email</p>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn-primary w-full py-4 text-white font-semibold rounded-xl flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            <span>Confirm Enrollment</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Check Status Link -->
            <div class="text-center mt-6">
                <a href="{{ route('enrollment.check') }}" class="text-white/80 hover:text-white text-sm">
                    <i class="fas fa-search mr-1"></i> Already enrolled? Check your status
                </a>
            </div>
        </div>
    </main>

    <script>
        function continuingEnrollment() {
            return {
                step: 1,
                lrn: '',
                studentId: '',
                studentName: '',
                lastGrade: '',
                lastSchoolYear: '',
                loading: false,
                error: '',

                async lookupStudent() {
                    // Clean the LRN - remove any non-digit characters
                    this.lrn = this.lrn.replace(/\D/g, '');
                    
                    if (this.lrn.length !== 12) {
                        this.error = 'Please enter a valid 12-digit LRN';
                        return;
                    }

                    this.loading = true;
                    this.error = '';

                    try {
                        const response = await fetch(`/api/students/lookup?lrn=${this.lrn}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('Server error:', response.status, errorText);
                            this.error = 'Server error. Please try again later.';
                            return;
                        }
                        
                        const data = await response.json();

                        if (data.found) {
                            this.studentId = data.student.id;
                            this.studentName = data.student.full_name;
                            this.lastGrade = data.student.grade_level;
                            this.lastSchoolYear = data.student.school_year;
                            this.step = 2;
                        } else {
                            this.error = 'Student not found. Please check your LRN or register as a new student.';
                        }
                    } catch (err) {
                        console.error('Lookup error:', err);
                        this.error = 'Network error. Please check your connection and try again.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</body>
</html>
