@extends('admin.layout')

@section('content')

<div class="container dashboard-content px-3 pt-4">
    <h1 class="fs-5"> Messages</h1>
    <div>Total Messages:  {{ $messages->count() }}</div>

    <div class="card-body d-flex justify-content-end mb-5">
        <a href="#" class="btn btn-success" title="Add new Violation" onclick="openModal()">
            <i class='fa fa-plus-circle'></i> Send Message
        </a>
    </div>

    <!-- Create New Modal -->
    <div class="modal fade" id="createNewViolation" tabindex="-1" role="dialog" aria-labelledby="createNewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNewModalLabel">Create Message</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('messages.sendMessage') }}" method="post" id="reportForm">
                    @csrf
                    <div class="modal-body col-12">
                        <label for="student_id">To</label><br>
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
                        <label for="subject">Subject</label><br>
                        <input type="text" name="subject" id="subject" class="form-control">
                    </div>
                    <div class="modal-body col-12">
                        <label for="message">Message</label><br>
                        <textarea name="message" id="message" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Send Message</button>
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
                            <th>Receiver</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date & Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>{{ $message->id }}</td>
                                <td>{{ $message->student->fname }} {{ substr($message->student->mname, 0, 1) }}. {{ $message->student->lname }}</td>
                                <td>{{ $message->subject }}</td>
                                <td>{{ $message->message }}</td>
                                <td>{{ \Carbon\Carbon::parse($message->created_at)->format('F j, Y') }}, {{ $message->created_at->format('h:i A') }}</td>
                                <td>
                                    <form id="deleteForm_{{ $message->id }}" method="POST" action="{{ route('messages.destroy', $message->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger action-button">
                                            <i class='fa fa-trash'></i><span class="d-none d-sm-inline-block">Delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
