@extends('admin.layout')

@section('content')

<div class="container mt-5">
    <h1 class="fs-5">Violations</h1>
    <div>Total Reports:  {{ $violations->count() }}</div>

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
                    <h5 class="modal-title" id="createNewModalLabel">Create Violation</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('violations.store') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <label for="violation">Violation</label><br>
                        <input type="text" name="violation" id="violation" class="form-control">
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
        <div class="alert alert-danger" id="msgAlert">
            @foreach(session('errors')->all() as $error)
                <i class='fa fa-exclamation-circle'>{{ $error }}</i>
            @endforeach
        </div>
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
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Violation Name</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($violations as $violation)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $violation->violation }}</td>
                    <td class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary action-button" onclick="openEditViolationModal({{ $violation->id }})">
                            <i class='fa fa-edit'></i><span class="d-none d-sm-inline-block">Edit</span>
                        </button>
                        <span>&nbsp;</span>
                        <form id="deleteForm_{{ $violation->id }}" method="POST" action="{{ route('violations.destroy', $violation->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this violation?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger action-button">
                                <i class='fa fa-trash'></i><span class="d-none d-sm-inline-block">Delete</span>
                            </button>
                        </form>
                    </td>
                </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editViolationModal{{ $violation->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Violation</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('violations.update', ['violation' => $violation->id]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="id" value="{{ $violation->id }}">
                                        <label for="violation">Violation</label><br>
                                        <input type="text" name="violation" id="violation" class="form-control" value="{{ $violation->violation }}">
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

@endsection
