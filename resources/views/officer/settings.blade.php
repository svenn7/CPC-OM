@extends('officer.layout')

@section('content')

<div class="container dashboard-content px-3 pt-4">
    <h2 class="fs-5"> Settings</h2>
</div>

@php
    $officer = \App\Models\Officers::where('id_no', Auth::user()->id_no)->first();
@endphp

@if(session('errors'))
    <div class="alert alert-danger" id="msgAlert">
        @foreach(session('errors')->all() as $error)
            <i class='fa fa-exclamation-circle'>{{ $error }}</i>
        @endforeach
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" id="msgAlert">
    <i class='fa fa-exclamation-circle'>{{ session('error') }}</i>
    </div>
@endif

@if(session('flash_message'))
    <div class="alert alert-success" id="msgAlert">
    <i class='fa fa-check-circle'>{{ session('flash_message') }}</i>
    </div>
@endif

<div class="container">
    <div class="row">
        <div class="col-lg-7">
            <div class="card" style="padding-right: 20px; margin-top: 30px; margin-bottom: 20px;">
                <h2 class="fs-5" style="padding-top: 20px; padding-left: 20px;">Basic info</h2>
                <div class="card-body" style="padding-left: 20px;">
                    <p><strong>ID Number:</strong> {{ $officer->id_no }}</p>
                    <p><strong>Name:</strong> {{ $officer->fname }} {{ substr($officer->mname, 0, 1) }}. {{ $officer->lname }}</p>
                    <p><strong>Gender:</strong> {{ $officer->gender }}</p>
                    <p><strong>Email:</strong> {{ $officer->email }}</p>
                    <p><strong>Mobile:</strong> {{ $officer->mobile }}</p>
                    <p><strong>Birthdate:</strong> {{ $officer->birthdate }}</p>
                    <p><strong>Address:</strong> {{ $officer->address }}</p>
                </div>
            </div>
            <div class="card" style="padding-top: 20px">
                <h2 class="fs-5" style="padding-top: 20px; padding-left: 20px;">Edit Details</h2>
                <!-- Right row -->
                <div class="card-body" style="padding-right: 35px">
                    <form action="{{ route('settings.update', $officer->id) }}" method="post">
                        @csrf
                        @method ('PUT')
                        <div class="row">
                            <div class="form-group">
                                <input type="hidden" name="id_no" id="id_no" class="form-control" value="{{ $officer->id_no }}">
                                <input type="hidden" name="fname" id="fname" class="form-control" value="{{ $officer->fname }}">
                                <input type="hidden" name="mname" id="mname" class="form-control" value="{{ $officer->mname }}">
                                <input type="hidden" name="lname" id="lname" class="form-control" value="{{ $officer->lname }}">
                                <input type="hidden" name="gender" id="gender" class="form-control" value="{{ $officer->gender }}">
                                <input type="hidden" name="position" id="position" class="form-control" value="{{ $officer->position }}">
                                <input type="hidden" name="birthdate" id="birthdate" class="form-control" value="{{ $officer->birthdate }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label><br>
                                <input type="email" name="email" id="email" value="{{ $officer->email }}" class="form-control" required>
                                <br>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="mobile">Mobile No.</label><br>
                                <input type="tel" name="mobile" id="mobile" value="{{ $officer->mobile }}" class="form-control" required>
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label><br>
                                <input name="address" id="address" value="{{ $officer->address }}" class="form-control" required>
                                <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Update" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card" style="padding-right: 20px; margin-top: 30px;">
                <h2 class="fs-5" style="padding-top: 20px; padding-left: 20px;">Change Password</h2>
                <div class="card-body" style="padding-right: 35px">
                    <form action="{{ route('account.changePassword') }}" method="post" style="padding-bottom: 30px">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="confirm_new_password">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-secondary btn-block">Change Password</button>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
