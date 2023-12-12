@extends('admin.layout')

@section('content')

<div class="container dashboard-content px-3 pt-4">
    <h2 class="fs-5"> Settings</h2>
</div>

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
