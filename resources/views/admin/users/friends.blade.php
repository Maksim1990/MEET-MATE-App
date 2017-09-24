@extends('layouts.admin')
@section ('General')
    <div class="col-xs-10 col-sm-10">

        @if(!$friends)
            <h2>Still has no friends</h2>
        @else
        @foreach($friends as $friend)
        <div>


            <a href="{{ URL::to('users/' . $friend->id ) }}" style="font-size:15px">
                <img style="border-radius: 10px;" height="100" width="100" src="{{$friend->photo ? $path.$friend->photo->path :$path."/images/noimage.png"}}" alt="">
            </a>
            {{$friend->name}}
        </div>
        @endforeach
            @endif

    </div>
    <div class="col-xs-2 col-sm-2">

    </div>
@stop
