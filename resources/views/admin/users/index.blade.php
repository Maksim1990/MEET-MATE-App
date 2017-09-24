@extends('layouts.admin')
@section('General')

<div class="table-responsive">

  <div class="w3-row">
    <div class="w3-col m6 l6 ">
      <h1>Users</h1>
    </div>
    <div class="w3-col m6 l6">
      <form action="/search" method="POST" role="search">
        {{ csrf_field() }}
        <div class="input-group">
          <input type="text" class="form-control" name="q"
                 placeholder="Search users"> <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
        </div>
      </form>
    </div>
  </div>
    <div class="col-xs-12 col-sm-12 tab_main_body">
      @if($users)
        @foreach($users as $user)
      <div class="w3-row post_item">
        <div class="w3-col m2 l2 w3-center">
            <a href="{{ URL::to('users/' . $user->id ) }}">
          <img style="border-radius: 20px;object-fit: cover;" width="150" height="150" src="{{$user->photo ? $path.$user->photo->path :$path."/images/noimage.png"}}" alt="">
            </a>
        </div>
        <div class="w3-col m6 l6">
          <p>
              <a href="{{ URL::to('users/' . $user->id ) }}">
            <h3>{{ucfirst(strtolower($user->name))}} {{ucfirst(strtolower($user->profile?$user->profile->lastname:""))}}</h3>
            </a>
          </p>
        <p style="color:cadetblue;font-weight: bold;">{{strtoupper($user->profile?$user->profile->status:"")}} </p>
        </div>
        <div class="w3-col m4 l4" id="buttons_{{$user->id}}">
          @if($user->status_type=='1')
          <a id="add_friend_{{$user->id}}" onclick="addUser('{{$user->id}}','{{$user->name}}')"  class="add_friend w3-button w3-green" style="display: inline-block;width:200px;margin-top: 50px;">ADD TO FRIENDS</a>
          @elseif($user->status_type=='2')
            <a id="decline_friend_{{$user->id}}" onclick="declineUser('{{$user->id}}','{{$user->name}}')"   class="decline_friend w3-button w3-orange" style="display: inline-block;width:200px;margin-top: 50px;">DECLINE REQUEST</a>
          @elseif($user->status_type=='3')
            <a id="remove_friend_{{$user->id}}" onclick="removeUser('{{$user->id}}','{{$user->name}}')"   class="remove_friend w3-button w3-red" style="display: inline-block;width:200px;margin-top: 50px;">REMOVE FROM FRIENDS</a>
          @elseif($user->status_type=='4')
            <a id="decline_friend_{{$user->id}}" onclick="declineUser('{{$user->id}}','{{$user->name}}')"   class="decline_friend w3-button w3-orange" style="display: inline-block;width:200px;margin-top: 50px;">DECLINE REQUEST</a>
            <a id="accept_friend_{{$user->id}}" onclick="acceptUser('{{$user->id}}','{{$user->name}}')"   class="remove_friend w3-button w3-yellow" style="display: inline-block;width:200px;">ACCEPT REQUEST</a>
          @endif
        </div>
      </div>
        @endforeach
      @endif
</div>
  <div class="w3-center">
{!! $users->links() !!}
  </div>
  </div>
<script>
  @if(Session::has('user_change'))
  new Noty({
    type: 'warning',
    layout: 'leftBottom',
    text: '{{session('user_change')}}'
  }).show();
  @endif
</script>


@endsection
@section ('scripts')
  <script>
    function removeUser(id,name) {
      var user_id=id;
      var url_remove_user='{{ URL::to('unfriend_user') }}';
      var conf=confirm("Do you want to delete "+name+" from friend list?");
      if(conf){
            $.ajax({
              method:'POST',
              url:url_remove_user,
              data:{user_id:user_id,_token:token},
              success: function(data) {
                if(data['status']) {
                       var user_id=data['user_id'];
              var user_name=data['user_name'];
             $('#remove_friend_'+user_id).css('display','none'); 
             $('#buttons_'+user_id).html('');
             $("#buttons_"+user_id).append("<a id='add_friend_"+user_id+"' onclick=\"addUser('"+user_id+"','"+user_name+"')\"  class='add_friend w3-button w3-green' style='display: inline-block;width:200px;margin-top: 50px;'>ADD TO FRIEND</a>"); 
             
                  new Noty({
                    type: 'success',
                    layout: 'bottomLeft',
                    text:'Deleted from your friend list!'
                  }).show();
                }
              }
            });
      }
    }

    function addUser(id,name) {
      var user_id=id;
      var url_delete_user='{{ URL::to('add_user_request') }}';
      var conf=confirm("Do you want to add "+name+" to your friend list?");
      if(conf){
        $.ajax({
          method:'POST',
          url:url_delete_user,
          data:{user_id:user_id,_token:token},
          success: function(data) {
              if(data['status']) {
              var user_id=data['user_id'];
              var user_name=data['user_name'];
             $('#add_friend_'+user_id).css('display','none'); 
             $('#buttons_'+user_id).html('');
             $("#buttons_"+user_id).append("<a id='decline_friend_"+user_id+"' onclick=\"declineUser('"+user_id+"','"+user_name+"')\"  class='decline_friend w3-button w3-orange' style='display: inline-block;width:200px;margin-top: 50px;'>DECLINE REQUEST</a>"); 
              new Noty({
                type: 'success',
                layout: 'bottomLeft',
                text:'Added to your friend list!'
              }).show();
            }
          }
        });
      }
    }

    function declineUser(id,name) {
      var user_id=id;
      var url_delete_user='{{ URL::to('decline_user_request') }}';
      var conf=confirm("Do you want to decline this list?");
      if(conf){
        $.ajax({
          method:'POST',
          url:url_delete_user,
          data:{user_id:user_id,_token:token},
          success: function(data) {
            if(data['status']) {
              var user_id=data['user_id'];
              var user_name=data['user_name'];
             $('#decline_friend_'+user_id).css('display','none'); 
             $('#buttons_'+user_id).html('');
             $("#buttons_"+user_id).append("<a id='add_friend_"+user_id+"' onclick=\"addUser('"+user_id+"','"+user_name+"')\"  class='add_friend w3-button w3-green' style='display: inline-block;width:200px;margin-top: 50px;'>ADD TO FRIEND</a>"); 
              new Noty({
                type: 'error',
                layout: 'bottomLeft',
                text:'Request was declined!'
              }).show();
            }
          }
        });
      }
    }

    function acceptUser(id,name) {
      var user_id=id;
      var url_accept_user='{{ URL::to('accept_user_request') }}';
      var conf=confirm("Do you want to accept "+name+" friend request?");
      if(conf){
        $.ajax({
          method:'POST',
          url:url_accept_user,
          data:{user_id:user_id,_token:token},
          success: function(data) {
            if(data['status']) {
                   var user_id=data['user_id'];
              var user_name=data['user_name'];
             $('#decline_friend_'+user_id).css('display','none'); 
             $('#accept_friend_'+user_id).css('display','none'); 
             $('#buttons_'+user_id).html('');
             $("#buttons_"+user_id).append("<a id='remove_friend_"+user_id+"' onclick=\"removeUser('"+user_id+"','"+user_name+"')\"  class='remove_friend w3-button w3-red' style='display: inline-block;width:200px;margin-top: 50px;'>REMOVE FROM FRIENDS</a>"); 
             
              new Noty({
                type: 'success',
                layout: 'bottomLeft',
                text:'Request was accepted!'
              }).show();
            }
          }
        });
      }
    }
  </script>
@endsection



