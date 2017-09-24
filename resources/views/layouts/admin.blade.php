<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($title))
    <title>{{$title}}</title>
    @else
        <title>Meet Mate APP</title>
        @endif

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{asset('lib/noty.css')}}" rel="stylesheet">
    <script src="{{asset('lib/noty.js')}}" type="text/javascript"></script>

    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/hover_icon.css')}}" rel="stylesheet">
    <link href="{{asset('css/libs.css')}}" rel="stylesheet">

    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    @yield('styles')
    @yield('scripts_header')
</head>
<body >
<div  id="app">
    <init ></init>

@include('layouts.header')



    <div id="wrapper" class="mainCont">
@include('layouts.sidebar')

<div class="w3-main" id="main">
    <div class="w3-main" id="main-sub">
    <div class=" col-xs-7 col-sm-1" id="mainClick">

        <p class="btnShowSidebar" onclick="w3_open()"><span >&#9776;</span></p>
        <p  data-placement="right" data-container="body" data-toggle="users" data-placement="left" data-html="true" href="#"><span data-html="true" data-container="body" data-placement="right" data-toggle="tooltip" title="Users"><i class='fa fa-users' aria-hidden='true'></i></span></p>
        <p  data-placement="right" data-container="body" data-toggle="posts_all" data-placement="left" data-html="true" href="#"><span data-html="true" data-container="body" data-placement="right" data-toggle="tooltip" title="Posts"><i class='fa fa-bookmark' aria-hidden='true'></i></span></p>
        <p data-placement="right" data-container="body" data-toggle="categories" data-placement="left" data-html="true" href="#"><span data-html="true" data-container="body" data-placement="right" data-toggle="tooltip" title="Categories"><i class='fa fa-list' aria-hidden='true'></i></span></p>
        <p><span data-html="true" data-container="body" data-placement="right" data-toggle="tooltip" title="Blog"><a href="{{URL::to('blog ')}}" ><i class='fa fa-book' aria-hidden='true'></i></a></span></p>
        <p ><span data-placement="right" data-container="body" data-toggle="tooltip" title="Messages"><a href="{{URL::to('chat ')}}" ><i class='fa fa-comments' aria-hidden='true'></i></a></span></p>

    </div>

        @include('layouts.tabs')



    <div >
        <notification :id="{{Auth::id()}}"></notification>
        <audio id="noty_audio">
            <source src="{{ asset('audio/notify.mp3') }}">
            <source src="{{ asset('audio/notify.ogg') }}">
            <source src="{{ asset('audio/notify.wav') }}">
        </audio>
        </div>
                @if(isset($chat_user))
            <div id="chatuser" data-chatuser="{{$chat_user->id}}"></div>
            <div id="chatusername" data-chatusername="{{Auth::user()->name}}"></div>
        @endif


</div>
@include('layouts.footer')
</div>

<script src="{{asset('js/libs.js')}}"></script>
    <script>

        var token='{{\Illuminate\Support\Facades\Session::token()}}';
        var url_side_bar='{{ URL::to('show_left_sidebar') }}';
        var user_id='{{ Auth::id() }}';
        $(document).ready(function(){
        $('.btnShowSidebar, #Sidebar>button').on('click',function (event) {

       var active_left_sidebar='{{Auth::user()->setting? Auth::user()->setting->active_left_sidebar :'Y'}}';
             $.ajax({
                 method:'POST',
                 url:url_side_bar,
                 data:{active_left_sidebar:active_left_sidebar,user_id:user_id,_token:token}
             });
        });
        });
    </script>
<script>
    var show_left_sidebar='{{Auth::user()->setting? Auth::user()->setting->active_left_sidebar :'Y'}}';
    if(show_left_sidebar=='Y') {
        $(document).ready(function () {
            if ($(window).width() < 960) {
                w3_close();
            }
            else {
                w3_open();
            }
        });
        $(window).resize(function () {
            if ($(window).width() < 960) {
                w3_close();
            }
            else {
                w3_open();
            }
        });
    }else{
        w3_close();
    }
  document.getElementById("Sidebar").style.width = "20%";
function w3_open() {

  document.getElementById("main").style.marginLeft = "20%";
  document.getElementById("Sidebar").style.width = "20%";
    document.getElementById("mainside").style.marginLeft = "0";
    document.getElementById("footer").style.marginLeft = "0";
  document.getElementById("Sidebar").style.display = "block";
  document.getElementById("mainClick").style.display = "none";

}
function w3_close() {

  document.getElementById("main").style.marginLeft = "0%";
    document.getElementById("mainside").style.marginLeft = "50px";
    document.getElementById("footer").style.marginLeft = "70px";
  document.getElementById("Sidebar").style.display = "none";
  document.getElementById("mainClick").style.display = "inline-block";
}

</script>
<script>
    @if(isset($chat_user))
    var userId='{{$chat_user->id}}';
    @else
    var userId='{{Auth::id()}}';
    @endif
</script>
<script src="{{asset('js/app.js')}}"></script>



</div>
</div>
@yield('scripts')
</body>

</html>
