@section ('styles')

@endsection
@extends('layouts.admin')
@section('General')


        <h1>Messages list</h1>
        <div class="table-responsive">

            @if(count($users)>0)
                @foreach($users as $user)
                    <div class="w3-row post_item">

                        <div class="w3-col m6 l6 ">
                            <div class="w3-col m12 l12 ">
                                <a href="{{ URL::to('users/' . $user->id ) }}">
                                <img style="border-radius: 20px;" height="50" src="{{$user->photo ? $path.$user->photo->path :$path."/images/noimage.png"}}" alt=""></a>
                                <a href="{{ URL::to('users/' . $user->id ) }}">{{$user->name}}</a>
                            </div>
                        </div>
                        <div class="w3-col m6 l6 ">
                            <a href="{{ URL::to('chat/' . $user->id ) }}">Show messages</a>
                        </div>


                    </div>
                    <hr/>
                @endforeach
            @else
                <h3>You haven't send any messages yet</h3>
            @endif

        </div>

@endsection
@section ('scripts')

@endsection

