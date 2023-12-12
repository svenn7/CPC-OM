@extends('student.layout')

@section('content')

@php
    $student = \App\Models\Students::where('id_no', Auth::user()->id_no)->first();
@endphp

@if($errors->any())
<div class="alert alert-danger" id="msgAlert">
    @foreach($errors->all() as $error)
        <i class='fa fa-exclamation-circle'></i> {{ $error }}<br>
    @endforeach
</div>
@endif

@if(session('flash_message'))
    <div class="alert alert-success" id="msgAlert">
        <i class='fa fa-check-circle'></i> {{ session('flash_message') }}
    </div>
@endif

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="padding: 0; margin-bottom: 20px">
                <img src="http://wallup.net/wp-content/uploads/2016/06/23/383074-New_Zealand-landscape.jpg" alt="Profile Picture" class="card-img-top img">
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card" style="padding-right: 20px">
                <h4>Basic Info</h4>
                <div class="card-body">
                    <p><strong>ID Number:</strong> {{ $student->id_no }}</p>
                    <p><strong>Name:</strong> {{ $student->fname }} {{ substr($student->mname, 0, 1) }}. {{ $student->lname }}</p>
                    <p><strong>Email:</strong> {{ $student->email }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card" style="padding-right: 20px">
                <h4>Change Password</h4>
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

<style>


    .card .img {
        height: 270px;
        width: 100%;
        object-fit: cover;
    }
</style>
