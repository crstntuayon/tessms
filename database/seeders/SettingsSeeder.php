<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing settings
        Setting::truncate();

        $settings = [
            // General Settings
            [
                'key' => 'system_name',
                'value' => 'Tugawe Elementary School',
                'type' => 'string',
                'group' => 'general',
                'description' => 'The name of the system displayed throughout the application'
            ],
            [
                'key' => 'timezone',
                'value' => 'Asia/Manila',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Default timezone for the application'
            ],
            [
                'key' => 'date_format',
                'value' => 'F d, Y',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Format for displaying dates'
            ],
            [
                'key' => 'default_language',
                'value' => 'en',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Default language for the application'
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'general',
                'description' => 'Enable maintenance mode'
            ],
            [
                'key' => 'user_registration',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'general',
                'description' => 'Allow new user registration'
            ],
            [
                'key' => 'email_verification',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'general',
                'description' => 'Require email verification for new accounts'
            ],

            // School Information
            [
                'key' => 'school_name',
                'value' => 'Tugawe Elementary School',
                'type' => 'string',
                'group' => 'school',
                'description' => 'Official name of the school'
            ],
            [
                'key' => 'school_code',
                'value' => 'TES-2024',
                'type' => 'string',
                'group' => 'school',
                'description' => 'School code identifier'
            ],
            [
                'key' => 'deped_school_id',
                'value' => '',
                'type' => 'string',
                'group' => 'school',
                'description' => 'DepEd assigned school ID'
            ],
            [
                'key' => 'school_address',
                'value' => '',
                'type' => 'string',
                'group' => 'school',
                'description' => 'Complete school address'
            ],
            [
                'key' => 'school_email',
                'value' => '',
                'type' => 'string',
                'group' => 'school',
                'description' => 'School contact email'
            ],
            [
                'key' => 'school_phone',
                'value' => '',
                'type' => 'string',
                'group' => 'school',
                'description' => 'School contact phone number'
            ],

            // Academic Settings
            [
                'key' => 'current_school_year',
                'value' => '2024-2025',
                'type' => 'string',
                'group' => 'academic',
                'description' => 'Current active school year'
            ],
            [
                'key' => 'grading_system',
                'value' => 'quarterly',
                'type' => 'string',
                'group' => 'academic',
                'description' => 'Grading period system'
            ],
            [
                'key' => 'passing_grade',
                'value' => '75',
                'type' => 'integer',
                'group' => 'academic',
                'description' => 'Minimum passing grade percentage'
            ],

            // Notification Settings
            [
                'key' => 'notify_new_student',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'description' => 'Send email on new student enrollment'
            ],
            [
                'key' => 'notify_attendance',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'description' => 'Notify parents of student absences'
            ],
            [
                'key' => 'notify_grades',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'description' => 'Send notification when grades are published'
            ],
            [
                'key' => 'sms_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'notifications',
                'description' => 'Enable SMS notifications'
            ],

            // Security Settings
            [
                'key' => 'min_password_length',
                'value' => '8',
                'type' => 'integer',
                'group' => 'security',
                'description' => 'Minimum required password length'
            ],
            [
                'key' => 'password_expiry',
                'value' => '90',
                'type' => 'integer',
                'group' => 'security',
                'description' => 'Days until password expires (0 = never)'
            ],
            [
                'key' => 'strong_passwords',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'security',
                'description' => 'Require complex passwords'
            ],
            [
                'key' => 'session_timeout',
                'value' => '30',
                'type' => 'integer',
                'group' => 'security',
                'description' => 'Session timeout in minutes'
            ],
            [
                'key' => 'max_login_attempts',
                'value' => '5',
                'type' => 'integer',
                'group' => 'security',
                'description' => 'Maximum failed login attempts'
            ],

            // Appearance Settings
            [
                'key' => 'primary_color',
                'value' => '#6366f1',
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Primary brand color'
            ],
            [
                'key' => 'secondary_color',
                'value' => '#10b981',
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Secondary accent color'
            ],
            [
                'key' => 'dark_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'appearance',
                'description' => 'Enable dark theme'
            ],
            [
                'key' => 'animations',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'appearance',
                'description' => 'Enable UI animations'
            ],

            // Enrollment Settings
            [
                'key' => 'enrollment_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'enrollment',
                'description' => 'Allow students to submit enrollment requests'
            ],

            // Backup Settings
            [
                'key' => 'auto_backup',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'backup',
                'description' => 'Enable automatic daily backups'
            ],
            [
                'key' => 'last_backup',
                'value' => 'Never',
                'type' => 'string',
                'group' => 'backup',
                'description' => 'Last backup timestamp'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        $this->command->info('Settings seeded successfully!');
    }
}