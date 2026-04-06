<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Upload student documents (birth certificate, report card, etc.)
     */
    public function uploadDocument(Request $request, $type)
    {
        $student = Auth::user()->student;

        // Validate document type
        $validTypes = ['birth_certificate', 'report_card', 'good_moral', 'transfer_credential'];
        if (!in_array($type, $validTypes)) {
            return back()->with('error', 'Invalid document type.');
        }

        // Validate file
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = $type . '_' . time() . '_' . $student->id . '.' . $file->getClientOriginalExtension();
            
            // Get column name
            $column = $type . '_path';
            
            // Delete old file if exists
            $oldPath = $student->$column;
            if (!empty($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            
            // Store in student-documents folder (public disk)
            $path = $file->storeAs('student-documents/' . $student->id, $filename, 'public');
            
            // Update the corresponding column in students table
            $student->$column = $path;
            $student->save();

            // Update registration status if all required documents are uploaded
            $this->checkAndUpdateRegistrationStatus($student);

            return back()->with('success', ucwords(str_replace('_', ' ', $type)) . ' uploaded successfully!');
        }

        return back()->with('error', 'Failed to upload document.');
    }

    /**
     * Check if all required documents are uploaded and update status
     */
    private function checkAndUpdateRegistrationStatus($student)
    {
        $requiredDocs = ['birth_certificate_path', 'report_card_path', 'good_moral_path'];
        $allUploaded = true;

        foreach ($requiredDocs as $doc) {
            if (empty($student->$doc)) {
                $allUploaded = false;
                break;
            }
        }

        if ($allUploaded && $student->registration_status === 'pending_documents') {
            $student->registration_status = 'documents_complete';
            $student->save();
        }
    }

    /**
     * View uploaded document securely
     */
    public function viewDocument($type)
    {
        $student = Auth::user()->student;
        
        // Validate document type
        $validTypes = ['birth_certificate', 'report_card', 'good_moral', 'transfer_credential'];
        if (!in_array($type, $validTypes)) {
            abort(404, 'Invalid document type.');
        }
        
        $column = $type . '_path';
        $filePath = $student->$column;
        
        if (empty($filePath)) {
            abort(404, 'Document not found.');
        }
        
        // Check all possible paths (public disk, private disk, etc.)
        $possiblePaths = [
            storage_path('app/public/' . $filePath),
            storage_path('app/' . $filePath),
            public_path('storage/' . $filePath),
            storage_path('app/private/public/' . $filePath), // Legacy path for old uploads
            storage_path('app/private/' . $filePath), // Alternative private path
        ];
        
        $fullPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $fullPath = $path;
                break;
            }
        }
        
        if (!$fullPath) {
            abort(404, 'File not found on server.');
        }
        
        $mimeType = mime_content_type($fullPath);
        $fileName = basename($filePath);
        
        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);
    }
}