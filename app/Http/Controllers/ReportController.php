<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Violation;
use App\Models\Students;
use App\Models\Message;

class ReportController extends Controller
{


    public function index()
    {
        if (Auth::check()) {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $violations = Violation::where('status', 1)->orderBy('created_at', 'desc')->get();
                $reports = Report::with(['student', 'violation'])->orderBy('created_at', 'desc')->get();


                return view('admin.report', compact('violations', 'reports'));
            } elseif ($user->role === 'officer') {
                $violations = Violation::where('status', 1)->orderBy('created_at', 'desc')->get();
                $reports = Report::with(['student', 'violation', 'officer'])
                    ->where('officer_id', $user->officer_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                return view('officer.report', compact('violations', 'reports'));
            } elseif ($user->role === 'student') {

                $violations = Violation::where('status', 1)->orderBy('updated_at', 'desc')->get();

                $reports = Report::with(['student', 'violation', 'officer'])
                    ->where('status', '1')
                    ->where('student_id', $user->stud_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $messages = Message::with(['student'])
                    ->where('status', 1)
                    ->where('student_id', $user->stud_id)
                    ->orderBy('updated_at', 'desc')
                    ->get();

                return view('student.dashboard', compact('violations', 'reports', 'messages'));
            }
        }
    }

    public function violationReports()
    {
        $reports = Report::with(['student', 'violation'])->where('status', 1)>orderBy('created_at', 'desc')->get();

        return view('admin.report')->with('reports', $reports);
    }

    public function getStudentName($idNo)
    {
        $student = Students::where('id_no', $idNo)
                    ->where('status', 1)
                    ->first();

        return $student ? $student->fname . ' ' . $student->lname : 'Student not found';
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id_no',
            'violation_id' => 'required|exists:violations,id',
        ]);

        $student = Students::where('id_no', $request->input('student_id'))->firstOrFail();

        if ($student->status == 0) {
            return redirect()->back()->with('error_message', 'Cannot add report because the student account is inactive.');
        }

        $user = auth()->user();

        if (!$user || $user->status == 0) {
            return redirect()->back()->with('error_message', 'Cannot add report because the account is inactive.');
        }

        $officerId = optional($user)->officer_id;

        $maxOffense = Report::where('student_id', $student->id)->max('offense');

        $offense = $maxOffense + 1;

        $report = Report::create([
            'student_id' => $student->id,
            'violation_id' => $request->input('violation_id'),
            'officer_id' => $officerId,
            'offense' => $offense,
        ]);

        return redirect()->back()->with('flash_message', 'Report Successfully Added!');
    }

    public function clearNotif(){
        $notif = Message::where('status', 1)->get();

        foreach($notif as $not){
            $not->status = 0;

            $not->save();
        }

        return redirect()->back();
    }

}
