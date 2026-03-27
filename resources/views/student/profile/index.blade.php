<!-- resources/views/student/profile/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Tugawe Elementary School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="profileApp()">

    <!-- Include Sidebar -->
    @include('student.includes.sidebar')

    <!-- Main Content -->
    <main class="transition-all duration-300 ease-out min-h-screen p-4 lg:p-8"
          :class="mainContentClass">
        
        <!-- Toast Notification -->
        <div x-show="toast.show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             class="fixed top-4 right-4 z-50 flex items-center gap-2 px-4 py-3 rounded-xl shadow-lg"
             :class="toast.type === 'success' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      :d="toast.type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'"/>
            </svg>
            <span class="font-medium text-sm" x-text="toast.message"></span>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">My Profile</h1>
                    <p class="text-slate-500 mt-1">Manage your personal information and account settings</p>
                </div>
                <div class="flex items-center gap-3">
                    <button @click="editMode = !editMode" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-medium text-sm transition-all duration-200"
                            :class="editMode ? 'bg-slate-200 text-slate-700 hover:bg-slate-300' : 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-200'">
                        <svg x-show="!editMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <svg x-show="editMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span x-text="editMode ? 'Cancel' : 'Edit Profile'"></span>
                    </button>
                    <button x-show="editMode" @click="saveProfile" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-xl font-medium text-sm hover:bg-emerald-700 transition-all duration-200 shadow-lg shadow-emerald-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <!-- Left Column - Profile Card -->
            <div class="xl:col-span-1 space-y-6">
                <!-- Profile Photo Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="h-32 bg-gradient-to-br from-indigo-600 to-violet-600 relative">
                        <div class="absolute inset-0 opacity-20">
                            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"/>
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 pb-6 relative">
                        <div class="relative -mt-16 mb-4 flex justify-center">
                            <div class="relative group">
                                <div class="w-32 h-32 rounded-2xl bg-white p-1 shadow-xl">
                                    @if(isset($student) && $student->photo)
                                        <img src="{{ asset('storage/' . $student->photo) }}" 
                                             class="w-full h-full rounded-xl object-cover" 
                                             alt="Profile Photo">
                                    @else
                                        <div class="w-full h-full rounded-xl bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white text-3xl font-bold">
                                            @if(isset($student) && $student->user)
                                                {{ substr($student->user->first_name, 0, 1) }}{{ substr($student->user->last_name, 0, 1) }}
                                            @else
                                                S
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <button @click="showPhotoModal = true" 
                                        class="absolute -bottom-2 -right-2 w-10 h-10 bg-white rounded-xl shadow-lg border border-slate-200 flex items-center justify-center text-slate-600 hover:text-indigo-600 hover:border-indigo-300 transition-all duration-200 group-hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <h2 class="text-xl font-bold text-slate-900">
                                @if(isset($student) && $student->user)
                                    {{ $student->user->first_name }} {{ $student->user->last_name }}
                                @else
                                    Student Name
                                @endif
                            </h2>
                            <p class="text-slate-500 text-sm mt-1">
                                @if(isset($student) && $student->user)
                                    {{ $student->user->email }}
                                @endif
                            </p>
                            <div class="flex items-center justify-center gap-2 mt-3 flex-wrap">
                                @if(isset($student) && $student->lrn)
                                    <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-full">
                                        LRN: {{ $student->lrn }}
                                    </span>
                                @endif
                                @if(isset($student) && $student->gradeLevel)
                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full">
                                        {{ $student->gradeLevel->name }}
                                    </span>
                                @endif
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full capitalize">
                                    {{ $student->status ?? 'pending' }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-slate-100">
                            <div class="text-center">
                                <p class="text-lg font-bold text-slate-900">
                                    @if(isset($student) && $student->section)
                                        {{ $student->section->name }}
                                    @else
                                        —
                                    @endif
                                </p>
                                <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Section</p>
                            </div>
                            <div class="text-center border-l border-slate-100">
                                <p class="text-lg font-bold text-slate-900">
                                    @if(isset($student) && $student->gender)
                                        {{ ucfirst($student->gender) }}
                                    @else
                                        —
                                    @endif
                                </p>
                                <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Gender</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="font-bold text-slate-900 mb-4">Account Settings</h3>
                    <div class="space-y-2">
                        <button @click="showPasswordModal = true" 
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition-colors">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="font-medium text-sm">Change Password</p>
                                <p class="text-xs text-slate-400">Update your security credentials</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column - Details -->
            <div class="xl:col-span-2 space-y-6">
                
                <!-- Tabs -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-1">
                    <div class="flex gap-1">
                        <button @click="activeTab = 'personal'" 
                                class="flex-1 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200"
                                :class="activeTab === 'personal' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'">
                            Personal
                        </button>
                        <button @click="activeTab = 'family'" 
                                class="flex-1 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200"
                                :class="activeTab === 'family' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'">
                            Family
                        </button>
                        <button @click="activeTab = 'address'" 
                                class="flex-1 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200"
                                :class="activeTab === 'address' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'">
                            Address
                        </button>
                        <button @click="activeTab = 'academic'" 
                                class="flex-1 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200"
                                :class="activeTab === 'academic' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'">
                            Academic
                        </button>
                    </div>
                </div>

                <!-- Personal Tab -->
                <div x-show="activeTab === 'personal'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Personal Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">First Name</label>
                                    <input x-show="editMode" x-model="formData.first_name" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                    <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.first_name || '—'"></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">LRN (Learner Reference Number)</label>
                                    <input x-show="editMode" x-model="formData.lrn" type="text" maxlength="50" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                    <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.lrn || '—'"></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Birth Date</label>
                                    <input x-show="editMode" x-model="formData.birthdate" type="date" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                   <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formatDateWithAge(formData.birthdate)"></p>
                                </div>
                                <div>
                                  <script>
function formatDateWithAge(date) {
    if (!date) return '—';

    const d = new Date(date);
    const today = new Date();

    let age = today.getFullYear() - d.getFullYear();
    const m = today.getMonth() - d.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < d.getDate())) {
        age--;
    }

    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');

    return `${yyyy}-${mm}-${dd} (${age} years old)`;
}
</script>


                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Gender</label>
                                    <select x-show="editMode" x-model="formData.gender" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <p x-show="!editMode" class="text-slate-900 font-medium capitalize" x-text="formData.gender || '—'"></p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Last Name</label>
                                    <input x-show="editMode" x-model="formData.last_name" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                    <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.last_name || '—'"></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                                    <input x-show="editMode" x-model="formData.email" type="email" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                    <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.email || '—'"></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Birth Place</label>
                                    <input x-show="editMode" x-model="formData.birth_place" type="text" maxlength="150" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                    <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.birth_place || '—'"></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nationality</label>
                                    <input x-show="editMode" x-model="formData.nationality" type="text" maxlength="100" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                    <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.nationality || '—'"></p>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Religion</label>
                                <input x-show="editMode" x-model="formData.religion" type="text" maxlength="100" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.religion || '—'"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Family Tab -->
                <div x-show="activeTab === 'family'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <!-- Father's Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Father's Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Father's Name</label>
                                <input x-show="editMode" x-model="formData.father_name" type="text" maxlength="150" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.father_name || '—'"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Father's Occupation</label>
                                <input x-show="editMode" x-model="formData.father_occupation" type="text" maxlength="100" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.father_occupation || '—'"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Mother's Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Mother's Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Mother's Name</label>
                                <input x-show="editMode" x-model="formData.mother_name" type="text" maxlength="150" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.mother_name || '—'"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Mother's Occupation</label>
                                <input x-show="editMode" x-model="formData.mother_occupation" type="text" maxlength="100" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.mother_occupation || '—'"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian's Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Guardian's Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Guardian's Name</label>
                                <input x-show="editMode" x-model="formData.guardian_name" type="text" maxlength="150" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.guardian_name || '—'"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Relationship</label>
                                <input x-show="editMode" x-model="formData.guardian_relationship" type="text" maxlength="50" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.guardian_relationship || '—'"></p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Guardian's Contact Number</label>
                                <input x-show="editMode" x-model="formData.guardian_contact" type="tel" maxlength="50" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.guardian_contact || '—'"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Tab -->
                <div x-show="activeTab === 'address'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Address Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Street Address</label>
                                <input x-show="editMode" x-model="formData.street_address" type="text" maxlength="255" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.street_address || '—'"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Barangay</label>
                                <input x-show="editMode" x-model="formData.barangay" type="text" maxlength="100" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.barangay || '—'"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">City / Municipality</label>
                                <input x-show="editMode" x-model="formData.city" type="text" maxlength="100" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.city || '—'"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Province</label>
                                <input x-show="editMode" x-model="formData.province" type="text" maxlength="100" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.province || '—'"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">ZIP Code</label>
                                <input x-show="editMode" x-model="formData.zip_code" type="text" maxlength="20" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                <p x-show="!editMode" class="text-slate-900 font-medium" x-text="formData.zip_code || '—'"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Tab -->
                <div x-show="activeTab === 'academic'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-900 mb-4">Academic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 rounded-xl bg-slate-50">
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Student ID</p>
                                <p class="text-lg font-bold text-slate-900">
                                    @if(isset($student))
                                        {{ $student->id }}
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50">
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">LRN</p>
                                <p class="text-lg font-bold text-slate-900">
                                    @if(isset($student) && $student->lrn)
                                        {{ $student->lrn }}
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50">
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Grade Level</p>
                                <p class="text-lg font-bold text-slate-900">
                                    @if(isset($student) && $student->gradeLevel)
                                        {{ $student->gradeLevel->name }}
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50">
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Section</p>
                                <p class="text-lg font-bold text-slate-900">
                                    @if(isset($student) && $student->section)
                                        {{ $student->section->name }}
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50">
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Enrollment Status</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold capitalize
                                    @if(isset($student) && $student->status === 'enrolled') bg-emerald-100 text-emerald-700
                                    @elseif(isset($student) && $student->status === 'pending') bg-amber-100 text-amber-700
                                    @elseif(isset($student) && $student->status === 'approved') bg-blue-100 text-blue-700
                                    @elseif(isset($student) && $student->status === 'rejected') bg-rose-100 text-rose-700
                                    @else bg-slate-100 text-slate-700 @endif">
                                    {{ $student->status ?? 'pending' }}
                                </span>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50">
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Member Since</p>
                                <p class="text-lg font-bold text-slate-900">
                                    @if(isset($student) && $student->created_at)
                                        {{ $student->created_at->format('M d, Y') }}
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Password Change Modal -->
    <div x-show="showPasswordModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="showPasswordModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showPasswordModal = false"
             class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        
        <div x-show="showPasswordModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-900">Change Password</h3>
                <button @click="showPasswordModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form @submit.prevent="updatePassword">
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Current Password</label>
                        <input type="password" x-model="passwordForm.current" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all" placeholder="Enter current password" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">New Password</label>
                        <input type="password" x-model="passwordForm.new" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all" placeholder="Enter new password" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Confirm New Password</label>
                        <input type="password" x-model="passwordForm.confirm" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all" placeholder="Confirm new password" required>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-slate-50 flex gap-3">
                    <button type="button" @click="showPasswordModal = false" class="flex-1 px-4 py-2.5 border border-slate-300 text-slate-700 rounded-xl font-medium hover:bg-slate-100 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Photo Upload Modal -->
    <div x-show="showPhotoModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="showPhotoModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showPhotoModal = false"
             class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        
        <div x-show="showPhotoModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-900">Update Profile Photo</h3>
                <button @click="showPhotoModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('student.profile.photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6">
                    <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:border-indigo-400 hover:bg-indigo-50/50 transition-all cursor-pointer relative" onclick="document.getElementById('photo-input').click()">
                        <input type="file" id="photo-input" name="photo" accept="image/*" class="hidden" @change="fileName = $event.target.files[0]?.name">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-indigo-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="font-medium text-slate-900 mb-1" x-text="fileName || 'Click to upload or drag and drop'"></p>
                        <p class="text-sm text-slate-500">PNG, JPG or GIF (max. 2MB)</p>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-slate-50 flex gap-3">
                    <button type="button" @click="showPhotoModal = false" class="flex-1 px-4 py-2.5 border border-slate-300 text-slate-700 rounded-xl font-medium hover:bg-slate-100 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">Upload Photo</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function profileApp() {
            return {
                activeTab: 'personal',
                editMode: false,
                showPasswordModal: false,
                showPhotoModal: false,
                fileName: '',
                toast: { show: false, message: '', type: 'success' },
                sidebarCollapsed: false,
                sidebarMobileOpen: false,
                isMobile: window.innerWidth < 1024,
                formData: {
                    // User data
                    first_name: @json($student->user->first_name ?? ''),
                    last_name: @json($student->user->last_name ?? ''),
                    email: @json($student->user->email ?? ''),
                    // Student data
                    lrn: @json($student->lrn ?? ''),
                    birthdate: @json($student->birthdate ?? ''),
                    birth_place: @json($student->birth_place ?? ''),
                    gender: @json($student->gender ?? ''),
                    nationality: @json($student->nationality ?? ''),
                    religion: @json($student->religion ?? ''),
                    father_name: @json($student->father_name ?? ''),
                    father_occupation: @json($student->father_occupation ?? ''),
                    mother_name: @json($student->mother_name ?? ''),
                    mother_occupation: @json($student->mother_occupation ?? ''),
                    guardian_name: @json($student->guardian_name ?? ''),
                    guardian_relationship: @json($student->guardian_relationship ?? ''),
                    guardian_contact: @json($student->guardian_contact ?? ''),
                    street_address: @json($student->street_address ?? ''),
                    barangay: @json($student->barangay ?? ''),
                    city: @json($student->city ?? ''),
                    province: @json($student->province ?? ''),
                    zip_code: @json($student->zip_code ?? '')
                },
                passwordForm: {
                    current: '',
                    new: '',
                    confirm: ''
                },
                get mainContentClass() {
                    // Mobile view
                    if (this.isMobile) {
                        return this.sidebarMobileOpen ? 'ml-72' : 'ml-0';
                    }
                    // Desktop view
                    return this.sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-72';
                },
                init() {
                    // Check initial sidebar state from localStorage
                    this.sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                    
                    // Listen for sidebar toggle events
                    window.addEventListener('sidebar-toggle', (e) => {
                        this.sidebarCollapsed = e.detail.collapsed;
                    });
                    
                    // Listen for mobile menu toggle
                    window.addEventListener('sidebar-mobile-toggle', (e) => {
                        this.sidebarMobileOpen = e.detail.open;
                    });

                    // Handle resize
                    window.addEventListener('resize', () => {
                        this.isMobile = window.innerWidth < 1024;
                    });

                    // Watch for localStorage changes (in case sidebar updates it)
                    window.addEventListener('storage', (e) => {
                        if (e.key === 'sidebarCollapsed') {
                            this.sidebarCollapsed = e.newValue === 'true';
                        }
                    });

                    // Auto-hide toast
                    this.$watch('toast.show', value => {
                        if (value) setTimeout(() => this.toast.show = false, 3000);
                    });
                },
                saveProfile() {
                    // TODO: Implement actual save via fetch/AJAX to your endpoint
                    // Example:
                    // fetch('{{ route("student.profile.update") }}', {
                    //     method: 'POST',
                    //     headers: {
                    //         'Content-Type': 'application/json',
                    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    //     },
                    //     body: JSON.stringify(this.formData)
                    // })
                    
                    this.editMode = false;
                    this.showToast('Profile updated successfully!', 'success');
                },
                updatePassword() {
                    if (this.passwordForm.new !== this.passwordForm.confirm) {
                        this.showToast('Passwords do not match!', 'error');
                        return;
                    }
                    // TODO: Implement password update
                    this.showPasswordModal = false;
                    this.passwordForm = { current: '', new: '', confirm: '' };
                    this.showToast('Password updated successfully!', 'success');
                },
                showToast(message, type = 'success') {
                    this.toast = { show: true, message, type };
                }
            }
        }
    </script>

</body>
</html>