<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Pending;
use App\Models\Violation;
use App\Models\Students;
use App\Models\Report;
use App\Models\Message;

class PendingController extends Controller
{
    public function index()
    {
        $violations = Violation::orderBy('created_at', 'desc')->get();
        $reports = Report::with(['student', 'violation'])->where('status', 0)->orderBy('created_at', 'desc')->get();
        $pendingReports = Report::where('status', 0)->count();

        return view('admin.pending', compact('violations', 'reports', 'pendingReports'));
    }

    public function updateStatus(Request $request)
    {
        $reportId = $request->input('report_id');
        $action = $request->input('action');



        $report = Report::find($reportId);
        if (!$report) {
            return redirect()->back()->with('error', 'Report not found');
        }

        $message = Message::create([
            'student_id' => $report->student_id,
            'subject' => 'New Report',
            'message' => 'Violation',
            'type' => 'notification',
        ]);

        $report->status = $action;
        $report->save();

        $statusMessage = ($action == 1) ? 'approved' : 'canceled';

        return redirect()->back()->with('flash_message', 'Report ' . $statusMessage . "!");
    }

    public function updateStatusAll(Request $request)
    {
        $action = $request->input('action');
        $reportIds = $request->input('report_ids');

        Report::whereIn('id', $reportIds)->update(['status' => $action]);

        $statusMessage = ($action == 1) ? 'approved' : 'canceled';

        return redirect()->back()->with('flash_message', 'Reports ' . $statusMessage . '!');
    }

}
