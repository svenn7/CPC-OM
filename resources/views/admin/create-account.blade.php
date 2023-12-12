@extends('admin.layout')

@section('content')

<div class="container dashboard-content px-3 pt-4">
    <div class="back-button">
        <button onclick="window.history.back()" class="back"><i class='fa fa-angle-left'></i></button>
    </div>
    <h2 class="fs-5">Create Account</h2>

    <!-- Create New Violation -->
    <div class="card-body d-flex justify-content-end mb-5">
        <a href="#" class="btn btn-success" title="Add new Violation" onclick="openModal()">
            <i class='fa fa-plus-circle'></i> Promote Student as Officer
        </a>
    </div>

    <!-- Create New Modal -->
    <div class="modal fade" id="createNewViolation" tabindex="-1" role="dialog" aria-labelledby="createNewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNewModalLabel">Promote Student</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('create-account.promoteStudent') }}" method="post">
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
                    <div class="modal-footer">
                        <input type="submit" value="Promote" class="btn btn-success">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" id="msgAlert">
                <ul>
                    <i class='fa fa-exclamation-circle'>{{ $error }}</i>
                </ul>
            </div>
        @endforeach
    @endif

    @if(session('error'))
        <div class="alert alert-danger" id="msgAlert">
            <i class='fa fa-exclamation-circle'></i> {{ session('error') }}
        </div>
    @endif

    @if (session('flash_message'))
        <div class="alert alert-success" id="msgAlert">
            <i class='fa fa-check-circle'>{{ session('flash_message') }}</i>
        </div>
    @endif

    <div class="card">

        <form action="{{ route('create-officer.store') }}" method="post" class="form">
            @csrf
            <div class="title">
                <h2 class="fs-5">Create Officer</h2>
            </div>
            <div class="body row">
                <div class="modal-body col-4">
                    <label for="id_no">ID Number</label><br>
                    <input type="text" name="id_no" id="id_no" class="form-control">
                </div>
                <div class="modal-body col-8">
                    <label for="email">Email Address</label><br>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="modal-body col-4">
                    <label for="fname">First Name</label><br>
                    <input type="text" name="fname" id="fname" class="form-control">
                </div>
                <div class="modal-body col-4">
                    <label for="mname">Middle Name</label><br>
                    <input type="text" name="mname" id="mname" class="form-control">
                </div>
                <div class="modal-body col-4">
                    <label for="lname">Last Name</label><br>
                    <input type="text" name="lname" id="lname" class="form-control">
                </div>
                <div class="modal-body col-3">
                    <label for="gender">Gender</label><br>
                    <select name="gender" id="gender" class="form-control">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="modal-body col-5">
                    <label for="mobile">Mobile No.</label><br>
                    <input type="tel" name="mobile" id="mobile" class="form-control">
                </div>
                <div class="modal-body col-4">
                    <label for="position">Position</label><br>
                    <input type="text" name="position" id="position" class="form-control">
                </div>
                <div class="modal-body col-4">
                    <label for="birthdate">Birthdate</label><br>
                    <input type="date" name="birthdate" id="birthdate" class="form-control">
                </div>
                <div class="modal-body col-8">
                    <label for="address">Address</label><br>
                    <input name="address" id="address" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Add Officer" class="btn btn-success">
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    .form {
        padding: 25px;
    }

    .back-button {
        padding-bottom: 20px;
        outline: none;
        border: none;
    }

    .back {
        font-size: 2rem;
        color: #303030;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .back:hover {
        background: #fff;
        color: #111;
    }

    @media only screen and (max-width: 768px) {
        .form {
            font-size: .8rem;
            padding: 0 10px;
        }

        .form .title {
            padding-top: 10px;
        }
    }
</style>
