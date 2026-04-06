<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Settings</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        .toggle-checkbox:checked {
            right: 0;
            border-color: #6366f1;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #6366f1;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ url()->previous() }}" class="p-2 text-slate-600 hover:text-indigo-600 hover:bg-white rounded-lg transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Notification Settings</h1>
                <p class="text-slate-500">Choose how you want to be notified</p>
            </div>
        </div>

        <div x-data="notificationSettings()" x-init="loadSettings()" class="space-y-6">
            <!-- Phone Number Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    <i class="fas fa-phone text-indigo-500 mr-2"></i>Contact Information
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Phone Number (for SMS)</label>
                        <div class="flex gap-3">
                            <input type="tel" x-model="settings.phone_number" 
                                   class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="+63 912 345 6789">
                            <button @click="saveSettings()" 
                                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Enter your mobile number with country code (e.g., +63 for Philippines)</p>
                    </div>
                </div>
            </div>

            <!-- Email Notifications -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-envelope text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">Email Notifications</h2>
                        <p class="text-sm text-slate-500">Receive updates via email</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <template x-for="(label, key) in emailOptions" :key="key">
                        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
                            <div>
                                <p class="font-medium text-slate-700" x-text="label"></p>
                                <p class="text-xs text-slate-500" x-text="descriptions[key]"></p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="settings[key]" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </template>
                </div>
            </div>

            <!-- SMS Notifications -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-sms text-emerald-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">SMS Notifications</h2>
                        <p class="text-sm text-slate-500">Receive text messages on your phone</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <template x-for="(label, key) in smsOptions" :key="key">
                        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
                            <div>
                                <p class="font-medium text-slate-700" x-text="label"></p>
                                <p class="text-xs text-slate-500" x-text="descriptions[key]"></p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="settings[key]" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end gap-3">
                <a href="{{ url()->previous() }}" class="px-6 py-2.5 text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Cancel
                </a>
                <button @click="saveSettings()" 
                        :disabled="saving"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors flex items-center gap-2 disabled:opacity-50">
                    <i class="fas fa-spinner fa-spin" x-show="saving"></i>
                    <i class="fas fa-check" x-show="!saving"></i>
                    <span x-text="saving ? 'Saving...' : 'Save Changes'"></span>
                </button>
            </div>

            <!-- Success Message -->
            <div x-show="saved" x-transition class="fixed bottom-6 right-6 bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <span>Settings saved successfully!</span>
            </div>
        </div>
    </div>

    <script>
        function notificationSettings() {
            return {
                settings: {
                    phone_number: '',
                    email_new_message: true,
                    email_announcement: true,
                    email_grade_posted: true,
                    email_attendance_alert: true,
                    email_assignment_due: true,
                    sms_new_message: false,
                    sms_announcement: false,
                    sms_grade_posted: false,
                    sms_attendance_alert: true,
                    sms_assignment_due: false,
                },
                saving: false,
                saved: false,
                emailOptions: {
                    email_new_message: 'New Messages',
                    email_announcement: 'Announcements',
                    email_grade_posted: 'Grade Posted',
                    email_attendance_alert: 'Attendance Alerts',
                    email_assignment_due: 'Assignment Due',
                },
                smsOptions: {
                    sms_new_message: 'New Messages',
                    sms_announcement: 'Announcements',
                    sms_grade_posted: 'Grade Posted',
                    sms_attendance_alert: 'Attendance Alerts',
                    sms_assignment_due: 'Assignment Due',
                },
                descriptions: {
                    email_new_message: 'When someone sends you a message',
                    email_announcement: 'New school announcements',
                    email_grade_posted: 'When grades are published',
                    email_attendance_alert: 'Absence or tardiness notifications',
                    email_assignment_due: 'Reminders before due dates',
                    sms_new_message: 'When someone sends you a message',
                    sms_announcement: 'Important school announcements',
                    sms_grade_posted: 'When grades are published',
                    sms_attendance_alert: 'Urgent: Child absence notifications',
                    sms_assignment_due: 'Assignment due reminders',
                },

                async loadSettings() {
                    try {
                        const response = await fetch('{{ route('notifications.settings') }}', {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                        const data = await response.json();
                        this.settings = { ...this.settings, ...data };
                    } catch (error) {
                        console.error('Failed to load settings:', error);
                    }
                },

                async saveSettings() {
                    this.saving = true;
                    try {
                        const response = await fetch('{{ route('notifications.settings.update') }}', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.settings)
                        });
                        
                        if (response.ok) {
                            this.saved = true;
                            setTimeout(() => this.saved = false, 3000);
                        }
                    } catch (error) {
                        console.error('Failed to save settings:', error);
                        alert('Failed to save settings. Please try again.');
                    }
                    this.saving = false;
                }
            }
        }
    </script>
</body>
</html>
