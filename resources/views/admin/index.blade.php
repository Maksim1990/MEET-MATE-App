
@extends('layouts.admin')

@section('scripts_header')
<script>
    function printTime(){
        var d = new Date();
        var hours=d.getHours();
        hours = ("0" + hours).slice(-2);
        var mins= d.getMinutes();
        mins = ("0" + mins).slice(-2);
        var secs=d.getSeconds();
        secs = ("0" + secs).slice(-2);
        var time=document.getElementById("time");
        time.style.color = "gray";
        time.style.fontSize = "25px";
        time.style.marginTop = "2px";
        time.style.fontFamily = "Track";
        time.innerHTML="Current time: "+hours+":"+mins+":"+secs;

    }
    setInterval(printTime, 1000);
</script>

<link href="{{asset('js/jquery.bxslider.css')}}" rel="stylesheet">

    @endsection
@section('Dashboard')
    <div class=" tab_main_body " id="dash_main">
<div class="w3-center" style="color:gray;">
    <h2>Welcome to MEET MATE App, {{Auth::user()->name}} ! @emojione(':slight_smile:')</h2>
</div>

<div class="w3-row ">
    <div class=" ">
    @if($dashboard->date_time=='Y')
    <div class="w3-col s6 m6 l6">
            <div class="w3-card-4 w3-round-xlarge dash" style="width:90%">
                <div class="w3-container w3-center">
                <h2>{{ strtoupper('day & time')}}</h2><hr>
                </div>
                <div class="w3-container">
                    <div class="col-sm-12 w3-center" id="time"></div>
                    <hr>
                    <p class="col-sm-12 w3-center" style="color:gray;font-size:25px;font-family:'Track'">{{date('Y-m-d')}}</p>
                    <img style="border-radius: 50px;object-fit: cover;" width="200" src="{{$path."/images/includes/time.png"}}" alt="">
                </div>
              
            </div>
    </div>
    @endif
     @if($dashboard->dash_birthday=='Y')
 <div class="w3-col s6 m6 l6">
            <div class="w3-card-4 w3-round-xlarge dash" style="width:90%">
                <div class="w3-container w3-center">
                <h2>{{ strtoupper('birthday notifications')}}</h2>
                </div>
                <div class="w3-container">
                    @if(count($friend_birthday_array)>0)
                        @foreach($friend_birthday_array as $user)
                            <div class="w3-col s12 m12 l12 w3-center dash_item">
                                <p><a href="{{ URL::to('users/' . $user->id ) }}" style="font-size:15px;color:green;">
                                        <img style="border-radius: 50px;object-fit: cover;" width="60" height="60" src="{{$user->photo ? $path.$user->photo->path :$path."/images/noimage.png"}}" alt="">
                                    </a></p>
                                <p> <a href="{{ URL::to('users/' . $user->id ) }}" style="font-size:15px;color:green;">
                                        {{$user->name}}</a> has birthday today<br>
                                Congratulate him with his {{$user->current_age}} years</p>
                                <hr>
                            </div>
                        @endforeach
                       @else
                        <div class="w3-center" style='padding-top:70px;'>
                            <img style="border-radius: 50px;object-fit: cover;" width="150" src="{{$path."/images/includes/nothing.png"}}" alt="">
                        </div>
                        <div class="w3-center">
                            <p style='font-size:20px;color:gray'>You don't have any birthday notification yet</p><br>
                        </div>
                    @endif
                </div>
            </div>
    </div>
 @endif
     @if($dashboard->posts=='Y')
   <div class="w3-col s6 m6 l6">
            <div class="w3-card-4 w3-round-xlarge dash" style="width:90%">
                <div class="w3-container w3-center">
                <h2>{{ strtoupper('new posts ')}}</h2>
                </div>
                <div class="w3-container">
                    @if(count($posts)>0)
                        @foreach($posts as $post)
                        <div class="w3-col s12 m12 l12 w3-center dash_item">
                            <p><a href="{{ URL::to('users/' . $post->user->id ) }}" style="font-size:15px;color:green;">
                                <img style="border-radius: 50px;object-fit: cover;" width="60" height="60" src="{{$post->user->photo ? $path.$post->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                </a></p>
                            <p> <a href="{{ URL::to('users/' . $post->user->id ) }}" style="font-size:15px;color:green;">
                                {{Auth::id()==$post->user->id?'You ':$post->user->name}}</a> added
                                <a href="{{ URL::to('wall/' . $post->user->id ) }}" style="font-size:15px;color:green;">
                                {!! $post->text !!}</a> post on your wall <span style="color:green;font-weight: 300";>
                                {{$post->created_at->diffForHumans()}}</span></p>
                        <hr>
                        </div>
                        @endforeach
                        <a href="{{ URL::to('wall/' . $post->user->id ) }}" style="font-size:15px;color:green;">See more</a>
                    @else
                        <div class="w3-center" style='padding-top:70px;'>
                            <img style="object-fit: cover;" width="150" src="{{$path."/images/includes/post.png"}}" alt="">
                        </div>
                        <div class="w3-center">
                            <p style='font-size:20px;color:gray'>You don't have any post notification yet</p><br>
                        </div>
                    @endif
                </div>
            </div>
    </div>
  @endif
     @if($dashboard->dash_comment=='Y')
  <div class="w3-col s6 m6 l6">
            <div class="w3-card-4 w3-round-xlarge dash" style="width:90%">
                <div class="w3-container w3-center">
                <h2>{{ strtoupper('new comments')}}</h2>
                </div>
                <div class="w3-container">
                    @if(count($comments)>0)
                        @foreach($comments as $comment)
                            <div class="w3-col s12 m12 l12 w3-center dash_item">
                                <p><a href="{{ URL::to('users/' . $comment->user->id ) }}" style="font-size:15px;color:green;">
                                        <img style="border-radius: 50px;object-fit: cover;" width="60" height="60" src="{{$comment->user->photo ? $path.$comment->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                    </a>
                                </p>
                                <p> <a href="{{ URL::to('users/' . $comment->user->id ) }}" style="font-size:15px;color:green;">
                                        {{Auth::id()==$comment->user->id?'You ':$comment->user->name}}</a> added
                                    <span style="color:green;font-weight: 300";>
                                   {{$comment->comment}}</span> comment to
                                    <a href="{{ URL::to('wall/' . $comment->user->id ) }}" style="font-size:15px;color:green;">
                                        {!! $comment->post_name !!}
                                    </a>on your wall <span style="color:green;font-weight: 300";>
                                {{$comment->created_at->diffForHumans()}}</span></p>
                                <hr>
                            </div>
                        @endforeach
                    <a href="{{ URL::to('wall/' . $comment->user->id ) }}" style="font-size:15px;color:green;">See more</a>
                    @else
                        <div class="w3-center" style='padding-top:70px;'>
                            <img style="object-fit: cover;" width="150" src="{{$path."/images/includes/comment.png"}}" alt="">
                        </div>
                        <div class="w3-center">
                            <p style='font-size:20px;color:gray'>You don't have any comment notification yet</p><br>
                        </div>
                    @endif
                </div>
            </div>
    </div>
 @endif
     @if($dashboard->dash_likes=='Y')
 <div class="w3-col s6 m6 l6">
            <div class="w3-card-4 w3-round-xlarge dash" style="width:90%">
                <div class="w3-container w3-center">
                <h2>{{ strtoupper('new likes')}}</h2>
                </div>
                <div class="w3-container">
                    @if(count($likes)>0)
                        @foreach($likes as $like)
                            <div class="w3-col s12 m12 l12 w3-center dash_item">
                                <p><a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px;color:green;">
                                        <img style="border-radius: 50px;object-fit: cover;" width="60" height="60" src="{{$like->user->photo ? $path.$like->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                    </a>
                                </p>
                                <p> <a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px;color:green;">
                                        {{Auth::id()==$like->user->id?'You ':$like->user->name}}</a> liked
                                    <a href="{{ URL::to('wall/' . $like->user->id ) }}" style="font-size:15px;color:green;">
                                        {!! $like->post_name !!}
                                    </a> post on your wall <span style="color:green;font-weight: 300";>
                                {{$like->created_at->diffForHumans()}}</span></p>
                                <hr>
                            </div>
                        @endforeach
                        <a href="{{ URL::to('wall/' . $like->user->id ) }}" style="font-size:15px;color:green;">See more</a>
                    @else
                        <div class="w3-center" style='padding-top:70px;'>
                            <img style="object-fit: cover;" width="150" src="{{$path."/images/includes/like.png"}}" alt="">
                        </div>
                        <div class="w3-center">
                            <p style='font-size:20px;color:gray'>You don't have any like notification yet</p><br>
                        </div>
                    @endif
                </div>
            </div>
    </div>
     @endif
     @if($dashboard->dash_messages=='Y')
    
   <div class="w3-col s6 m6 l6">
            <div class="w3-card-4 w3-round-xlarge dash" style="width:90%">
                <div class="w3-container w3-center">
                <h2>{{ strtoupper('new messages')}}</h2>
                </div>
                <div class="w3-container">
                    @if(count($messages)>0)
                        @foreach($messages as $message)
                            <div class="w3-col s12 m12 l12 w3-center dash_item">
                                <p><a href="{{ URL::to('users/' . $message->user->id ) }}" style="font-size:15px;color:green;">
                                        <img style="border-radius: 50px;object-fit: cover;" width="60" height="60" src="{{$message->user->photo ? $path.$comment->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                    </a></p>

                                <p> <a href="{{ URL::to('users/' . $message->user->id ) }}" style="font-size:15px;color:green;">
                                        {{Auth::id()==$message->user->id?'You ':$message->user->name}}</a> sent you
                                     message
                                    <span style="color:green;font-weight: 300";>
                                {{$message->created_at->diffForHumans()}}</span></p>
                                <hr>
                            </div>
                        @endforeach
                        <a href="{{ URL::to('chat/' ) }}" style="font-size:15px;color:green;">See all conversations</a>
                    @else
                        <div class="w3-center" style='padding-top:70px;'>
                            <img style="object-fit: cover;" width="150" src="{{$path."/images/includes/message.png"}}" alt="">
                        </div>
                        <div class="w3-center">
                            <p style='font-size:20px;color:gray'>You don't have any message notification yet</p><br>
                        </div>
                    @endif
                </div>
            </div>
    </div>
    @endif
    </div>
</div>
        <div class="w3-row w3-center" style="width: 90%;border-top:1px dashed gray;margin-top: 50px">
            <h3 style="color:gray;;">ALL RECENT ADVERTISEMENTS</h3>
        </div>

            @if(count($adds)>0)
            <div class="w3-row w3-center" style="padding-left:15%;">
            <ul class="bxslider" >
                @foreach($adds as $add)
                <li>
                    <a href="{{ URL::to('advertisement/' . $add->id ) }}">
                    <img data-container="body" data-placement="bottom" data-toggle="tooltip" title="{{$add->title}}" src="{{$add->image ? $path.$add->image->photo->path :$path."/images/noimage.png"}}" />
                        </a>
                </li>
            @endforeach
            </ul>
            @else
                <div class="w3-row w3-center" style="width: 90%">
                    <h6>There are no available advertisements now</h6>
            @endif
        </div>

        <div class="w3-row w3-center" style="width: 90%;border-top:1px dashed gray;margin-top: 50px">
            <h3 style="color:gray;;">ALL RECENT JOB OFFERS</h3>
        </div>

            @if(count($jobs)>0)
            <div class="w3-row w3-center" style="padding-left:15%;">
                <ul class="bxslider" >
                    @foreach($jobs as $job)
                        <li>
                            <a data-container="body" data-placement="bottom" data-toggle="tooltip" title="{{$job->title}}" href="{{ URL::to('jobs/' . $job->id ) }}">
                                <img src="{{$job->image ? $path.$job->image->photo->path :$path."/images/noimage.png"}}" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                    <div class="w3-row w3-center" style="width: 90%">
               <h6>There are no available job offers now</h6>
            @endif
        </div>
</div>
@endsection
@section('Settings')
<div class="col-sm-12">
    <div class="col-sm-6 w3-center">
        <div >
            <h3>Dashboard appearence settings</h3>
        </div>

        {{ Form::model($dashboard, ['method' =>'PATCH' , 'action' => ['DashboardController@update',$dashboard->id],'files'=>true])}}
        <div class="col-sm-6 w3-center">
        <div class="group-form">
            {!! Form::label('date_time','Date & Time') !!}
            @if($dashboard->date_time=='Y')
                {{ Form::checkbox('date_time','Y',true, ['class' => 'field']) }}
            @else
                {{ Form::checkbox('date_time', 'Y', false, ['class' => 'field']) }}
            @endif
        </div>

        <div class="group-form">
            {!! Form::label('posts','Latest posts') !!}
            @if($dashboard->posts=='Y')
                {{ Form::checkbox('posts','Y',true, ['class' => 'field']) }}
            @else
                {{ Form::checkbox('posts', 'Y', false, ['class' => 'field']) }}
            @endif
        </div>
       
         <div class="group-form">
            {!! Form::label('dash_birthday','Birthday notifications') !!}
            @if($dashboard->dash_birthday=='Y')
                {{ Form::checkbox('dash_birthday','Y',true, ['class' => 'field']) }}
            @else
                {{ Form::checkbox('dash_birthday', 'Y', false, ['class' => 'field']) }}
            @endif
        </div>
        </div>
        <div class="col-sm-6 w3-center">
         <div class="group-form">
            {!! Form::label('dash_comment','Last comments') !!}
            @if($dashboard->dash_comment=='Y')
                {{ Form::checkbox('dash_comment','Y',true, ['class' => 'field']) }}
            @else
                {{ Form::checkbox('dash_comment', 'Y', false, ['class' => 'field']) }}
            @endif
        </div> 
          
      
        <div class="group-form">
            {!! Form::label('dash_likes','Last likes') !!}
            @if($dashboard->dash_likes=='Y')
                {{ Form::checkbox('dash_likes','Y',true, ['class' => 'field']) }}
            @else
                {{ Form::checkbox('dash_likes', 'Y', false, ['class' => 'field']) }}
            @endif
        </div> 
        
         <div class="group-form">
            {!! Form::label('dash_messages','Last messages') !!}
            @if($dashboard->dash_messages=='Y')
                {{ Form::checkbox('dash_messages','Y',true, ['class' => 'field']) }}
            @else
                {{ Form::checkbox('dash_messages', 'Y', false, ['class' => 'field']) }}
            @endif
        </div>  
        
        </div>
        <p style="padding-top:100px;">
            
          <span >Choose what information to display</span> <br><hr>
        </p>
        <div>
            
           {!! Form::submit('Update settings',['class'=>'btn btn-warning']) !!} 
        </div>

        {!! Form::close() !!}
    </div>
 </div>
@endsection
@section ('scripts')
    <script src="{{asset('js/jquery.bxslider.js')}}" type="text/javascript"></script>
    <script>
        $('.bxslider').bxSlider({
            minSlides: 3,
            maxSlides: 4,
            slideWidth: 170,
            slideMargin: 10
        });
    </script>
@endsection