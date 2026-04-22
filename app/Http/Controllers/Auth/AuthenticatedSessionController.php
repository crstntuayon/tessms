<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\GradeLevel;
use App\Services\SettingsEnforcer;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view (for Admin and Teachers).
     */
    public function create(Request $request): \Illuminate\Http\Response
    {
        // Ensure session is started with a valid CSRF token
        if (!$request->session()->isStarted()) {
            $request->session()->start();
        }
        
        $announcements = \App\Models\Announcement::latest()->take(6)->get();
        $teachers = \App\Models\Teacher::all();
        $students = \App\Models\Student::whereHas('enrollments', function($q) {
            $q->where('status', 'enrolled');
        })->get();
        $sections = \App\Models\Section::whereHas('schoolYear', function($q) {
            $q->where('is_active', true);
        })->get();
        $gradeLevels = GradeLevel::all();

        $response = response()->view('auth.login', compact('announcements', 'teachers', 'students', 'sections', 'gradeLevels'));
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        return $response;
    }
    
    /**
     * Handle an incoming authentication request using username.
     * Handles all roles: Admin, Teacher, Registrar, and Student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Check password expiry
            if (SettingsEnforcer::isPasswordExpired($user)) {
                Auth::logout();
                return redirect()->route('password.expired');
            }

            $roleName = strtolower($user->role?->name ?? '');
            $displayRole = $user->role?->name ?? 'User';

            // Check if student is approved/active
            if ($roleName === 'student') {
                $student = $user->student;
                if (!$student || $student->status !== 'active') {
                    Auth::logout();
                    return redirect()->route('auth.pending')
                        ->withErrors([
                            'login' => 'Your registration is pending admin approval. You cannot log in yet.'
                        ]);
                }

                session()->flash('signing_in_role', $displayRole);
                session()->flash('signing_in_redirect', route('student.dashboard'));
                return redirect()->route('auth.signing-in');
            }

            // Role-based redirect for Admin/Teacher/Registrar
            $redirectUrl = match ($roleName) {
                'system admin', 'admin' => route('admin.dashboard'),
                'registrar' => route('registrar.dashboard'),
                'teacher' => route('teacher.dashboard'),
                default => null,
            };

            if (!$redirectUrl) {
                return redirect()->route('login')->withErrors([
                    'login' => 'Access denied. Unrecognized user role.',
                ]);
            }

            session()->flash('signing_in_role', $displayRole);
            session()->flash('signing_in_redirect', $redirectUrl);
            return redirect()->route('auth.signing-in');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        
        // Regenerate session ID but keep session data to avoid 419 errors
        $request->session()->regenerate(true);
        
        // Flash message for successful logout
        return redirect('/')->with('status', 'You have been logged out successfully.');
    }
}