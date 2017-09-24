<div class="col-xs-12 w3-center ">
    <div class="col-xs-10 col-xs-offset-1 w3-center">
    <hr>
    </div>
    <h4>Communities</h4>
    @if(count($communities)>0)
        <ul>
        @foreach($communities as $community)
      <li class="w3-large">
          <a href="{{ URL::to('community/' . $community->id ) }}">
          {{$community->name}}
          </a>
                    @if($community->user_id==Auth::id())
                        <a href="{{ URL::to('community/' . $community->id . '/edit') }}" class="w3-right ">Edit</a>
                    @endif
      </li>
        @endforeach
            @else

                <h6>No community created by this user</h6>
    @endif
        </ul>
        @if($user->id==Auth::id())
    <a href="{{ URL::to('users/' . $user->id.'/edit' ) }}" style="font-size:15px">
        <i  data-container="body" data-placement="bottom" data-toggle="tooltip" title="Edit profile" class="fa fa-plus-circle" ></i>
        Add new travel community
    </a>
    @endif
</div>
@if(count($friend_birthday_array)>0)
<div class=" w3-center">
    <hr>
    <h4>Birthday notifications</h4>
    <div class="w3-small">
        <ul class="w3-ul w3-margin-top" >
            @foreach($friend_birthday_array as $friend)
                <li>
                    <a href="{{ URL::to('users/' . $friend->id ) }}" style="font-size:15px">
                        <img style="border-radius: 50px;" height="50" width="50" src="{{$friend->photo ? $path.$friend->photo->path :$path."/images/noimage.png"}}" alt="">
                        {{$friend->name}}</a> is {{$friend->current_age}} years old today!
                    <p><a href="{{ URL::to('chat/' . $friend->id ) }}">Send your congratulation!</a></p>

                </li>
            @endforeach
        </ul>
    </div>
</div>
@endif
<div class="col-xs-10 col-xs-offset-1 w3-center">
    <hr>
    <h4><a href="{{ URL::to('friends/' . Auth::id() ) }}">List of friends</a></h4>
    @if(count($user->friends())>0)
    <p>

        @foreach($user->friends() as $friend)

            <a href="{{ URL::to('users/' . $friend->id ) }}" style="font-size:15px">
        <img style="border-radius: 50px;" height="50" width="50" src="{{$friend->photo ? $path.$friend->photo->path :$path."/images/noimage.png"}}" alt="">
            </a>
        @endforeach

    </p>
    @else
        <h6>You have no any friends yet</h6>
    @endif
</div>