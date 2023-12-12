<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Students;
use App\Models\Violation;

class AdminController extends Controller
{
    public function AdminDashboard(){
        $totalReports = Report::All()->count();
        $totalStudents = Students::All()->count();
        $totalViolations = Violation::All()->count();
        $pendingReports = Report::where('status', 0)->count();

        return view('admin.admin_dashboard', compact('totalReports', 'pendingReports', 'totalStudents', 'totalViolations'));
    }

    public function history()
    {
        return view('admin.history');
    }

    public function students()
    {
        return view('admin.students');
    }

    public function violations()
    {
        return view('admin.violations');
    }

    public function pending()
    {
        return view('admin.pending');
    }

    public function messages()
    {
        return view('admin.messages');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function officers()
    {
        return view('admin.officers');
    }

    public function reports()
    {
        return view('admin.report');
    }

    public function createaccount()
    {
        return view('admin.create-account');
    }
}
