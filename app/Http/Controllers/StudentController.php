<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Message;

class StudentController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function StudentDashboard()
    {
        return view('student.dashboard');
    }

    public function account()
    {
        if (Auth::check()) {
            $user = auth()->user();

            $messages = Message::with(['student'])
                ->where('status', 1)
                ->where('student_id', $user->stud_id)
                ->orderBy('updated_at', 'desc')
                ->get();

            return view('student.account')->with('messages', $messages);
        }
    }

    public function profile()
    {
        if (Auth::check()) {
            $user = auth()->user();

            $messages = Message::with(['student'])
                ->where('status', 1)
                ->where('student_id', $user->stud_id)
                ->orderBy('updated_at', 'desc')
                ->get();

            return view('student.profile')->with('messages', $messages);
        }
    }

    public function home()
    {
        if (Auth::check()) {
            $user = auth()->user();

            $messages = Message::with(['student'])
                ->where('status', 1)
                ->where('student_id', $user->stud_id)
                ->orderBy('updated_at', 'desc')
                ->get();

            return view('student.home')->with('messages', $messages);
        }
    }
}
