<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/welcome_style.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-5/css/bootstrap.min.css') }}">
    <title>CPC - Offense Monitoring System</title>
</head>
<body>

    <div class="wrapper">

        @if ($errors->any())
            <div class="custom-error-box" id="msgAlert">
                @foreach ($errors->all() as $error)
                    <p class="error-message">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <div class="text">
                        <h1>STUDENT OFFENSE MONITORING</h1>
                    </div>
                </div>

                <div class="col-md-6 right">
                    <div class="input-box">

                        <div class="logo-container">
                            <div class="logo-left">
                                <img src="{{ asset('images/cpc.png') }}" alt="Logo 1">
                            </div>
                            <h1>Cordova Public College</h1>
                            <div class="logo-right">
                                <img src="{{ asset('images/cordova.jfif') }}" alt="Logo 2">
                            </div>
                        </div>

                        <header>Login account</header>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-field">
                                <input type="text" class="input" name="id_no" value="{{ old('id_no') }}" required autocomplete="off">
                                <label for="id_no">ID number</label>
                            </div>
                            <div class="input-field">
                                <input type="password" class="input" name="password" required>
                                <label for="pass">Password</label>
                            </div>
                            <div class="input-field">
                                <input type="submit" class="submit" value="Login">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</html>

<script>
    //Errors
    $(document).ready(function () {
        $('#msgAlert').delay(2000).fadeOut(500);
    });
</script>
