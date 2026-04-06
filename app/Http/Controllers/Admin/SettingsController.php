<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    protected function middleware($middleware)
    {
        return $this->middleware($middleware);
    }

    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = $this->settingService->getAllSettings();
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        try {
            $data = $request->except(['_token', '_method']);

            // Handle file upload
            if ($request->hasFile('school_logo')) {
                $path = $this->settingService->handleFileUpload(
                    $request->file('school_logo'), 
                    'school_logo'
                );
                $data['school_logo'] = $path;
            }

            $this->settingService->updateSettings($data);

            return redirect()
                ->route('admin.settings.index')
                ->with('success', 'Settings updated successfully!');

        } catch (\Exception $e) {
            Log::error('Settings update failed: ' . $e->getMessage());
            
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    /**
     * Create database backup
     */
    public function backup()
    {
        try {
            $path = $this->settingService->createBackup();
            
            return response()->download($path)->deleteFileAfterSend();
            
        } catch (\Exception $e) {
            Log::error('Backup failed: ' . $e->getMessage());
            
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Backup creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Clear application cache
     */
    public function clearCache()
    {
        try {
            $this->settingService->clearCache();
            
            return redirect()
                ->route('admin.settings.index')
                ->with('success', 'Cache cleared successfully!');
                
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    /**
     * Toggle enrollment submissions on/off
     */
    public function toggleEnrollment(Request $request)
    {
        try {
            $value = $request->input('enrollment_enabled', '0');
            // Handle both string '1'/'0' and boolean values
            $enabled = $value === '1' || $value === true || $value === 1;
            
            \App\Models\Setting::set(
                'enrollment_enabled', 
                $enabled, 
                'boolean', 
                'enrollment'
            );
            
            $status = $enabled ? 'enabled' : 'disabled';
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Enrollment submissions {$status}!",
                    'enabled' => $enabled
                ]);
            }
            
            return redirect()
                ->back()
                ->with('success', "Enrollment submissions {$status}!");
                
        } catch (\Exception $e) {
            \Log::error('Enrollment toggle failed: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to toggle enrollment: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()
                ->back()
                ->with('error', 'Failed to toggle enrollment: ' . $e->getMessage());
        }
    }

    /**
     * Reset settings to defaults
     */
    public function reset()
    {
        try {
            if (!request()->confirm_reset) {
                return redirect()
                    ->route('admin.settings.index')
                    ->with('error', 'Please confirm settings reset');
            }

            $this->settingService->resetToDefaults();
            
            return redirect()
                ->route('admin.settings.index')
                ->with('success', 'Settings reset to default values!');
                
        } catch (\Exception $e) {
            Log::error('Settings reset failed: ' . $e->getMessage());
            
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Failed to reset settings: ' . $e->getMessage());
        }
    }

    /**
     * Export data
     */
    public function export(string $type)
    {
        $allowedTypes = ['students', 'teachers', 'grades', 'attendance'];
        
        if (!in_array($type, $allowedTypes)) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Invalid export type');
        }

        // Implement export logic based on type
        // This is a placeholder - implement actual export logic
        $filename = $type . '_' . date('Y-m-d') . '.csv';
        
        return response()->json([
            'message' => "Export {$type} functionality to be implemented",
            'filename' => $filename
        ]);
    }

    /**
     * Regenerate API key
     */
    public function regenerateApiKey()
    {
        try {
            $newKey = bin2hex(random_bytes(32));
            
            $this->settingService->updateSetting('api_key', $newKey, 'advanced');
            
            return response()->json([
                'success' => true,
                'api_key' => $newKey
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}