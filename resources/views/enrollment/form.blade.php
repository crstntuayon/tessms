<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollment - {{ $schoolYear->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-6 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-graduation-cap text-3xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Student Enrollment</h1>
            <p class="text-gray-600">School Year: <span class="font-semibold text-blue-600">{{ $schoolYear->name }}</span></p>
        </div>

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            {{ session('error') }}
        </div>
        @endif

        <!-- Enrollment Form -->
        <form action="{{ route('enrollment.submit') }}" method="POST" class="bg-white rounded-2xl shadow-xl p-8" id="enrollmentForm">
            @csrf
            <input type="hidden" name="qr_token" value="{{ $token }}">

            <!-- Personal Information -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm mr-3">1</span>
                    Personal Information
                </h2>
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                        <input type="text" name="first_name" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('first_name') }}">
                        @error('first_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                        <input type="text" name="middle_name" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('middle_name') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                        <input type="text" name="last_name" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('last_name') }}">
                        @error('last_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Birthdate *</label>
                        <input type="date" name="birthdate" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('birthdate') }}">
                        @error('birthdate')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                        <select name="gender" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Number *</label>
                        <input type="tel" name="contact_number" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('contact_number') }}">
                        @error('contact_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                    <textarea name="address" required rows="2"
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('address') }}</textarea>
                    @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Guardian Information -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm mr-3">2</span>
                    Guardian Information
                </h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Guardian Name *</label>
                        <input type="text" name="guardian_name" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('guardian_name') }}">
                        @error('guardian_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Guardian Contact *</label>
                        <input type="tel" name="guardian_contact" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('guardian_contact') }}">
                        @error('guardian_contact')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm mr-3">3</span>
                    Academic Information
                </h2>
                
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level *</label>
                        <select name="grade_level_id" id="gradeLevel" required 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Grade Level</option>
                            @foreach($gradeLevels as $grade)
                            <option value="{{ $grade->id }}" {{ old('grade_level_id') == $grade->id ? 'selected' : '' }}>
                                {{ $grade->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('grade_level_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Section (Optional)</label>
                        <select name="section_id" id="section" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Auto-assign</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Previous School</label>
                    <input type="text" name="previous_school" 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="{{ old('previous_school') }}">
                </div>

                <!-- Subjects Loading Area -->
                <div id="subjectsContainer" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Available Subjects</label>
                    <div id="subjectsList" class="grid md:grid-cols-2 gap-3">
                        <!-- Subjects loaded via AJAX -->
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" 
                        class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Enrollment Application
                </button>
                <p class="text-sm text-gray-500 mt-3">
                    <i class="fas fa-lock mr-1"></i>Your information is secure and will be reviewed by the administration.
                </p>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('gradeLevel').addEventListener('change', function() {
            const gradeLevelId = this.value;
            
            if (!gradeLevelId) {
                document.getElementById('subjectsContainer').classList.add('hidden');
                return;
            }

            // Load subjects
            fetch(`{{ route('enrollment.subjects') }}?grade_level_id=${gradeLevelId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.subjects.length > 0) {
                        const subjectsList = document.getElementById('subjectsList');
                        subjectsList.innerHTML = data.subjects.map(subject => `
                            <label class="flex items-center p-3 border rounded-lg hover:bg-blue-50 cursor-pointer transition-colors">
                                <input type="checkbox" name="subjects[]" value="${subject.id}" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                                <div class="ml-3">
                                    <p class="font-medium text-gray-800">${subject.name}</p>
                                    ${subject.code ? `<p class="text-xs text-gray-500">${subject.code}</p>` : ''}
                                </div>
                            </label>
                        `).join('');
                        document.getElementById('subjectsContainer').classList.remove('hidden');
                    } else {
                        document.getElementById('subjectsContainer').classList.add('hidden');
                    }
                });

            // Load sections
            fetch(`{{ route('enrollment.sections') }}?grade_level_id=${gradeLevelId}`)
                .then(response => response.json())
                .then(data => {
                    const sectionSelect = document.getElementById('section');
                    sectionSelect.innerHTML = '<option value="">Auto-assign</option>';
                    if (data.success && data.sections.length > 0) {
                        data.sections.forEach(section => {
                            sectionSelect.innerHTML += `<option value="${section.id}">${section.name} (Capacity: ${section.capacity})</option>`;
                        });
                    }
                });
        });

        // Trigger change if old value exists
        @if(old('grade_level_id'))
            document.getElementById('gradeLevel').dispatchEvent(new Event('change'));
        @endif
    </script>
</body>
</html>