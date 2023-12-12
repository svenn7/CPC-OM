@extends('officer.layout')

@section('content')

<div class="container mt-5">
    <h1>Reports</h1>
    <div>Total Reports: {{ $reports->count() }}</div>

    <!-- Create New Violation -->
    <div class="card-body d-flex justify-content-end mb-5">
        <a href="#" class="btn btn-danger" title="Add new Violation" onclick="openModal()">
            <i class='fa fa-plus-circle'></i> Report Student
        </a>
    </div>

    <!-- Create New Modal -->
    <div class="modal fade" id="createNewViolation" tabindex="-1" role="dialog" aria-labelledby="createNewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNewModalLabel">Create Report</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('report.store') }}" method="post" id="reportForm">
                    @csrf
                    <div class="modal-body col-12">
                        <label for="student_id">ID Number</label><br>
                        <input type="text" name="student_id" id="student_id" class="form-control" oninput="fetchStudentName()">
                    </div>
                    <div class="modal-body col-12">
                        <label for="student_name">Students' Name</label><br>
                        <div id="loading-spinner" style="display: none;">
                            Loading Data...
                        </div>
                        <input type="text" name="student_name" id="student_name" class="form-control" disabled>
                    </div>
                    <div class="modal-body col-12">
                        <label for="violation_id">Violation</label><br>
                        <select name="violation_id" id="violation_id" class="form-control">
                            <option value="" disabled selected>Select Violation</option>
                            @foreach($violations as $violation)
                                <option value="{{ $violation->id }}">{{ $violation->violation }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Report" class="btn btn-danger">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('errors'))
        <div class="alert alert-danger" id="msgAlert">
            @foreach(session('errors')->all() as $error)
                <i class='fa fa-exclamation-circle'>{{ $error }}</i>
            @endforeach
        </div>
    @endif

    @if(session('error_message'))
        <div class="alert alert-danger" id="msgAlert">
        <i class='fa fa-exclamation-circle'>{{ session('error_message') }}</i>
        </div>
    @endif

    @if(session('flash_message'))
        <div class="alert alert-success" id="msgAlert">
        <i class='fa fa-check-circle'>{{ session('flash_message') }}</i>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="myDataTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Course, Year & Section</th>
                            <th>Violation</th>
                            <th>Time Issued</th>
                            <th>Date Issued</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->student->id_no }}</td>
                                <td>{{ $report->student->fname }} {{ $report->student->lname }}</td>
                                <td>{{ $report->student->course }} {{ $report->student->year }}-{{ $report->student->section }}</td>
                                <td>{{ $report->violation->violation }}</td>
                                <td>{{ $report->created_at->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($report->created_at)->format('F j, Y') }}</td>
                                <td>
                                    <div class="status-badge @if($report->status == 1) status-approved @elseif($report->status == 0) status-pending @elseif($report->status == 2) status-canceled @else status-unknown @endif">
                                        @if($report->status == 1)
                                            Approved
                                        @elseif($report->status == 0)
                                            Pending
                                            @elseif($report->status == 2)
                                            Canceled
                                        @else
                                            Unknown
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<style>
    .status-badge {
        width: 100px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        font-size: .8rem;
    }

    .status-approved {
        background-color: #28a745;
        color: #fff;
    }

    .status-pending {
        background-color: #6c757d;
        color: #fff;
    }

    .status-canceled {
        background-color: #fe3737;
        color: #fff;
    }

    .status-unknown {
        background-color: #ffc107;
        color: #fff;
    }

    @media only screen and (max-width: 768px) {
        .status-badge {
        width: 55px;
        height: 20px;
        font-size: .6rem;
    }
    }
</style>
