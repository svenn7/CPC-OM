<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Report;

class OfficerController extends Controller
{
    public function OfficerDashboard(){
        $user = auth()->user();

        $reports = Report::with(['student', 'violation', 'officer'])
            ->where('officer_id', $user->officer_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('officer.officer_dashboard', compact('reports'));
    }

    public function history()
    {
        return view('officer.history');
    }

    public function settings()
    {
        return view('officer.settings');
    }

    public function report()
    {
        return view('officer.report');
    }
}
