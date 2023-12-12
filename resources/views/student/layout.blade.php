<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('images/cpc.png') }}">
    <title>CPC - Offense Monitoring System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- jquery DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('css/student_style.css') }}">
</head>
<body>
    <input type="checkbox" id="checkbox" checked>
    <header class="header">
        <div class="left-section">
            <h2>
                <img src="{{ asset('images/cpc.png') }}" alt="CPC" class="logo">
                <label for="checkbox" class="toggle-btn">
                    <i id="navbtn" class="fa fa-bars" aria-hidden="true"></i>
                </label>
            </h2>
        </div>
        <div class="right-section">
            <div class="notification_wrap">
                <div class="notification_icon">
                    <i class="fa fa-bell"></i>
                </div>
                <div class="dropdown">
                    @if(count($messages) > 0)
                    @foreach($messages as $message)
                    <div class="notify_item">
                        <div class="notify_img">
                            @if($message->type == 'message')
                                <img src="{{ asset('images/message.jpg') }}" alt="message" style="width: 50px">
                            @elseif($message->type == 'notification')
                                <img src="{{ asset('images/notification.jpeg') }}" alt="notification" style="width: 50px">
                            @endif
                        </div>
                        <div class="notify_info">
                            @if($message->type == 'message')
                                <p>{{ $message->subject }}<a href="#">View Message</a></p>
                            @elseif($message->type == 'notification')
                                <p>{{ $message->subject }}<a href="{{ url('/student/dashboard') }}">View Report</a></p>
                            @endif
                            <span class="notify_time">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach

                    @else
                        <p class="text-center">No Notification..</p>
                    @endif
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <i onclick="event.preventDefault(); this.closest('form').submit();" class="fa fa-power-off" aria-hidden="true"></i>
            </form>
        </div>
    </header>
    <div class="body">
        <nav class="side-bar custom-sidebar">
            <div class="user-p">
                @if($student->profile_picture)
                <img src="/profile_pictures/{{ $student->profile_picture }}" alt="Profile Picture">
                @else
                    <img src="/profile_pictures/default.jpg" alt="Default Profile Picture">
                @endif
                <h4>
                    @if ($student)
                        {{ $student->fname }} {{ substr($student->mname, 0, 1) }}. {{ $student->lname }}
                    @endif
                </h4>
            </div>
            <ul>
                <li>
                    <a href="{{ url('/student/home') }}">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/student/dashboard') }}">
                        <i class="fa fa-desktop" aria-hidden="true"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/student/account') }}">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        <span>My Account</span>
                    </a>
                </li>
            </ul>
        </nav>

        <section class="section-1">
            @yield('content')
        </section>
    </div>
</body>

<!-- bootstrap script-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- jquery script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Jquery DataTables -->

<!-- DataTables bootstrap-->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

</html>


<script>
    //notification
    $(document).ready(function(){
        $(".notification_icon .fa-bell").click(function(e){
            e.stopPropagation();

            if ($("#checkbox").is(":checked")) {
                $(".dropdown").toggleClass("active");
            }
        });

        $(document).mouseup(function(e){
            var container = $(".notification_wrap");

            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $(".dropdown").removeClass("active");
            }
        });

        $('#checkbox').change(function() {
        if ($(this).is(':checked')) {
            $(".dropdown").removeClass("active");
        }
    });
    });

    //tables
    $(document).ready(function() {
        $('#myDataTable').DataTable({
        paging: false,
        searching: true,
        ordering: false,
        info: false,
        lengthChange: false,
    });
    });

    //Errors
    $(document).ready(function () {
        $('#msgAlert').delay(2000).fadeOut(500);
    });
</script>

<style>
    .notification_wrap .notification_icon{
        width: 50px;
        height: 50px;
        font-size: 24px;
        margin: 0 auto;
    }

    .notification_wrap .dropdown{
        width: 350px;
        max-height: 400px;
        background: #fff;
        border-radius: 5px;
        margin: 15px auto 0;
        padding: 15px;
        position: absolute;
        display: none;
        right: 45px;
        z-index: 999;
        overflow-y: auto;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .notification_wrap .dropdown .notify_item{
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #dbdaff;
        cursor: pointer;
    }

    .notification_wrap .dropdown .notify_item:last-child{
        border-bottom: 0px;
    }

    .notification_wrap .dropdown .notify_item .notify_img{
        margin-right: 15px;
    }

    .notification_wrap .dropdown .notify_item a {
        text-decoration: none;
        color: #222;
    }

    .notification_wrap .dropdown .notify_item .notify_info p{
        margin-bottom: 5px;
    }

    .notification_wrap .dropdown .notify_item .notify_info p a{
        color: #605dff;
        margin-left: 5px;
    }

    .notification_wrap .dropdown .notify_item .notify_info p a:hover{
        color: #302dcf;
    }

    .notification_wrap .dropdown .notify_item .notify_info .notify_time{
        color: #c5c5e6;
        font-size: 12px;
    }

    .notification_wrap .dropdown:before{
        content: "";
        position: absolute;
        top: -30px;
        right: 0;
        transform: translateX(-50%);
        border: 15px solid;
        border-color: transparent transparent #fff transparent;
    }

    .notification_wrap .dropdown.active{
        display: block;
    }

    @media only screen and (max-width: 768px) {
        .notification_wrap .dropdown{
        width: 300px;
        }
    }
</style>
