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
            <img src="http://wallup.net/wp-content/uploads/2016/06/23/383074-New_Zealand-landscape.jpg" alt="Profile Picture" class="card-img-top image">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <!-- Left row -->
            <div class="image-container">
                <h4>Change Profile Picture</h4>
                <div class="centered-content">
                    <div class="image-wrapper">
                        @if($student->profile_picture)
                            <img class="img" id="profileImage" src="/profile_pictures/{{ $student->profile_picture }}" alt="Profile Picture">
                        @else
                            <img class="img" id="profileImage" src="/profile_pictures/default.jpg" alt="Default Profile Picture">
                        @endif
                        <div class="cancel-wrapper">
                            <button class="cancel-button" onclick="cancelImage()"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="button-container">
                        <form action="{{ route('profile.updateProfilePicture', ['id' => $student->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <label for="upload" class="upload-button"><i class="fa fa-paperclip" aria-hidden="true"></i>Upload Picture</label>
                            <input type="file" id="upload" name="profile_picture" style="display: none;" onchange="loadImage(this)">
                            <input type="submit" value="Save" class="image-button">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card" style="padding-right: 20px; margin-bottom: 20px">
            <h4>Basic Info</h4>
            <div class="card-body">
                <p><strong>ID Number:</strong> {{ $student->id_no }}</p>
                <p><strong>Name:</strong> {{ $student->fname }} {{ substr($student->mname, 0, 1) }}. {{ $student->lname }}</p>
                <p><strong>Email:</strong> {{ $student->email }}</p>
                <p><strong>Mobile:</strong> {{ $student->mobile }}</p>
                <p><strong>Course, Year & Section:</strong> {{ $student->course }} {{ $student->year }}-{{ $student->section }}</p>
                <p><strong>Age:</strong> {{ \Carbon\Carbon::parse($student->birthdate)->age }}</p>
                <p><strong>Gender:</strong> {{ $student->gender }}</p>
                <p><strong>Birthdate:</strong> {{ \Carbon\Carbon::parse($student->birthdate)->format('F j, Y') }}</p>
                <p><strong>Address:</strong> {{ $student->address }}</p>
            </div>
        </div>
        <div class="card" style="padding-top: 20px">
            <h4>Edit Details</h4>
            <!-- Right row -->
            <div class="card-body" style="padding-right: 35px">
                <form action="{{ route('student.update', ['student' => $student->id]) }}" method="post">
                    @csrf
                    @method ('PUT')
                    <div class="row">
                        <div class="form-group">
                            <input type="hidden" name="id_no" id="id_no" class="form-control" value="{{ $student->id_no }}">
                            <input type="hidden" name="email" id="email" class="form-control" value="{{ $student->email }}">
                            <input type="hidden" name="fname" id="fname" class="form-control" value="{{ $student->fname }}">
                            <input type="hidden" name="mname" id="mname" class="form-control" value="{{ $student->mname }}">
                            <input type="hidden" name="lname" id="lname" class="form-control" value="{{ $student->lname }}">
                            <input type="hidden" name="gender" id="gender" class="form-control" value="{{ $student->gender }}">
                            <input type="hidden" name="birthdate" id="birthdate" class="form-control" value="{{ $student->birthdate }}">
                            <input type="hidden" name="course" id="course" class="form-control" value="{{ $student->course }}">
                            <input type="hidden" name="year" id="year" class="form-control" value="{{ $student->year }}">
                            <input type="hidden" name="section" id="section" class="form-control" value="{{ $student->section }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label><br>
                            <input type="email" name="email" id="email" value="{{ $student->email }}" class="form-control" required>
                            <br>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="mobile">Mobile No.</label><br>
                            <input type="tel" name="mobile" id="mobile" value="{{ $student->mobile }}" class="form-control" required>
                            <br>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label><br>
                            <input name="address" id="address" value="{{ $student->address }}" class="form-control" required>
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
</div>

@endsection

<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .centered-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 20% 20px;
    }

    .card .img {
        object-fit: cover;
        display: block;
        height: 200px;
        width: 200px;
        margin-bottom: 20px;
    }

    .card .image {
        height: 270px;
        width: 100%;
        object-fit: cover;
    }

    .button-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .upload-button {
        margin-bottom: 10px;
        padding: 8px 16px;
        background-color: #f38704;
        color: #fff;
        border: none;
        cursor: pointer;
        width: 150px;
        font-size: 15px;
        border-radius: 5px;
    }

    .image-button {
        margin-bottom: 10px;
        padding: 8px 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
        width: 150px;
        font-size: 15px;
        border-radius: 5px;
    }

    .upload-button:hover {
        background-color: #ec9831;
    }

    .image-button:hover {
        background-color: #3d96f5;
    }

    .form-container {
        padding: 20px;
        width: 70%;
    }

    .form-container h5 {
        margin-bottom: 20px;
    }

    .form-container label {
        display: block;
        margin-bottom: 8px;
    }

    .form-container input {
        width: 100%;
        padding: 8px;
        margin-bottom: 12px;
        box-sizing: border-box;
    }

    .form-container button {
        padding: 10px;
        background-color: green;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .cancel-wrapper {
        position: relative;
    }

    .cancel-button {
        position: absolute;
        height: 30px;
        width: 30px;
        top: -225px;
        right: -15px;
        background-color: rgba(236, 236, 236, 0.8);
        color: #333436;
        border: none;
        cursor: pointer;
        padding: 10px;
        border-radius: 50%;
        display: none;
    }


    @media only screen and (max-width: 768px) {
        .card {
            flex-direction: column;
            width: 100%;
        }

        .image-container,
        .form-container {
            width: 100%;
            border-right: none;
        }

        .button-container {
            position: static;
            text-align: center;
            margin-top: 20px;
        }

        .image-button {
            display: block;
            margin-bottom: 10px;
        }
    }
</style>

<!-- Your existing HTML and styles remain unchanged -->

<script>
    function loadImage(input) {
        const file = input.files[0];
        const profileImage = document.getElementById('profileImage');
        const cancelButton = document.querySelector('.cancel-button');
        const uploadInput = document.getElementById('upload');

        if (file && /\.(jpe?g|png)$/i.test(file.name)) {
            const reader = new FileReader();

            reader.onload = function (e) {
                profileImage.src = e.target.result;
                cancelButton.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    }

    function saveImage() {
        console.log('Image saved');
    }

    function cancelImage() {
        const profileImage = document.getElementById('profileImage');
        const cancelButton = document.querySelector('.cancel-button');
        const uploadInput = document.getElementById('upload');

        profileImage.src = '/profile_pictures/{{ $student->profile_picture }}';
        cancelButton.style.display = 'none';
        uploadInput.value = '';
    }
</script>
