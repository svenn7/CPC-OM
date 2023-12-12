@extends('student.layout')

@section('content')

@php
    $student = \App\Models\Students::where('id_no', Auth::user()->id_no)->first();
@endphp

<h1 class="fs-5">
    <br><br>
    @if ($student)
    <i class="fa fa-user" aria-hidden="true"></i>
    Welcome {{ $student->fname }} {{ $student->mname }} {{ $student->lname }}!
    @endif
</h1>

<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <h4>Students Profile</h4>
                <div>
                    @if($student->profile_picture)
                        <img src="/profile_pictures/{{ $student->profile_picture }}" alt="Profile Picture" class="profile-img">
                    @else
                        <img src="/profile_pictures/default.jpg" alt="Default Profile Picture" class="profile-img">
                    @endif
                </div>
                <div class="status-container">
                    <span class="status-badge
                        @if($student->status == 1) status-active
                        @elseif($student->status == 0) status-inactive
                        @else status-unknown
                        @endif">
                        @if($student->status == 1)
                            Active
                        @elseif($student->status == 0)
                            Inactive
                        @else
                            Unknown
                        @endif
                    </span>
                </div>
                <div class="button-wrapper">
                    <a href="{{ url('/student/profile') }}" class="my-button">Edit Profile</a>
                </div>
                <div class="table-responsive info">
                    <table class="table-info">
                        <tr>
                            <td class="a">ID number</td>
                            <td>
                                @if ($student) {{ $student->id_no }} @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="a">First Name</td>
                            <td>
                                @if ($student) {{ $student->fname }} @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="a">Middle Name</td>
                            <td>
                                @if ($student) {{ $student->mname }} @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="a">Last Name</td>
                            <td>
                                @if ($student) {{ $student->lname }} @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="a">Yr. & Sec.</td>
                            <td>
                                @if ($student) {{ $student->course }} {{ $student->year }}-{{ $student->section }} @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="a">Age</td>
                            <td>
                                @if ($student) {{ \Carbon\Carbon::parse($student->birthdate)->age }} @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="a">Email</td>
                            <td>
                                @if ($student) {{ $student->email }} @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="a">Mobile no.</td>
                            <td>
                                @if ($student) {{ $student->mobile }} @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="a">Birth Date</td>
                            <td>
                                @if ($student) {{ \Carbon\Carbon::parse($student->birthdate)->format('F j, Y') }} @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="a">Gender</td>
                            <td>
                                @if ($student) {{ $student->gender }} @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="a">Address</td>
                            <td>
                                @if ($student)  {{ $student->address }} @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <h4>List of Violations</h1>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myDataTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Violation</th>
                                    <th>Officer in Charge</th>
                                    <th>Time Issued</th>
                                    <th>Date Issued</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $report->violation->violation }}</td>
                                        @if ($report->officer)
                                            <td>{{ $report->officer->fname }} {{ $report->officer->lname }} (<i>{{ $report->officer->position }}</i>)</td>
                                        @else
                                            <td>Admin</td>
                                        @endif
                                        <td>{{ $report->created_at->format('h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($report->created_at)->format('F j, Y') }}</td>
                                        <td class="offense-status" style="color: white; background:
                                            @if ($report->offense == 1)
                                                #00c04b
                                            @elseif ($report->offense == 2)
                                                orange
                                            @else
                                                red
                                            @endif;
                                            margin-top: 5px; margin-left: 30px;">
                                            {{ $report->offense }}@if ($report->offense % 10 == 1 && $report->offense != 11){{ 'st' }}
                                            @elseif ($report->offense % 10 == 2 && $report->offense != 12){{ 'nd' }}
                                            @elseif ($report->offense % 10 == 3 && $report->offense != 13){{ 'rd' }}
                                            @else{{ 'th' }}
                                            @endif
                                            Offense
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
