@extends('admin.layout')

@section('content')

<div class="container dashboard-content px-3 pt-4">
    <h1 class="fs-5">Officers</h1>
    <div>Total Officer: {{ $officers->count() }}</div>

    <!-- Create New Violation -->
    <div class="card-body d-flex justify-content-end mb-5">
        <a href="{{ url('/admin/create-account') }}" class="btn btn-success">
            <i class='fa fa-plus-circle'></i> Add New
        </a>
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
        <div class="table-responsive">
            <table id="myDataTable" class="table table-striped table-bordered" style="width:100%">
                <h2 class="fs-5">List of Active Officers</h2>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Email Address</th>
                        <th>Mobile</th>
                        <th>Birthdate</th>
                        <th>Position</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($officers as $officer)
                        <tr>
                            <td>{{ $officer->id_no }}</td>
                            <td>{{ $officer->fname }} {{ $officer->mname }} {{ $officer->lname }}</td>
                            <td>{{ \Carbon\Carbon::parse($officer->birthdate)->age }}</td>
                            <td>{{ $officer->email }}</td>
                            <td>{{ $officer->mobile }}</td>
                            <td>{{ $officer->birthdate }}</td>
                            <td>{{ $officer->position }}</td>
                            <td>{{ $officer->gender }}</td>
                            <td>{{ $officer->address }}</td>
                            <td class="d-flex justify-content-center">
                                <form id="deleteForm_{{ $officer->id }}" method="POST" action="{{ route('officers.destroy', $officer->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger action-button">
                                        <i class='fa fa-trash'></i><span class="d-none d-sm-inline-block">Remove</span>
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

<div class="card mt-5">
    <div class="card-body">
        <div class="table-responsive">
            <table id="myInactiveDataTable" class="table table-striped table-bordered" style="width:100%">
                <h2 class="fs-5">List of Inactive Officers</h2>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Email Address</th>
                        <th>Mobile</th>
                        <th>Birthdate</th>
                        <th>Position</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inactiveOfficers as $inactiveOfficer)
                        <tr>
                            <td>{{ $inactiveOfficer->id_no }}</td>
                            <td>{{ $inactiveOfficer->fname }} {{ $inactiveOfficer->mname }} {{ $inactiveOfficer->lname }}</td>
                            <td>{{ \Carbon\Carbon::parse($inactiveOfficer->birthdate)->age }}</td>
                            <td>{{ $inactiveOfficer->email }}</td>
                            <td>{{ $inactiveOfficer->mobile }}</td>
                            <td>{{ $inactiveOfficer->birthdate }}</td>
                            <td>{{ $inactiveOfficer->position }}</td>
                            <td>{{ $inactiveOfficer->gender }}</td>
                            <td>{{ $inactiveOfficer->address }}</td>
                            <td class="d-flex justify-content-center">
                                <form id="restoreForm_{{ $inactiveOfficer->id }}" method="POST" action="{{ route('officers.restore', $inactiveOfficer->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to restore this officer?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success action-button">
                                        <i class='fa fa-undo'></i><span class="d-none d-sm-inline-block">Restore</span>
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

<style>

</style>
