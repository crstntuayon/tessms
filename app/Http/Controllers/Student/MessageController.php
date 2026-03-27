<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $unreadMessages = Message::where('recipient_id', $student->id)
                                 ->where('is_read', false)
                                 ->count();

        $messages = Message::where('recipient_id', $student->id)->get();

        return view('student.messages.index', compact('messages', 'unreadMessages'));
    }
}