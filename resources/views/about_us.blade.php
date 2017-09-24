@extends('layouts.admin')
@section ('scripts_header')
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<style>
    .body_about{
             
                color: black;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                text-align: center;
               

            }
</style>
@endsection
@section('General')
    
    <div class="body_about">
      <h1 style="font-size: 45px;">ABOUT APPLICATION</h1>
               <p style="font-size: 25px;font-weight:300;">
                        <strong>Meet Mate APP</strong> is web application that allows you to be connected with your friends no matter where currently you are.
                    </p>
                       <p style="font-size: 25px;font-weight:300;">
                        Here you can find new friends, send messages to them and communicate in real time.  You can also invite them to your community and discuss there your future travel trip or maybe some remarkable event in your life.
                    </p>
                       <p style="font-size: 25px;font-weight:300;">
                   Although after registration you will have access to variety of usefull tools that can help you to plan your time schedule or maybe some tool even can be usefull for your everyday's tasks. The range of available tool is constantly growing!
                    </p>
       <br><br> 
       <h1 style="font-size: 50px;">MEET MATE APP</h1>
       <p style="font-size: 30px;font-weight: 300;">
                        Developed by <a href="{{URL::to('users/32 ')}}">Maksim Narushevich</a> in 2017
                    </p>
                       <br><br> <p style="font-size: 25px;font-weight:300;">
                  You are welcome to send your advices about how would you improve this app and what you don't like.<br>
                        Please click <a href="{{URL::to('contact_us ')}}">Contact</a> link and find all available ways for communication.
                  </p>
  
                </div>
@endsection