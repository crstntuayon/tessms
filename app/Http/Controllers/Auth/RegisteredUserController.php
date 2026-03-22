<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use App\Models\Role;


class RegisteredUserController extends Controller
{

  public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'lrn' => 'required|unique:users,lrn',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'birthday' => 'required|date',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Get the student role
        $studentRole = Role::where('name', 'student')->first();
        if (!$studentRole) {
            return back()->withErrors(['role' => 'Student role not found. Please create it first.']);
        }

        // Create the user
        $user = User::create([
            'lrn' => $request->lrn,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix,
            'birthday' => $request->birthday,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $studentRole->id,
        ]);

        // Fire registered event
        event(new Registered($user));

        // Log in the user
        Auth::guard()->login($user);

        // Redirect to student dashboard
        return redirect()->route('student.dashboard');
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    
}
