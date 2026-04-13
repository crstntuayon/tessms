<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\GradeLevel;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view (for Admin and Teachers).
     */
    public function create(Request $request): View
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

        return view('auth.login', compact('announcements', 'teachers', 'students', 'sections', 'gradeLevels'));
    }
    
    /**
     * Display the student login view.
     */
    public function createStudent(Request $request): View
    {
        // Ensure session is started with a valid CSRF token
        if (!$request->session()->isStarted()) {
            $request->session()->start();
        }
        
        return view('auth.student-login');
    }

    /**
     * Handle an incoming authentication request using username.
     * This is for Admin/Teacher portal.
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

            // BLOCK students from logging in via admin/teacher portal
            if ($user->role->name === 'Student' || $user->role->name === 'student') {
                Auth::logout();
                return redirect()->route('student.login')
                    ->withErrors([
                        'login' => 'Please use the Student Login portal.'
                    ]);
            }

            // Role-based redirect for Admin/Teacher/Registrar
            switch ($user->role->name) {
                case 'System Admin':
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'Registrar':
                case 'registrar':
                    return redirect()->route('registrar.dashboard');
                case 'Teacher':
                case 'teacher':
                    return redirect()->route('teacher.dashboard');
                default:
                    Auth::logout();
                    return redirect('/login')->withErrors([
                        'login' => 'Access denied. This portal is for Staff only.',
                    ]);
            }
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }
    
    /**
     * Handle student login request.
     */
    public function storeStudent(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // BLOCK non-students from logging in via student portal
            if ($user->role->name !== 'Student' && $user->role->name !== 'student') {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors([
                        'login' => 'Please use the Staff Login portal.'
                    ]);
            }

            // Check if student is approved
            $student = $user->student;
            if (!$student || $student->status !== 'active') {
                Auth::logout();
                return redirect()->route('auth.pending')
                    ->withErrors([
                        'login' => 'Your registration is pending admin approval. You cannot log in yet.'
                    ]);
            }

            return redirect()->route('student.dashboard');
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