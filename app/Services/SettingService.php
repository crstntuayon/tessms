<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    /**
     * Get all settings for the settings page
     */
    public function getAllSettings(): array
    {
        return Setting::getAll();
    }

    /**
     * Update multiple settings at once
     */
    public function updateSettings(array $data): void
    {
        $settingGroups = [
            'general' => [
                'system_name', 'timezone', 'date_format', 'default_language',
                'maintenance_mode', 'user_registration', 'email_verification'
            ],
            'school' => [
                'school_name', 'school_code', 'deped_school_id', 'school_address',
                'school_email', 'school_phone', 'school_logo'
            ],
            'academic' => [
                'current_school_year', 'school_year_start', 'school_year_end',
                'grading_system', 'passing_grade'
            ],
            'notifications' => [
                'notify_new_student', 'notify_attendance', 'notify_grades',
                'notify_announcements', 'sms_enabled', 'sms_provider'
            ],
            'security' => [
                'min_password_length', 'password_expiry', 'strong_passwords',
                'require_2fa', 'session_timeout', 'max_login_attempts', 'login_notifications'
            ],
            'appearance' => [
                'primary_color', 'secondary_color', 'accent_color',
                'compact_mode', 'dark_mode', 'animations'
            ],
            'backup' => [
                'auto_backup', 'last_backup'
            ],
            'advanced' => [
                'api_enabled', 'api_key'
            ]
        ];

        foreach ($settingGroups as $group => $keys) {
            foreach ($keys as $key) {
                if (array_key_exists($key, $data)) {
                    $this->updateSetting($key, $data[$key], $group);
                }
            }
        }

        // Clear cache after bulk update
        Setting::clearCache();
    }

    /**
     * Update a single setting
     */
    public function updateSetting(string $key, $value, string $group = 'general'): void
    {
        $type = $this->determineType($key, $value);
        
        Setting::set($key, $value, $type, $group);
    }

    /**
     * Handle file upload for settings
     */
    public function handleFileUpload(UploadedFile $file, string $key): string
    {
        // Delete old file if exists
        $oldValue = Setting::get($key);
        if ($oldValue && Storage::disk('public')->exists($oldValue)) {
            Storage::disk('public')->delete($oldValue);
        }

        // Store new file
        $path = $file->store('settings', 'public');
        
        // Update setting
        Setting::set($key, $path, 'string', 'school');

        return $path;
    }

    /**
     * Delete a setting
     */
    public function deleteSetting(string $key): void
    {
        Setting::where('key', $key)->delete();
        Setting::clearCache();
    }

    /**
     * Reset all settings to defaults
     */
    public function resetToDefaults(): void
    {
        Setting::truncate();
        $this->seedDefaultSettings();
        Setting::clearCache();
    }

    /**
     * Seed default settings
     */
    public function seedDefaultSettings(): void
    {
        $defaults = [
            // General
            ['key' => 'system_name', 'value' => 'Tugawe Elementary School', 'type' => 'string', 'group' => 'general'],
            ['key' => 'timezone', 'value' => 'Asia/Manila', 'type' => 'string', 'group' => 'general'],
            ['key' => 'date_format', 'value' => 'F d, Y', 'type' => 'string', 'group' => 'general'],
            ['key' => 'default_language', 'value' => 'en', 'type' => 'string', 'group' => 'general'],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'general'],
            ['key' => 'user_registration', 'value' => '1', 'type' => 'boolean', 'group' => 'general'],
            ['key' => 'email_verification', 'value' => '1', 'type' => 'boolean', 'group' => 'general'],

            // School
            ['key' => 'school_name', 'value' => 'Tugawe Elementary School', 'type' => 'string', 'group' => 'school'],
            ['key' => 'school_code', 'value' => 'TES-2024', 'type' => 'string', 'group' => 'school'],
            ['key' => 'school_address', 'value' => '', 'type' => 'string', 'group' => 'school'],
            ['key' => 'school_email', 'value' => '', 'type' => 'string', 'group' => 'school'],
            ['key' => 'school_phone', 'value' => '', 'type' => 'string', 'group' => 'school'],

            // Academic
            ['key' => 'current_school_year', 'value' => '2024-2025', 'type' => 'string', 'group' => 'academic'],
            ['key' => 'grading_system', 'value' => 'quarterly', 'type' => 'string', 'group' => 'academic'],
            ['key' => 'passing_grade', 'value' => '75', 'type' => 'integer', 'group' => 'academic'],

            // Notifications
            ['key' => 'notify_new_student', 'value' => '1', 'type' => 'boolean', 'group' => 'notifications'],
            ['key' => 'notify_attendance', 'value' => '1', 'type' => 'boolean', 'group' => 'notifications'],
            ['key' => 'notify_grades', 'value' => '1', 'type' => 'boolean', 'group' => 'notifications'],
            ['key' => 'sms_enabled', 'value' => '0', 'type' => 'boolean', 'group' => 'notifications'],

            // Security
            ['key' => 'min_password_length', 'value' => '8', 'type' => 'integer', 'group' => 'security'],
            ['key' => 'password_expiry', 'value' => '90', 'type' => 'integer', 'group' => 'security'],
            ['key' => 'strong_passwords', 'value' => '1', 'type' => 'boolean', 'group' => 'security'],
            ['key' => 'require_2fa', 'value' => '0', 'type' => 'boolean', 'group' => 'security'],
            ['key' => 'session_timeout', 'value' => '30', 'type' => 'integer', 'group' => 'security'],
            ['key' => 'max_login_attempts', 'value' => '5', 'type' => 'integer', 'group' => 'security'],
            ['key' => 'login_notifications', 'value' => '1', 'type' => 'boolean', 'group' => 'security'],

            // Appearance
            ['key' => 'primary_color', 'value' => '#6366f1', 'type' => 'string', 'group' => 'appearance'],
            ['key' => 'secondary_color', 'value' => '#10b981', 'type' => 'string', 'group' => 'appearance'],
            ['key' => 'accent_color', 'value' => '#f59e0b', 'type' => 'string', 'group' => 'appearance'],
            ['key' => 'compact_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'appearance'],
            ['key' => 'dark_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'appearance'],
            ['key' => 'animations', 'value' => '1', 'type' => 'boolean', 'group' => 'appearance'],

            // Backup
            ['key' => 'auto_backup', 'value' => '0', 'type' => 'boolean', 'group' => 'backup'],
            ['key' => 'last_backup', 'value' => 'Never', 'type' => 'string', 'group' => 'backup'],

            // Advanced
            ['key' => 'api_enabled', 'value' => '0', 'type' => 'boolean', 'group' => 'advanced'],
        ];

        foreach ($defaults as $setting) {
            Setting::create($setting);
        }
    }

    /**
     * Determine the type of setting based on key and value
     */
    private function determineType(string $key, $value): string
    {
        // Boolean fields
        $booleans = [
            'maintenance_mode', 'user_registration', 'email_verification',
            'notify_new_student', 'notify_attendance', 'notify_grades', 'notify_announcements',
            'sms_enabled', 'strong_passwords', 'require_2fa', 'login_notifications',
            'compact_mode', 'dark_mode', 'animations', 'auto_backup', 'api_enabled'
        ];

        // Integer fields
        $integers = [
            'passing_grade', 'min_password_length', 'password_expiry',
            'session_timeout', 'max_login_attempts'
        ];

        if (in_array($key, $booleans)) {
            return 'boolean';
        }

        if (in_array($key, $integers)) {
            return 'integer';
        }

        return 'string';
    }

    /**
     * Create database backup
     */
    public function createBackup(): string
    {
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/backups/' . $filename);

        // Ensure backup directory exists
        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Get database credentials from config
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        // Create backup using mysqldump
        $command = sprintf(
            'mysqldump -h %s -u %s -p%s %s > %s',
            escapeshellarg($host),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($path)
        );

        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            Setting::set('last_backup', now()->format('F d, Y h:i A'), 'string', 'backup');
            return $path;
        }

        throw new \Exception('Backup creation failed');
    }

    /**
     * Clear application cache
     */
    public function clearCache(): void
    {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        Setting::clearCache();
    }
}
