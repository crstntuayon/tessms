<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

protected function authenticated(Request $request, $user)
{
    $role = $user->role->name;

    switch ($role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'teacher':
            return redirect()->route('teacher.dashboard');
        case 'registrar':
            return redirect()->route('registrar.dashboard');
        case 'student':
            return redirect()->route('student.dashboard'); // <- add this
        default:
            return redirect('/'); // fallback
    }
}



    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Role-based redirection
        switch ($user->role->name) {
            case 'System Admin':
                return redirect()->route('admin.dashboard');
            case 'Registrar':
                return redirect()->route('registrar.dashboard');
            case 'Teacher':
                return redirect()->route('teacher.dashboard');
            case 'Student':
                return redirect()->route('student.dashboard');
            default:
                Auth::logout();
                return redirect('/login')->withErrors([
                    'email' => 'Role not assigned. Contact administrator.',
                ]);
        }
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
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
