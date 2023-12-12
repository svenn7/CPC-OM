@extends('admin.layout')

@section('content')

<div class="container mt-5">
    <h1 class="fs-5">Students</h1>
    <div>Total Students:  {{ $students->count() }}</div>

    <!-- Create New Violation -->
    <div class="card-body d-flex justify-content-end mb-5">
        <a href="#" class="btn btn-success" title="Add new Violation" onclick="openModal()">
            <i class='fa fa-plus-circle'></i> Add New
        </a>
    </div>

    <!-- Create New Modal -->
    <div class="modal fade" id="createNewViolation" tabindex="-1" role="dialog" aria-labelledby="createNewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNewModalLabel">Add Student</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('student.store') }}" method="post">
                    @csrf
                    <div class="modal-body row">
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
                        <div class="modal-body col-6">
                            <label for="mobile">Mobile No.</label><br>
                            <input type="tel" name="mobile" id="mobile" class="form-control">
                        </div>

                        <div class="modal-body col-6">
                            <label for="birthdate">Birthdate</label><br>
                            <input type="date" name="birthdate" id="birthdate" class="form-control">
                        </div>
                        <div class="modal-body col-4">
                            <label for="course">Course</label><br>
                            <select name="course" id="course" class="form-control">
                                <option value="" disabled selected>Select a course</option>
                                <option value="BSIT">BSIT</option>
                                <option value="BSHM">BSHM</option>
                                <option value="BSED">BSED</option>
                                <option value="BEED">BEED</option>
                            </select>
                        </div>
                        <div class="modal-body col-4">
                            <label for="year">Year Level</label><br>

                            <select name="year" id="year" class="form-control">
                                <option value="" disabled selected>Select year</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="modal-body col-4">
                            <label for="section">Section</label><br>
                            <select name="section" id="section" class="form-control">
                                <option value="" disabled selected>Select Section</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                        </div>
                        <div class="modal-body col-12">
                            <label for="address">Address</label><br>
                            <input name="address" id="address" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Add" class="btn btn-success">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@if(session('errors'))
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" id="msgAlert">
            <i class='fa fa-exclamation-circle'></i>{{ $error }}
        </div>
    @endforeach
@endif

@if(session('error_message'))
    <div class="alert alert-danger" id="msgAlert">
        <i class='fa fa-exclamation-circle'></i> {{ session('error_message') }}
    </div>
@endif

@if(session('flash_message'))
    <div class="alert alert-success" id="msgAlert">
        <i class='fa fa-check-circle'>{{ session('flash_message') }}</i>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: auto;">
            <table id="myDataTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Course, Yr & Sec</th>
                        <th>Age</th>
                        <th>Email Address</th>
                        <th>Mobile</th>
                        <th>Birthdate</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id_no }}</td>
                        <td>{{ $student->fname }} {{ $student->lname }}</td>
                        <td>{{ $student->course }} {{ $student->year }}-{{ $student->section }}</td>
                        <td>{{ \Carbon\Carbon::parse($student->birthdate)->age }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->mobile }}</td>
                        <td>{{ \Carbon\Carbon::parse($student->birthdate)->format('F j, Y') }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->address }}</td>
                        <td class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary action-button" onclick="openEditStudentModal({{ $student->id }})">
                                <i class='fa fa-edit'></i><span class="d-none d-sm-inline-block">Edit</span>
                            </button>
                            <span>&nbsp;</span>
                            <form id="deleteForm_{{ $student->id }}" method="POST" action="{{ route('students.destroy', $student->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger action-button">
                                    <i class='fa fa-trash'></i><span class="d-none d-sm-inline-block">Delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('student.update', ['student' => $student->id]) }}" method="post">
                                    @csrf
                                    @method ('PUT')
                                    <div class="modal-body row">
                                        <div class="modal-body col-4">
                                            <input type="hidden" name="id" id="id" value="{{ $student->id }}">
                                            <label for="id_no">ID Number</label><br>
                                            <input type="text" name="id_no" id="id_no" class="form-control" value="{{ $student->id_no }}">
                                        </div>
                                        <div class="modal-body col-8">
                                            <label for="email">Email Address</label><br>
                                            <input type="email" name="email" id="email" class="form-control" value="{{ $student->email }}">
                                        </div>
                                        <div class="modal-body col-4">
                                            <label for="fname">First Name</label><br>
                                            <input type="text" name="fname" id="fname" class="form-control" value="{{ $student->fname }}">
                                        </div>
                                        <div class="modal-body col-4">
                                            <label for="mname">Middle Name</label><br>
                                            <input type="text" name="mname" id="mname" class="form-control" value="{{ $student->mname }}">
                                        </div>
                                        <div class="modal-body col-4">
                                            <label for="lname">Last Name</label><br>
                                            <input type="text" name="lname" id="lname" class="form-control" value="{{ $student->lname }}">
                                        </div>
                                        <div class="modal-body col-3">
                                            <label for="gender">Gender</label><br>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="male" @if($student->gender == 'male') selected @endif>Male</option>
                                                <option value="female" @if($student->gender == 'female') selected @endif>Female</option>
                                            </select>
                                        </div>
                                        <div class="modal-body col-6">
                                            <label for="mobile">Mobile No.</label><br>
                                            <input type="tel" name="mobile" id="mobile" class="form-control" value="{{ $student->mobile }}">
                                        </div>

                                        <div class="modal-body col-6">
                                            <label for="birthdate">Birthdate</label><br>
                                            <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{ $student->birthdate }}">
                                        </div>
                                        <div class="modal-body col-4">
                                            <label for="course">Course</label><br>
                                            <select name="course" id="course" class="form-control">
                                                <option value="BSIT" @if($student->course == 'BSIT') selected @endif>BSIT</option>
                                                <option value="BSHM" @if($student->course == 'BSHM') selected @endif>BSHM</option>
                                                <option value="BSED" @if($student->course == 'BSED') selected @endif>BSED</option>
                                                <option value="BEED" @if($student->course == 'BEED') selected @endif>BEED</option>
                                            </select>
                                        </div>
                                        <div class="modal-body col-4">
                                            <label for="year">Year Level</label><br>
                                            <select name="year" id="year" class="form-control">
                                                <option value="1" @if($student->year == '1') selected @endif>1</option>
                                                <option value="2" @if($student->year == '2') selected @endif>2</option>
                                                <option value="3" @if($student->year == '3') selected @endif>3</option>
                                                <option value="4" @if($student->year == '4') selected @endif>4</option>
                                            </select>
                                        </div>
                                        <div class="modal-body col-4">
                                            <label for="section">Section</label><br>
                                            <select name="section" id="section" class="form-control">
                                                <option value="A" @if($student->section == 'A') selected @endif>A</option>
                                                <option value="B" @if($student->section == 'B') selected @endif>B</option>
                                                <option value="C" @if($student->section == 'C') selected @endif>C</option>
                                                <option value="D" @if($student->section == 'D') selected @endif>D</option>
                                                <option value="E" @if($student->section == 'E') selected @endif>E</option>
                                            </select>
                                        </div>
                                        <div class="modal-body col-12">
                                            <label for="address">Address</label><br>
                                            <input name="address" id="address" class="form-control" value="{{ $student->address }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="Save Changes" class="btn btn-primary">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="container mt-5">
    <form action="" method="post" enctype="multipart/form-data">
        <label for="excel_file">Upload Excel file:</label>
        <input type="file" name="excel_file" accept=".xlsx, .xls">
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
</div>

@endsection
