<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

    <link href="{{asset('css/libs.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

</head>

<body>
<header >
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{URL::to('admin ')}}" >Home</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <li><a class="btn btn-warning btn-small" href="{{ url()->previous() }}">Go back</a></li>
                    <li><a class="btn btn-success btn-small" href="{{URL::to('dashboard')}}">Go to Dashboard</a></li>

                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li id="loggedName">
                        <img data-imageid="{{Auth::user()->photo?Auth::user()->photo->id :'0'}}" data-imagepath="{{Auth::user()->photo ? Auth::user()->photo->path :"/images/noimage.png"}}" style="border-radius: 20px;" height="40" src="{{Auth::user()->photo ? Auth::user()->photo->path :"/images/noimage.png"}}" alt="">

                   <span  data-userid="{{Auth::user()->id}}">
                       <a href="{{ URL::to('users/' . Auth::user()->id ) }}">{{ Auth::user()->name }}</a></span>


                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li> <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a></li>

                </ul>


            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>


</header>

<div class="container" style="margin-top: 100px;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#calendar">Home</a></li>
        <li><a data-toggle="tab" href="#settings">Settings</a></li>
    </ul>

    <div class="tab-content">
        <div id="calendar" class="tab-pane fade in active">
            <div class="panel panel-primary">

                <div class="panel-heading">

                    MY Calender

                </div>

                <div class="panel-body" >

                    {!! $calendar->calendar() !!}

                    {!! $calendar->script() !!}

                </div>

            </div>
        </div>
        <div id="settings" class="tab-pane fade">
            <h3>Menu 1</h3>
            <p>Some content in menu 1.</p>
        </div>
    </div>


</div>


</body>

</html>
