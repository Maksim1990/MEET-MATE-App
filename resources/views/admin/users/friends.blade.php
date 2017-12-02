@extends('layouts.admin')
@section ('General')
    <div class="col-xs-10 col-sm-10">

        @if(!$friends)
            <h2>Still has no friends</h2>
        @else
        @foreach($friends as $user)
        
             <div class="w3-row post_item">
                                <div class="col-xs-2 col-sm-2 w3-center">
                                    <a href="{{ URL::to('users/' . $user->id ) }}">
                                        <img style="border-radius: 20px;object-fit: cover;" width="150" height="150" src="{{$user->photo ? $path.$user->photo->path :$path."/images/noimage.png"}}" alt="">
                                    </a>
                                </div>
                                <div class="col-xs-5 col-xs-offset-1 col-sm-5 col-sm-offset-1 ">
                                    <p>
                                        <a href="{{ URL::to('users/' . $user->id ) }}">
                                            <h3>{{ucfirst(strtolower($user->name))}} {{ucfirst(strtolower($user->profile?$user->profile->lastname:""))}}</h3>
                                        </a>
                                    </p>
                                    <p style="color:cadetblue;font-weight: bold;">{{strtoupper($user->profile?$user->profile->status:"")}} </p>
                                </div>
                                @if(Auth::id()!=$user->id)
                                <div class="col-xs-4 col-sm-4" id="buttons_{{$user->id}}">
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
                                 @endif
                            </div>
                           
                            
                            
        @endforeach
            @endif

    </div>
    <div class="col-xs-2 col-sm-2">

    </div>
@stop
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