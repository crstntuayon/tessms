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
     * Display the login view.
     */
     public function create(): View
    {
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
     * Handle an incoming authentication request using username.
     */
  public function store(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        // Prevent login if student is not approved
        if ($user->role->name === 'student') {
            $student = $user->student;
            if (!$student || $student->status !== 'active') {
                Auth::logout();
                return redirect()->route('auth.pending')
                    ->withErrors([
                        'login' => 'Your registration is pending admin approval. You cannot log in yet.'
                    ]);
            }
        }

        // Role-based redirect
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
            case 'Student':
            case 'student':
                return redirect()->route('student.dashboard');
            default:
                Auth::logout();
                return redirect('/login')->withErrors([
                    'login' => 'Role not assigned. Contact administrator.',
                ]);
        }
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
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}