@extends('layouts.admin')
@section ('scripts_header')

@endsection
@section ('General')
    <div class="col-xs-12 col-sm-12 w3-center">
  
     @if($emptyLikes)
        @if($invitations!='false')
    <div class="col-xs-4 col-sm-4 ">
        <h2>Invitations</h2>
       @foreach($invitations as $inv)
       <div class="col-xs-12 col-sm-12 post_item " id="invitation_item_{{$inv->id}}">
           <div class="col-xs-12 col-sm-12 ">
               <span>
                   <a href="{{ URL::to('users/' . $inv->sender->id ) }}" style="font-size:15px">
                   {{$inv->sender->name}}</a> invited you
                   <a href="{{ URL::to('community/' . $inv->community->id ) }}" style="font-size:15px">
                   {{$inv->community->name}}</a> group</span>
               <br><span class="w3-text-green">({{$inv->created_at->diffForHumans()}})</span>
           </div>
           <div class="col-xs-3 col-sm-3 ">
           <a href="{{ URL::to('users/' . $inv->sender->id ) }}" style="font-size:15px">
               <img style="border-radius: 50px;" height="50" width="50" src="{{$inv->sender->photo ? $path.$inv->sender->photo->path :$path."/images/noimage.png"}}" alt="">
               <p><a href="{{ URL::to('users/' . $inv->sender->id ) }}" style="font-size:15px">{{$inv->sender->name}}</a></p>
           </a>
               </div>
           <div class="col-xs-9 col-sm-9 " style="margin-top:15px;" id="invitation_buttons_{{$inv->sender->id}}">
               <a id="accept_link_{{$inv->sender->id}}"  data-invitation-id="{{$inv->id}}" data-invitation-name="{{$inv->sender->name}}" class="accept_invitation w3-button w3-green" style="display: inline-block">ACCEPT</a>
               <a id="decline_link_{{$inv->sender->id}}" data-invitation-id="{{$inv->id}}" data-invitation-name="{{$inv->sender->name}}" class="decline_invitation w3-button w3-red" style="display: inline-block">DECLINE</a>
               <hr>
       </div>
       </div>
        @endforeach
    </div>
        @endif
        @if($messages!='false')
    <div class="col-xs-4 col-sm-4 ">
        <h2>Messages</h2>

            @foreach($messages as $mes)
                <div class="col-xs-12 col-sm-12 post_item" id="message_item_{{$mes->id}}">
                    <div class="col-xs-12 col-sm-12 ">
               <span>
                   <a href="{{ URL::to('users/' . $mes->user->id ) }}" style="font-size:15px">
                   {{$mes->user->name}}</a> send you message</span>
                        <br><span class="w3-text-green">({{$mes->created_at->diffForHumans()}})</span>
                    </div>
                    <div class="col-xs-3 col-sm-3 ">
                        <a href="{{ URL::to('users/' . $mes->user->id ) }}" style="font-size:15px">
                            <img style="border-radius: 50px;" height="50" width="50" src="{{$mes->user->photo ? $path.$mes->user->photo->path :$path."/images/noimage.png"}}" alt="">
                            <p><a href="{{ URL::to('users/' . $mes->user->id ) }}" style="font-size:15px">{{$mes->user->name}}</a></p>
                        </a>
                    </div>
                    <div class="col-xs-9 col-sm-9 " style="margin-top:15px;" id="message_buttons_{{$mes->user->id}}">
                        <a id="read_message_{{$mes->user->id}}" href="{{ URL::to('chat/'.$mes->user->id ) }}"  class="read_message w3-button w3-green" style="display: inline-block">READ</a>
                        <a id="mark_message_{{$mes->user->id}}" data-message-id="{{$mes->id}}"  data-message-user-name="{{$mes->user->name}}" class="mark_message w3-button w3-orange" style="display: inline-block">MARK AS READ</a>
                        <hr>
                    </div>
                </div>
            @endforeach
    </div>
        @endif


            @if($likesWall!='false')
    <div class="col-xs-4 col-sm-4 ">
        <h2>Likes on your wall's posts</h2>

            @foreach($likesWall as $like)
            <div class="col-xs-12 col-sm-12 post_item" id="like_wall_item_{{$like->id}}">
                <div class="col-xs-12 col-sm-12 ">
               <span>
                   <a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px">
                   {{Auth::id()==$like->user->id?'You ':$like->user->name}}</a> liked {!! $like->post_name !!} post on your wall</span>
                    <br><span class="w3-text-green">({{$like->created_at->diffForHumans()}})</span>
                </div>
                @if(Auth::id()!=$like->user->id)
                <div class="col-xs-3 col-sm-3 ">
                    <a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px">
                        <img style="border-radius: 50px;" height="50" width="50" src="{{$like->user->photo ? $path.$like->user->photo->path :$path."/images/noimage.png"}}" alt="">
                        <p><a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px">{{$like->user->name}}</a></p>
                    </a>
                </div>
                @endif
                <div class="col-xs-9 col-sm-9 " style="margin-top:15px;" id="message_buttons_{{$like->user->id}}">
                    <a  href="{{ URL::to('wall/'.$like->wall_user_id ) }}"  class=" w3-button w3-green" style="display: inline-block">SEE WALL</a>
                    <a  data-like-wall-id="{{$like->id}}"  data-like-wall-post-id="{{$like->post_id}}" class="mark_like_wall w3-button w3-orange" style="display: inline-block">HIDE</a>
                    <hr>
                </div>
            </div>
            @endforeach
    </div>
        @endif





            @if($gifts!='false')
                <div class="col-xs-4 col-sm-4 ">
                    <h2>New gifts</h2>
                    @foreach($gifts as $gift)
                        <div class="col-xs-12 col-sm-12 post_item" id="gift_item_{{$gift->id}}">
                            <div class="col-xs-12 col-sm-12 ">
                    <span>
                   <a href="{{ URL::to('users/' . $gift->user->id ) }}" style="font-size:15px">
                   {{$gift->user->name}}</a> sent you gift</span>
                                <br><span class="w3-text-green">({{$gift->created_at->diffForHumans()}})</span>
                            </div>
                            @if(Auth::id()!=$gift->user->id)
                                <div class="col-xs-3 col-sm-3 ">
                                    <a href="{{ URL::to('users/' . $gift->user->id ) }}" style="font-size:15px">
                                        <img style="border-radius: 50px;" height="50" width="50" src="{{$gift->user->photo ? $path.$gift->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                        <p><a href="{{ URL::to('users/' . $gift->user->id ) }}" style="font-size:15px">{{$gift->user->name}}</a></p>
                                    </a>
                                </div>
                            @endif
                            <div class="col-xs-9 col-sm-9 " style="margin-top:15px;" id="gift_buttons_{{$gift->user->id}}">
                                <a  href="{{ URL::to('users/'.Auth::id() ) }}"  class=" w3-button w3-green" style="display: inline-block">SEE PROFILE</a>
                                <a  data-gift-id="{{$gift->id}}"  data-gift-user-name="{{$gift->user->name}}" class="hide_gift w3-button w3-orange" style="display: inline-block">HIDE</a>
                                <hr>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($friend_requests!=='false' && !empty($friend_requests))
                <div class="col-xs-4 col-sm-4 ">
                    <h2>New friend requests</h2>
                    @foreach($friend_requests as $request)
                        <div class="col-xs-12 col-sm-12 post_item" id="friend_request_item_{{$request->user->id}}">
                            <div class="col-xs-12 col-sm-12 ">
                    <span>
                   <a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">
                   {{$request->user->name}}</a> sent you friend request</span>
                                <br><span class="w3-text-green">({{$request->created_at->diffForHumans()}})</span>
                            </div>
                            @if(Auth::id()!=$request->user->id)
                                <div class="col-xs-3 col-sm-3 ">
                                    <a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">
                                        <img style="border-radius: 50px;" height="50" width="50" src="{{$request->user->photo ? $path.$request->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                        <p><a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">{{$request->user->name}}</a></p>
                                    </a>
                                </div>
                            @endif
                            <div class="col-xs-9 col-sm-9 " style="margin-top:15px;" id="friend_request_buttons_{{$request->user->id}}">
                                <a id="decline_friend_{{$request->user->id}}" onclick="declineUser('{{$request->user->id}}','{{$request->user->name}}')"   class="decline_friend w3-button w3-orange" style="display:block;width:100%;margin-top: 50px;">DECLINE REQUEST</a>
                                <a id="accept_friend_{{$request->user->id}}" onclick="acceptUser('{{$request->user->id}}','{{$request->user->name}}')"   class="remove_friend w3-button w3-yellow" style="display: block;width:100%;">ACCEPT REQUEST</a>
                                <hr>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif


            @if($wall_posts!='false')
                <div class="col-xs-4 col-sm-4 ">
                    <h2>New posts on your wall</h2>
                    @foreach($wall_posts as $request)
                        <div class="col-xs-12 col-sm-12 post_item" id="post_wall_request_item_{{$request->id}}">
                            <div class="col-xs-12 col-sm-12 ">
                    <span>
                   <a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">
                   {{Auth::id()==$request->user->id?'You ':$request->user->name}}</a> added new post on your wall</span>
                                <br><span class="w3-text-green">({{$request->created_at->diffForHumans()}})</span>
                            </div>
                            @if(Auth::id()!=$request->user->id)
                                <div class="col-xs-3 col-sm-3 ">
                                    <a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">
                                        <img style="border-radius: 50px;" height="50" width="50" src="{{$request->user->photo ? $path.$request->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                        <p><a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">{{$request->user->name}}</a></p>
                                    </a>
                                </div>
                            @endif
                            <div class="col-xs-9 col-sm-9 w3-center" style="margin-top:15px;" id="post_wall_buttons_{{$request->user->id}}">
                                <a  href="{{ URL::to('wall/'.Auth::id() ) }}"  class="w3-button w3-green" style="display: inline-block">SEE WALL</a>
                                <a  data-post-id="{{$request->id}}"  data-post-user-name="{{$request->user->name}}" class="hide_post_wall w3-button w3-orange" style="display: inline-block">HIDE</a>
                                <hr>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($community_posts!='false')
                <div class="col-xs-4 col-sm-4 ">
                    <h2>New posts in your community</h2>
                    @foreach($community_posts as $request)
                        <div class="col-xs-12 col-sm-12 post_item" id="post_community_request_item_{{$request->id}}">
                            <div class="col-xs-12 col-sm-12 ">
                    <span>
                   <a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">
                   {{Auth::id()==$request->user->id?'You ':$request->user->name}}</a> added new post in
                        <a href="{{ URL::to('community/' . $request->community_id ) }}" style="font-size:15px">
                        {{$request->community_name}}</a> community</span>
                                <br><span class="w3-text-green">({{$request->created_at->diffForHumans()}})</span>
                            </div>
                            @if(Auth::id()!=$request->user->id)
                                <div class="col-xs-3 col-sm-3 ">
                                    <a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">
                                        <img style="border-radius: 50px;" height="50" width="50" src="{{$request->user->photo ? $path.$request->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                        <p><a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">{{$request->user->name}}</a></p>
                                    </a>
                                </div>
                            @endif
                            <div class="col-xs-9 col-sm-9 w3-center" style="margin-top:15px;" id="post_community_buttons_{{$request->user->id}}">
                                <a  href="{{ URL::to('community/' . $request->community_id ) }}"  class="w3-button w3-green" style="display: inline-block">SEE COMMUNITY</a>
                                <a  data-post-community-id="{{$request->id}}" data-community-id="{{$request->community_id}}"  data-post-community-user-name="{{$request->user->name}}" class="hide_post_community w3-button w3-orange" style="display: inline-block">HIDE</a>
                                <hr>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($wall_comments!='false')
                <div class="col-xs-4 col-sm-4 ">
                    <h2>New comments on your wall</h2>
                    @foreach($wall_comments as $request)
                        <div class="col-xs-12 col-sm-12 post_item" id="wall_comment_request_item_{{$request->id}}">
                            <div class="col-xs-12 col-sm-12 ">
                    <span>
                   <a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">
                   {{Auth::id()==$request->user->id?'You ':$request->user->name}}</a> added new comment to
                        <a href="{{ URL::to('wall/' . $request->wall_user_id ) }}" style="font-size:15px">
                        {!! $request->post_name !!}</a> post on your wall</span>
                                <br><span class="w3-text-green">({{$request->created_at->diffForHumans()}})</span>
                            </div>
                            @if(Auth::id()!=$request->user->id)
                                <div class="col-xs-3 col-sm-3 ">
                                    <a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">
                                        <img style="border-radius: 50px;" height="50" width="50" src="{{$request->user->photo ? $path.$request->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                        <p><a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">{{$request->user->name}}</a></p>
                                    </a>
                                </div>
                            @endif
                            <div class="col-xs-9 col-sm-9 w3-center" style="margin-top:15px;" id="wall_comment_buttons_{{$request->user->id}}">
                                <a  href="{{ URL::to('wall/' . $request->wall_user_id ) }}"  class="w3-button w3-green" style="display: inline-block">SEE WALL</a>
                                <a  data-comment-id="{{$request->id}}" data-post-id="{{$request->post_id}}"  data-comment-user-name="{{$request->user->name}}" class="hide_wall_comment w3-button w3-orange" style="display: inline-block">HIDE</a>
                                <hr>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if(!empty($community_comments) && $community_comments!='false')
                <div class="col-xs-4 col-sm-4 ">
                    <h2>New comments in your community</h2>
                    @foreach($community_comments as $request)
                        <div class="col-xs-12 col-sm-12 post_item" id="community_comment_request_item_{{$request->id}}">
                            <div class="col-xs-12 col-sm-12 ">
                    <span>
                   <a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">
                   {{Auth::id()==$request->user->id?'You ':$request->user->name}}</a> added new comment to
                        <a href="{{ URL::to('community/' . $request->community_id ) }}" style="font-size:15px">
                        {!! $request->post_name !!}</a> post in your community
                        <a href="{{ URL::to('community/' . $request->community_id ) }}" style="font-size:15px">
                        {{$request->community_name}}</a>
                    </span>
                                <br><span class="w3-text-green">({{$request->created_at->diffForHumans()}})</span>
                            </div>
                            @if(Auth::id()!=$request->user->id)
                                <div class="col-xs-3 col-sm-3 ">
                                    <a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">
                                        <img style="border-radius: 50px;" height="50" width="50" src="{{$request->user->photo ? $path.$request->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                        <p><a href="{{ URL::to('users/' . $request->user->id ) }}" style="font-size:15px">{{$request->user->name}}</a></p>
                                    </a>
                                </div>
                            @endif
                            <div class="col-xs-9 col-sm-9 w3-center" style="margin-top:15px;" id="community_comment_buttons_{{$request->user->id}}">
                                <a  href="{{ URL::to('community/' . $request->community_id ) }}"  class="w3-button w3-green" style="display: inline-block">SEE COMMUNITY</a>
                                <a  data-comment-id="{{$request->id}}" data-post-id="{{$request->post_id}}"  data-comment-user-name="{{$request->user->name}}" class="hide_community_comment w3-button w3-orange" style="display: inline-block">HIDE</a>
                                <hr>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            
                @if($community_likes!='false')
    <div class="col-xs-4 col-sm-4 ">
        <h2>Likes on your community's posts</h2>

            @foreach($community_likes as $like)
            <div class="col-xs-12 col-sm-12 post_item" id="like_community_item_{{$like->id}}">
                <div class="col-xs-12 col-sm-12 ">
               <span>
                   <a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px">
                   {{Auth::id()==$like->user->id?'You ':$like->user->name}}</a> liked {!! $like->post_name !!} post in 
                   <a href="{{ URL::to('community/' . $like->community_id ) }}" style="font-size:15px">
                   {{$like->community_name}} community
                   </a></span>
                    <br><span class="w3-text-green">({{$like->created_at->diffForHumans()}})</span>
                </div>
                @if(Auth::id()!=$like->user->id)
                <div class="col-xs-3 col-sm-3 ">
                    <a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px">
                        <img style="border-radius: 50px;" height="50" width="50" src="{{$like->user->photo ? $path.$like->user->photo->path :$path."/images/noimage.png"}}" alt="">
                        <p><a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px">{{$like->user->name}}</a></p>
                    </a>
                </div>
                @endif
                <div class="col-xs-9 col-sm-9 " style="margin-top:15px;" id="community_buttons_{{$like->user->id}}">
                    <a  href="{{ URL::to('community/'.$like->community_id ) }}"  class=" w3-button w3-green" style="display: inline-block">SEE COMMUNITY</a>
                    <a  data-like-community-id="{{$like->id}}"  data-like-community-post-id="{{$like->community_id}}" class="mark_community_wall w3-button w3-orange" style="display: inline-block">HIDE</a>
                    <hr>
                </div>
            </div>
            @endforeach
    </div>
        @endif




            @if($blog_likes!='false')
                <div class="col-xs-4 col-sm-4 ">
                    <h2>Likes on your blog's posts</h2>

                    @foreach($blog_likes as $like)
                        <div class="col-xs-12 col-sm-12 post_item" id="like_blog_item_{{$like->id}}">
                            <div class="col-xs-12 col-sm-12 ">
               <span>
                   <a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px">
                   {{Auth::id()==$like->user->id?'You ':$like->user->name}}</a> liked
                   <a href="{{ URL::to('posts/' . $like->post_id ) }}" style="font-size:15px">
                   {!! $like->post_name !!}</a> post
                   </span>
                                <br><span class="w3-text-green">({{$like->created_at->diffForHumans()}})</span>
                            </div>
                            @if(Auth::id()!=$like->user->id)
                                <div class="col-xs-3 col-sm-3 ">
                                    <a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px">
                                        <img style="border-radius: 50px;" height="50" width="50" src="{{$like->user->photo ? $path.$like->user->photo->path :$path."/images/noimage.png"}}" alt="">
                                        <p><a href="{{ URL::to('users/' . $like->user->id ) }}" style="font-size:15px">{{$like->user->name}}</a></p>
                                    </a>
                                </div>
                            @endif
                            <div class="col-xs-9 col-sm-9 " style="margin-top:15px;" id="blog_buttons_{{$like->user->id}}">
                                <a  href="{{ URL::to('posts/'.$like->post_id ) }}"  class=" w3-button w3-green" style="display: inline-block">SEE POST</a>
                                <a  data-like-blog-id="{{$like->id}}"  data-like-blog-post-id="{{$like->post_id}}" class="mark_blog w3-button w3-orange" style="display: inline-block">HIDE</a>
                                <hr>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
         @else
         <p style='margin-top:150px;font-size:55px;color:gray'>You don't have any notification yet</p><br>
            <img  width="300" src="{{$path."/images/includes/nothing.png"}}" alt="">
        @endif

    </div>
@endsection
@section ('scripts')
<script>
    var token='{{\Illuminate\Support\Facades\Session::token()}}';
    $(".mark_message").click(function(e) {
        var message_id=$(this).data('message-id');
        var user_name=$(this).data('message-user-name');
        var url_make_as_read='{{ URL::to('make_as_read') }}';
        $.ajax({
            method:'POST',
            url:url_make_as_read,
            data:{message_id:message_id,_token:token},
            success: function(data) {
                if(data['status']){
                var notice_value=$('#notification_number').text();
                notice_value=+notice_value-1;
                $('#notification_number').text(notice_value);
                $('#message_item_'+message_id).fadeOut();
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Message from '+ user_name+' was marked as read!'
                    }).show();
                }

            }
        });

    });



    $(".accept_invitation").click(function(e) {
        var invitation_id=$(this).data('invitation-id');
        
        var invitation_name=$(this).data('invitation-name');
        var url_accept_invitation_notice='{{ URL::to('accept_invitation_notice') }}';
            $.ajax({
                method:'POST',
                url:url_accept_invitation_notice,
                data:{invitation_id:invitation_id,_token:token},
                success: function(data) {
                    if(data['status']){
                        var notice_value=$('#notification_number').text();
                        notice_value=+notice_value-1;
                        $('#notification_number').text(notice_value);
                        $('#invitation_item_'+invitation_id).fadeOut();
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Invitation from '+ invitation_name+' was accepted!'
                        }).show();
                    }
                }
            });
    });


    $(".decline_invitation").click(function(e) {
        var invitation_id=$(this).data('invitation-id');
        var invitation_name=$(this).data('invitation-name');
        var url_decline_invitation_notice='{{ URL::to('decline_invitation_notice') }}';
        var conf=confirm("Do you want to decline this invitation?");
        if(conf) {
            $.ajax({
                method: 'POST',
                url: url_decline_invitation_notice,
                data: {invitation_id: invitation_id, _token: token},
                success: function (data) {
                    if (data['status']) {
                        var notice_value = $('#notification_number').text();
                        notice_value = +notice_value - 1;
                        $('#notification_number').text(notice_value);
                        $('#invitation_item_' + invitation_id).fadeOut();
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Invitation from ' + invitation_name + ' was declined!'
                        }).show();
                    }
                }
            });
        }
    });


    $(".mark_like_wall").click(function(e) {
        var like_id=$(this).data('like-wall-id');
        var like_post_id=$(this).data('like-wall-post-id');
        var url_hide_like_wall_notice='{{ URL::to('hide_like_wall_notice') }}';
        var moduleId='5';
            $.ajax({
                method: 'POST',
                url: url_hide_like_wall_notice,
                data: {like_id: like_id,like_post_id:like_post_id,moduleId:moduleId, _token: token},
                success: function (data) {
                    if (data['status']) {
                        var notice_value = $('#notification_number').text();
                        notice_value = +notice_value - 1;
                        $('#notification_number').text(notice_value);
                        $('#like_wall_item_' + like_id).fadeOut();
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Notification was hidden!'
                        }).show();
                    }
                }
            });
    });



    $(".hide_gift").click(function(e) {
        var gift_id=$(this).data('gift-id');
        var gift_user_name=$(this).data('gift-user-name');
        var url_hide_gift_notice='{{ URL::to('hide_gift_notice') }}';
        $.ajax({
            method: 'POST',
            url: url_hide_gift_notice,
            data: {gift_id:gift_id, _token: token},
            success: function (data) {
                if (data['status']) {
                    var notice_value = $('#notification_number').text();
                    notice_value = +notice_value - 1;
                    $('#notification_number').text(notice_value);
                    $('#gift_item_' + gift_id).fadeOut();
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Notification from '+gift_user_name+' was hidden!'
                    }).show();
                }
            }
        });
    });

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
                        var notice_value=$('#notification_number').text();
                        notice_value=+notice_value-1;
                        $('#notification_number').text(notice_value);
                        $('#friend_request_item_'+user_id).fadeOut();
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
                        var notice_value=$('#notification_number').text();
                        notice_value=+notice_value-1;
                        $('#notification_number').text(notice_value);
                        $('#friend_request_item_'+user_id).fadeOut();
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

    $(".hide_post_wall").click(function(e) {
        var post_id=$(this).data('post-id');
        var post_user_name=$(this).data('post-user-name');
        var url_hide_post_wall_notice='{{ URL::to('hide_post_wall_notice') }}';
        $.ajax({
            method: 'POST',
            url: url_hide_post_wall_notice,
            data: {post_id:post_id, _token: token},
            success: function (data) {
                if (data['status']) {
                    var notice_value = $('#notification_number').text();
                    notice_value = +notice_value - 1;
                    $('#notification_number').text(notice_value);
                    $('#post_wall_request_item_' + post_id).fadeOut();
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Notification from '+post_user_name+' was hidden!'
                    }).show();
                }
            }
        });
    });


    $(".hide_post_community").click(function(e) {
        var post_id=$(this).data('post-community-id');
        var community_id=$(this).data('community-id');
        var post_user_name=$(this).data('post-community-user-name');
        var url_hide_post_community_notice='{{ URL::to('hide_post_community_notice') }}';
        $.ajax({
            method: 'POST',
            url: url_hide_post_community_notice,
            data: {post_id:post_id,community_id:community_id, _token: token},
            success: function (data) {
                if (data['status']) {
                    var notice_value = $('#notification_number').text();
                    notice_value = +notice_value - 1;
                    $('#notification_number').text(notice_value);
                    $('#post_community_request_item_' + post_id).fadeOut();
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Notification from '+post_user_name+' was hidden!'
                    }).show();
                }
            }
        });
    });


    $(".hide_wall_comment").click(function(e) {
        var comment_id=$(this).data('comment-id');
        var post_id=$(this).data('post-id');
        var comment_user_name=$(this).data('comment-user-name');
        var url_hide_wall_comment_notice='{{ URL::to('hide_wall_comment_notice') }}';
        $.ajax({
            method: 'POST',
            url: url_hide_wall_comment_notice,
            data: {post_id:post_id,comment_id:comment_id, _token: token},
            success: function (data) {
                if (data['status']) {
                    var notice_value = $('#notification_number').text();
                    notice_value = +notice_value - 1;
                    $('#notification_number').text(notice_value);
                    $('#wall_comment_request_item_' + comment_id).fadeOut();
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Notification from '+comment_user_name+' was hidden!'
                    }).show();
                }
            }
        });
    });


    $(".hide_community_comment").click(function(e) {
        var comment_id=$(this).data('comment-id');
        var post_id=$(this).data('post-id');
        var comment_user_name=$(this).data('comment-user-name');
        var url_hide_community_comment_notice='{{ URL::to('hide_community_comment_notice') }}';
        $.ajax({
            method: 'POST',
            url: url_hide_community_comment_notice,
            data: {post_id:post_id,comment_id:comment_id, _token: token},
            success: function (data) {
                if (data['status']) {
                    var notice_value = $('#notification_number').text();
                    notice_value = +notice_value - 1;
                    $('#notification_number').text(notice_value);
                    $('#community_comment_request_item_' + comment_id).fadeOut();
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Notification from '+comment_user_name+' was hidden!'
                    }).show();
                }
            }
        });
    });

    $(".mark_community_wall").click(function(e) {
        var like_id=$(this).data('like-community-id');
        var like_post_id=$(this).data('like-community-post-id');
        var url_hide_like_wall_notice='{{ URL::to('hide_like_wall_notice') }}';
        var moduleId='2';
        $.ajax({
            method: 'POST',
            url: url_hide_like_wall_notice,
            data: {like_id: like_id,like_post_id:like_post_id,moduleId:moduleId, _token: token},
            success: function (data) {
                if (data['status']) {
                    var notice_value = $('#notification_number').text();
                    notice_value = +notice_value - 1;
                    $('#notification_number').text(notice_value);
                    $('#like_community_item_' + like_id).fadeOut();
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Notification was hidden!'
                    }).show();
                }
            }
        });
    });

    $(".mark_blog").click(function(e) {
        var like_id=$(this).data('like-blog-id');
        var like_post_id=$(this).data('like-blog-post-id');
        var url_hide_like_wall_notice='{{ URL::to('hide_like_wall_notice') }}';
        var moduleId='1';
        $.ajax({
            method: 'POST',
            url: url_hide_like_wall_notice,
            data: {like_id: like_id,like_post_id:like_post_id,moduleId:moduleId, _token: token},
            success: function (data) {
                if (data['status']) {
                    var notice_value = $('#notification_number').text();
                    notice_value = +notice_value - 1;
                    $('#notification_number').text(notice_value);
                    $('#like_blog_item_' + like_id).fadeOut();
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Notification was hidden!'
                    }).show();
                }
            }
        });
    });
</script>
@stop