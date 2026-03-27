<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        return view('student.profile.index', compact('student'));
    }

   public function updatePhoto(Request $request)
    {
        $user = auth()->user(); // <-- get the user

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_photos', $filename);

            $user->photo = 'profile_photos/' . $filename; // update the users table
            $user->save();
        }

        return back()->with('success', 'Profile photo updated successfully!');
    }
}