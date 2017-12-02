@extends('layouts.admin')
@section ('styles')

   <style>
       a{color:#6F95EC;}
   </style>
@endsection
@section ('General')

    <div class="w3-row ">
        <div class="w3-col s9 m9 l9 main_window border_right">
        <div class="w3-col s4 m4 l4" style="padding-right:15px;">
           <div class="w3-center">
               @if($user->photo)
               <a data-toggle="modal" data-target="#myModal"><img style="border-radius: 20px;width:100%;" src="{{$path.$user->photo->path }}" alt=""></a>
               @else
               <div style='border-radius: 20px;'>
                <p  id='add_image' class='w3-hover-opacity' style="height:200px;background-repeat: no-repeat;background-size: 250px 250px;background-image:url('{{$path."/images/noimage.png"}}')">
                   @if($user->id==Auth::id() || Auth::user()->role_id=='1')
                   <a href="{{ URL::to('users/' . $user->id.'/edit' ) }}" style='height:100%;text-decoration:none;'>
                        <i id='add_image_icon' style='position:relative;top:100px;display:none;font-size:30px;color:gray;' class=" fa fa-plus-circle" aria-hidden="true"></i></a>
                @endif
                </p>
                </div>
               @endif
               </div>
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            @if(isset($user->photo) )
                            <img style="border-radius: 20px;" height="500" src="{{$path.$user->photo ? $path.$user->photo->path :$path."/images/noimage.png"}}" alt="">
                            <button class='btn btn-small btn-danger w3-display-topright' id='close_image'>Close</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="buttons w3-center">
                @if($user->id==Auth::id() || Auth::user()->role_id=='1')
                <a href="{{ URL::to('users/' . $user->id.'/edit' ) }}">
                    <i  data-container="body" data-placement="bottom" data-toggle="tooltip" title="Edit profile" class="fa fa-pencil-square-o" style="font-size:36px"></i>
                </a>
                @endif
                @if($user->id==Auth::id())
                <a href="{{ URL::to('chat/' ) }}">
                    <i  data-container="body" data-placement="bottom" data-toggle="tooltip" title="All messages" class="fa fa-envelope-o" style="font-size:36px"></i>
                </a>
                @else
                <a href="{{ URL::to('chat/'.$user->id ) }}">
                    <i  data-container="body" data-placement="bottom" data-toggle="tooltip" title="All messages" class="fa fa-envelope-o" style="font-size:36px"></i>
                </a>
                @endif
                    <a href="{{URL::to('friends/'.$user->id)}}" >
                    <i  data-container="body" data-placement="bottom" data-toggle="tooltip" title="List of friends" class="fa fa-group" style="font-size:36px"></i>
                </a>
                <a href="{{URL::to('image/'.$user->id)}}" >
                    <i  data-container="body" data-placement="bottom" data-toggle="tooltip" title="All images" class="fa fa-image" style="font-size:36px"></i>
                </a>
                <div class="w3-center" id="show_friend_status">

                    <audio id="noty_audio">
                        <source src="{{ asset('audio/notify.mp3') }}">
                        <source src="{{ asset('audio/notify.ogg') }}">
                        <source src="{{ asset('audio/notify.wav') }}">
                    </audio>
                    @if(Auth::id() !==$user->id)

                        <friend :current_user_id="{{$user->id}}"></friend>

                    @endif
                </div>
                <div>
                    @if(Auth::user()->isFriendWith($user->id))
                        <div class="delete-friend-main" id="delete-friend-main">
                        <button id="delete-friend" class='w3-text-white w3-red'><i class="fa fa-times-circle-o" aria-hidden='true' ></i></button>
                        <a class=" w3-text-red" >Delete from friends</a>
                            </div>
                        @endif
                </div>
                <div class="w3-center">
                   <h5> Registered on site {{$user->created_at->diffForHumans()}}</h5>

                    @if($online)
                        <p>Online</p>
                    @else
                        <p>Offline</p>
                    @endif

                </div>
            </div>


        </div>
        <div class="w3-col s8 m8 l8">
            <h1>{{$user->name}}
                @if(isset($user->profile->lastname))
                    {{$user->profile->lastname}}
                @endif
            </h1>

            <div class="row">
                <div class="col-xs-8">
<div id="status">

        @if(isset($user->profile->status) && $user->profile->status=='0')
        <p class="input-group" id="status-form">
            <input type="text" class="form-control" id="status-value" maxlength="30" placeholder="Type your status ...">
        <span class="input-group-btn">
        <button class="btn btn-success" type="submit" id="status-button">
         ADD
        </button>
        </span>
        </p>
        @if($user->id==Auth::id() || Auth::user()->role_id=='1')
            <p id="edit-status-buttons">
                <span id="edit-status"></span>
                <span id="delete-status" class="w3-text-red"></span>
            </p>
            @endif
    @endif
    @if(isset($user->profile->status) && !empty($user->profile->status))
                <p class="input-group" id="status-form-on-delete">
                    <input type="text" class="form-control" id="status-value" maxlength="30" placeholder="Type your status ...">
        <span class="input-group-btn">
        <button class="btn btn-success" type="submit" id="status-button">
         ADD
        </button>
        </span>
                </p>
     <p class="input-group status-text" id="status-form" data-value="{{$user->profile->status}}">
                   " {{$user->profile->status}} "

    </p>
    @if($user->id==Auth::id() || Auth::user()->role_id=='1')
<p id="edit-status-buttons">
    <span id="edit-status"><i class='fa fa-edit' aria-hidden='true'></i></span>
    <span id="delete-status" class='w3-text-red'><i class='fa fa-close' aria-hidden='true' ></i></span>
</p>
@endif


        @else
        @if($user->id==Auth::id())
        <p class="input-group" id="status-form">
        <input type="text" class="form-control" id="status-value" maxlength="30" placeholder="Type your status ...">
        <span class="input-group-btn">
        <button class="btn btn-success" type="submit" id="status-button">
         ADD
        </button>
        </span>
        </p>
        @if($user->id==Auth::id() || Auth::user()->role_id=='1')
            <p id="edit-status-buttons">
                <span id="edit-status"></span>
                <span id="delete-status" class="w3-text-red"></span>
            </p>
            @endif
        @endif
        @endif

</div>
</div>
</div>
<table class="w3-table">
<tr>
<td>First Name:</td>
<td>
    @if(isset($user->name) && !empty($user->name))
    {{$user->name}}
    @else
    No info
    @endif
</td>
</tr>
<tr>
<td>Last Name:</td>
<td>
    @if(isset($user->profile->lastname) && !empty($user->profile->lastname))
        {{$user->profile->lastname}}
    @else
        No info
    @endif
</td>
</tr>
<tr>
<td>Date of Birth:</td>
<td> @if(isset($user->profile->birthdate) && !empty($user->profile->birthdate))
        {{$user->profile->birthdate}}
    @else
        No info
    @endif
</td>
</tr>
<tr>
<td>Gender:</td>
<td>
    @if(isset($user->profile->user_gender) && !empty($user->profile->user_gender))
        @if($user->profile->user_gender=="M")
            Male
        @else
            Female
        @endif
    @else
        No info
    @endif
</td>
</tr>


</table>
<hr>
<div id="detailLink"><a href="#" id="showFullDetails" data-value="false">Show full details</a></div>
<hr>
<div id="FullDetails">
<table class="w3-table">
    <tr>
        <td>Email:</td>
        <td>
            @if(isset($user->email) && !empty($user->email))
                {{$user->email}}
            @else
                No info
            @endif
        </td>
    </tr>
    <tr>
        <td>Country:</td>
        <td>
            @if(isset($country) && !empty($country))
                {{$country}}
            @else
                No info
            @endif
        </td>
    </tr>
    <tr>
        <td>City:</td>
        <td>
            @if(isset($user->profile->city) && !empty($user->profile->city))
                {{$user->profile->city}}
            @else
                No info
            @endif
        </td>
    </tr>

</table>
</div>

</div>
 <div class="w3-col s12 m12 l12 w3-center " id="image_profile_block">
                <div class="w3-col m4 l4 w3-center"> <a href="{{URL::to('friends/'.$user->id)}}" >{{count($user->friends())>0? count($user->friends()):0 }} </br> friends</a></div>
                <div class="w3-col m4 l4 w3-center"><a href="{{URL::to('image/'.$user->id)}}" >{{$images!=false ? count($images):0 }}</br> images</a></div>
                <div class="w3-col m4 l4 w3-center"><a href="{{ URL::to('blog/' . $user->id ) }}" style="font-size:15px">{{$posts!=false ? count($posts):0 }}</br> posts</a></div>
                @include('admin.users.user_images')
  </div>
            <div class="w3-col s12 m12 l12 w3-center" style="min-height:200px;" id="wall_profile_block">
                <a href="{{URL::to('wall/'.$user->id)}}" >Go to {{$user->name}}'s</a> wall
            </div>
            <div class="w3-col s12 m12 l12 " id="gifts">
                @if($user->id!=Auth::id())
                <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#giftsList">SEND GIFT</button>
                @endif
                <div class="w3-col s12 m12 l12 w3-center" id="giftLast">
                    @if(count($giftsUser)>0)
                        @foreach($giftsUser as $gift)
                    <span class=" w3-center" id="gift_image_item_{{$gift->id}}">
                        <img width='150' src="{{$gift->gift_path}}"  alt='' />
                    </span>
                        @endforeach
                    <div class=" w3-center" id="view_more">
                    <i data-container="body" data-placement="bottom" data-toggle="tooltip" title="View all gifts" class="fa fa-angle-double-right" onclick="changeActiveTab('Gifts')" style="font-size:60px;color:gray;margin-top:20px;"></i>
                     </div>
                        @else
                        <p>{{$user->name}} hasn't recieved any gift yet!</p>
                        @endif
                </div>
                <div class="w3-col s12 m12 l12 w3-center w3-hide" id="giftForm">
                   <p><img width='150' src="" id="gift_image" alt='' /></p>
                    <p><input type="hidden" id="gift_path" name="gift_path" value="">
                    <textarea  cols="30" rows="4" id="gift_text"  name="gift_text"></textarea></p>
                    <a class="btn btn-sm btn-success" id="sendGift">SEND</a>
                </div>

                {{--Gifts list modal--}}
                <div class="modal fade w3-center" id="giftsList" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">GIFTS LIST</h4>
                            </div>
                            <div class="modal-body">
                                @foreach($gifts as $dir)
                                    <img width="200" src="{{$path}}/images/gifts/{{$dir}}" onclick="giftDir('{{$path}}/images/gifts/{{$dir}}')" alt="" />
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  </div>



<div class="w3-col s3 m3 l3 right-sidebar "  id="right-sidebar">

@include('admin.users.right_sidebar')
</div>
</div>
<script>
$(function() {
var top1 = $('#right-sidebar').offset().top+10- parseFloat($('#right-sidebar').css('marginTop').replace(/auto/, 0));
var footTop1 = $('#footer').offset().top-50- parseFloat($('#footer').css('marginTop').replace(/auto/, 0));

var maxY1 = footTop1 - $('#right-sidebar').outerHeight();

$(window).scroll(function(evt) {
var y1 = $(this).scrollTop();
if (y1 > top1) {
if (y1 < maxY1) {
    $('#right-sidebar').addClass('fixedr').removeAttr('style');
} else {
    $('#right-sidebar').removeClass('fixedr').css({
        right: 0,
    position: fixed

    });
}
} else {
$('#right-sidebar').removeClass('fixedr');
}
});
});
</script>
<script>
$(document).ready(function(){
        $("#add_image").hover(function(){
          $("#add_image_icon").css('display','inline');
        },function(){
          $("#add_image_icon").css('display','none');
        }
        );
});


$(document).ready(function(){
$("#showFullDetails").click(function(){
var showDetails=document.getElementById('showFullDetails').dataset['value'];
if(showDetails=='false'){
$("#FullDetails").toggle();
document.getElementById('showFullDetails').dataset['value']=true;
$(this).text('Hide details');
}else{
$("#FullDetails").toggle();
$(this).text('Show full details');
document.getElementById('showFullDetails').dataset['value']=false;
}
});


    $("#sendGift").click(function() {
        var gift_image_path=$('#gift_path').val();
        var gift_text=$('#gift_text').val();
        var user_receiver_id='{{$user->id}}';
        var user_sender_id='{{Auth::id()}}';
        var url_send_gift='{{ URL::to('send_gift') }}';
            $.ajax({
                method:'POST',
                url:url_send_gift,
                data:{user_receiver_id:user_receiver_id,user_sender_id:user_sender_id,gift_image_path:gift_image_path,gift_text:gift_text,_token:token},
                success: function(data) {
               if(data['status']){
                   var giftCount='{{count($giftsUser)}}';
                   var gift_image_path=data['gift_image_path'];
                   var x = document.getElementById("giftForm");
                   if (x.className.indexOf("w3-show") == -1) {
                       x.className += " w3-show";
                   } else {
                       x.className = x.className.replace(" w3-show", "");
                   }
                   if(giftCount==0){
                       $('#giftLast').html('');
                   }
                   $('<span class=" w3-center" >').html("<img width='150' src='"+gift_image_path+"'  alt='' />"+"</span>").prependTo('#giftLast');
                   if(giftCount==0){
                       $('<div class=" w3-center" id="view_more">').html('<i data-container="body" data-placement="bottom" data-toggle="tooltip" title="View all gifts" class="fa fa-angle-double-right" onclick="changeActiveTab(\'Gifts\')" style="font-size:60px;color:gray;margin-top:20px;"></i></div>').appendTo('#giftLast');
                   }
                   new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Gift was successfully sent!'
                        }).show();
                    }

                }
            });

    });
});
</script>
    <script>
        @if(Session::has('user_change'))
                new Noty({
            type: 'warning',
            layout: 'topRight',
            text: '{{session('user_change')}}'

        }).show();
        @endif
    </script>
<script>
var token='{{\Illuminate\Support\Facades\Session::token()}}';
var url='{{ URL::to('status') }}';
var url_unfriend ='{{ URL::to('unfriend_user') }}';
var url_edit='{{ URL::to('edit_status') }}';
var url_delete='{{ URL::to('delete_status') }}';
var user_id='{{ $user->id }}';
var user_name='{{ $user->name }}';
</script>

    <script>
        function giftDir(path) {
            $('#giftsList').modal('hide');
            var x = document.getElementById("giftForm");
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
            $("#gift_image").attr("src", path);
            $("#gift_path").val(path);

        }

        function changeActiveTab(tab){
            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        };

    </script>

@stop
@section ('Gifts')
    <div class="w3-col m12 l12">
        @if(count($giftsUser)==0)
            <div class="w3-xxlarge w3-padding-16 w3-center">{{$user->name}} hasn't any gifts yet!</div>
        @else
            <div class="w3-xxlarge w3-padding-16 w3-center w3-col m12 l12">

                    @foreach($giftsUser as $gift)
                        <div class="w3-col m3 l3 gift_item_main" id="gift_item_main_{{$gift->id}}">
                        <aside class="gift_item" >
                           <p> <img style="height:200px;object-fit:cover;border-radius: 20px;" src='{{$gift->gift_path}}'></p>
                        <p class="gift_desc">{{$gift->gift_text}}</p><hr>
                        <p class="gift_desc"><a href="{{URL::to('users/'.$gift->user->id)}}" >{{$gift->user->name}}</a> sent this gift<br>{{$gift->created_at->diffForHumans()}}</p>
                            @if($gift->user->id==Auth::id() || $user->id==Auth::id() || Auth::user()->role_id=='1')
                            <p class="gift_desc" ><a class="deleteGift" data-gift-id="{{$gift->id}}">Delete</a></p>
                            @endif
                        </aside>
                        </div>
                    @endforeach
            </div>
        @endif
    </div>

@endsection
@section ('scripts')
<script>
    $(function () {
$('#close_image').click(function() {
   $('#myModal').modal('hide');
    });        
   
});
</script>
    <script>
        $(".deleteGift").click(function() {
            var token='{{\Illuminate\Support\Facades\Session::token()}}';
            var gift_id=$(this).data('gift-id');
            var url_delete_gift='{{ URL::to('delete_gift') }}';
            $.ajax({
                method:'POST',
                url:url_delete_gift,
                data:{gift_id:gift_id,_token:token},
                success: function(data) {
                    if(data['status']){
                var gift_id=data['gift_id'];
                        $('#gift_item_main_'+gift_id).remove();
                        $('#gift_image_item_'+gift_id).remove();
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Gift was successfully deleted!'
                        }).show();
                    }

                }
            });

        });

    </script>
<script src="{{asset('js/ajax-functions.js')}}"></script>
@endsection