<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Meet Mate App</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Styles -->
        <style>



            .homepage-hero-module {
                border-right: none;
                border-left: none;
                position: relative;
            }
            .no-video .video-container video,
            .touch .video-container video {
                display: none;
            }
            .no-video .video-container .poster,
            .touch .video-container .poster {
                display: block !important;
            }
            .video-container {
                position: relative;
                bottom: 0%;
                left: 0%;
                height: 100%;
                width: 100%;
                overflow: hidden;
                background: #000;
            }
            .video-container .poster img {
                width: 100%;
                bottom: 0;
                position: absolute;
            }
            .video-container .filter {
                z-index: 100;
                position: absolute;
                background: rgba(0, 0, 0, 0.4);
                width: 100%;
            }
            .video-container .title-container {
                z-index: 1000;
                position: absolute;
                top: 15%;
                width: 100%;
                text-align: center;
                color: #fff;
            }
            .video-container .description .inner {

                width: 45%;
                margin: 0 auto;
            }
            .video-container .link {
                position: absolute;
                bottom: 3em;
                width: 100%;
                text-align: center;
                z-index: 1001;
                color: #fff;
            }
            .video-container .link a {
                color: #fff;
            }
            .video-container video {
                position: absolute;
                z-index: 0;
                bottom: 0;
            }
            .video-container video.fillWidth {
                width: 100%;
            }
            html, body {
                background-repeat: no-repeat;
                background-size: 100% 100%;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 84px;
            }
            a {
                color: white;
                padding: 0 25px;
                font-size: 55px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 200px;
            }
        </style>

    </head>
    <body>
        <div class="homepage-hero-module">
            <div class="video-container">
                <div class="title-container">
                    <div class="flex-center position-ref full-height">
                        <div class="content">
                            <div class="title m-b-md">
                                 <p><img style=""  height="150" src="/images/includes/logo_white.png" alt=""></p>
                                @if (Route::has('login'))
                                    @if (Auth::check())
                                        <a href="{{ url('/home') }}">Home</a>
                                    @else
                                        <a href="{{ url('/login') }}">Login</a>
                                        <a href="{{ url('/register') }}">Register</a>
                                    @endif
                                @endif
                                <p style="font-size: 30px;">
                                    Developed by Maksim Narushevich
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter"></div>
                <video autoplay loop class="fillWidth">
                    <source src="../video/Sunset-Lapse.mp4" type="video/mp4" />Your browser does not support the video tag. I suggest you upgrade your browser.</video>
                <div class="poster hidden">
                    <img src="http://www.videojs.com/img/poster.jpg" alt="">
                </div>
            </div>
        </div>
        <script>

            $( document ).ready(function() {

                // Resive video
                scaleVideoContainer();

                initBannerVideoSize('.video-container .poster img');
                initBannerVideoSize('.video-container .filter');
                initBannerVideoSize('.video-container video');

                $(window).on('resize', function() {
                    scaleVideoContainer();
                    scaleBannerVideoSize('.video-container .poster img');
                    scaleBannerVideoSize('.video-container .filter');
                    scaleBannerVideoSize('.video-container video');
                });

            });

            /** Reusable Functions **/
            /********************************************************************/

            function scaleVideoContainer() {

                var height = $(window).height();
                var unitHeight = parseInt(height) + 'px';
                $('.homepage-hero-module').css('height',unitHeight);

            }

            function initBannerVideoSize(element){

                $(element).each(function(){
                    $(this).data('height', $(this).height());
                    $(this).data('width', $(this).width());
                });

                scaleBannerVideoSize(element);

            }

            function scaleBannerVideoSize(element){

                var windowWidth = $(window).width(),
                        windowHeight = $(window).height(),
                        videoWidth,
                        videoHeight;


                $(element).each(function(){
                    var videoAspectRatio = $(this).data('height')/$(this).data('width'),
                            windowAspectRatio = windowHeight/windowWidth;

                    if (videoAspectRatio > windowAspectRatio) {
                        videoWidth = windowWidth;
                    $(this).css('width','100%');
                    } else {
                        videoHeight = windowHeight;
                        $(this).css('width','100%');
                    }

                    $(this).width(videoWidth).height(videoHeight);

                    $('.homepage-hero-module .video-container video').addClass('fadeIn animated');


                });
            }
        </script>
    </body>
</html>
