@extends('layouts.admin')
@section ('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.css" rel="stylesheet">
    <style>
        .emoji_post img.emojione{
            height:20px;
            margin-left:10px;
        }
        #block_wall{
            margin-top:100px;
        }
    </style>
@endsection
@section ('General')
    <div class="col-xs-12 col-sm-12 w3-center tab_main_body" >
    <div class="col-xs-4 col-sm-4 w3-center" style="padding-top:50px;">
        <img style="border-radius: 30px;" width="160" height="160" src="{{$user->photo ? $path.$user->photo->path :$path."/images/noimage.png"}}" alt="">
    </div>
        <div class="col-xs-8 col-sm-8 w3-center" style="padding-top:50px;">
            <p style="background-color:white;color:grey;padding:10px 10px;font-size:30px;border-radius:20px;">Share your opinions and thoughts or participate in discussions on {{$user->name}}'s wall </p>
    </div>
    <div class="col-xs-10 col-sm-10 w3-center " id="block_wall">
        <h2><a href="{{ URL::to('users/' . $user->id ) }}">{{$user->name}}'s</a> wall</h2>
        <div class="col-xs-12 col-sm-12 w3-center" id="wall_form">
            <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Create post" onkeypress="return isNumberKey(event)" id="text" name="text"></p>
            <div  class=" col-xs-12 col-sm-12 " >
                <span onclick="showImageInput()" class="w3-left"><i data-container="body" data-placement="bottom" data-toggle="tooltip" title="Attach image" class="fa fa-picture-o" aria-hidden="true"></i></span>
                <a id="emojiBlockShow" style="font-size: 12px;" class="w3-left emoji_post">@emojione(':smile:') </a>

           <span id="emojiBlock" >
         <p  data-placement="top" data-container="body" data-toggle="emojiClassic" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':slight_smile:')</p>
        <p  data-placement="top"  data-container="body" data-toggle="emojiFlag" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':triangular_flag_on_post:')</p>
        <p  data-placement="top" data-container="body" data-toggle="emojiSport" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':person_bouncing_ball:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiAnimals" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':bear:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiClothes" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':shirt:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiEmojis" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':boy:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiFood" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':hamburger:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiHolidays" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':tada:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiOther" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':copyright:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiRest" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':carousel_horse:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiTravel" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':island:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiWeather" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':white_sun_small_cloud:')</p>
        </span>


                <div id="image_input" class="w3-hide col-xs-12 col-sm-12 w3-container">
                    <div  class=" col-xs-5 col-sm-5">
                        {!! Form::open(['method'=>'POST','action'=>'UserWallController@store', 'class'=>'dropzone','id'=>'my-awesome-dropzone'])!!}
                        {{ Form::hidden('user_id', Auth::id() ) }}
                        {{ Form::hidden('user_wall_id', $user->id ) }}
                        {!! Form::close() !!}
                    </div>
                    <div  class="col-xs-5 col-sm-5 w3-display-container" style="height:180px;">
                        <button class="w3-button w3-red w3-display-bottomleft w3-round-xxlarge" value="false" id='remove_image'>Remove image</button>
                    </div>
                </div>
            </div>
            <p><button class="w3-button w3-green" type="submit" id="send">ADD POST</button></p>
        </div>

        <div class="col-xs-12 col-sm-12 w3-center" id="wall_posts">
            @if(count($wall_posts)>0)
                @foreach($wall_posts as $post)
                    <div class="col-xs-12 col-sm-12 w3-center">
                        <div class='post_item post_item_{{$post->id}} col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2'>
                            <div class="col-xs-3 col-sm-3 w3-left">
                                <a href="{{ URL::to('users/' . $post->user->id ) }}" style="font-size:15px">
                                <img style="border-radius: 30px;" width="60" height="60" src="{{$post->user->photo ? $path.$post->user->photo->path :$path."/images/noimage.png"}}" alt="">
                           </a>
                            </div>
                            <div class="col-xs-6 col-sm-6 w3-left post_info">
                                <a href="{{ URL::to('users/' . $post->user->id ) }}" style="font-size:15px">
                                {{$post->user->name}}</a><br>
                                <span>{{$post->created_at}}</span>
                            </div>
                            @if($post->user->id==Auth::id())
                            <div class="col-xs-3 col-sm-3">
                                <span><i class="fa fa-edit del" aria-hidden="true" onclick="editPost({{$post->id}})" data-toggle="modal" data-target=".editPost"></i></span>
                                <span><i class="fa fa-trash-o del" aria-hidden="true" onclick="deletePost({{$post->id}})"></i></span>
                            </div>
                            @endif
                            <hr>
                            <hr><p id="post_item_text_{{$post->id}}">{!!$post->text!!}</p><hr>
                            <p class="post_image"><img style="border-radius: 30px;" src="{{$post->image ? $path.$post->image->photo->path :""}}" alt=""></p>

                            <hr><span id="itemid" data-item-id="{{$post->id}}" style="float:right;">
                           <a  data-like="{{$post->id}}" class="like button_like">{{Auth::user()->likes()->where('item_id',$post->id)->first() ? Auth::user()->likes()->where('item_id',$post->id)->first()->like==1 ?'You like this post':'Like':'Like' }}</a>
                            <a data-like="{{$post->id}}" class="like button_dislike">{{Auth::user()->likes()->where('item_id',$post->id)->first() ? Auth::user()->likes()->where('item_id',$post->id)->first()->like==0 ?'You dislike this post':'Dislike':'Dislike' }}</a>
                        </span><br>

                            <p class="w3-right">
                                <i class="fa fa-thumbs-up w3-text-green" aria-hidden="true"></i><span class="w3-text-green" id="like_icon_{{$post->id}}" >{{$post->like}}</span>
                                <i class="fa fa-thumbs-down w3-text-red" aria-hidden="true"></i><span class="w3-text-red" id="dislike_icon_{{$post->id}}" >{{$post->dislike}}</span>
                            </p>
                        <span onclick="showComments({{$post->id}})" style="float:left;">Comments
                            @if(count($post->comments)>0)
                                ({{count($post->comments)}})
                            @endif
                        </span>
                            <div id="comments_block_{{$post->id}}" class="w3-hide ">
                                <input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Comment now" id="comment_{{$post->id}}"  name="comment">
                                <button class="btn btn-small w3-green send_comment" data-post-id="{{$post->id}}" onclick="sendComments({{$post->id}})" type="submit" >SEND</button>
                                <div id="comments_list_{{$post->id}}">
                                    @foreach($post->comments as $comment)
                                        <div class="col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2 w3-center comment_item comment_item_{{$comment->id}}" onmouseover="showDeleteButtonComment({{$comment->id}})" onmouseout="hideDeleteButtonComment({{$comment->id}})">
                                            <div class="col-xs-3 col-sm-3 w3-left">
                                                <a href="{{ URL::to('users/' . $comment->user_id) }}">
                                                    <img style="border-radius: 20px;" height="40" src="{{$comment->user->photo ? $path.$comment->user->photo->path :$path."/images/noimage.png"}}" alt=""></a></div>
                                            <div class="col-xs-6 col-sm-6 comment_data">
                                                <a href="{{ URL::to('users/' . $comment->user_id) }}">
                                                    {{$comment->user->name}}</a><br>
                                                {{$comment->created_at}}<hr>
                                            </div>
                                            @if($comment->user->id==Auth::id())
                                                <div class="col-xs-3 col-sm-3">
                                                    <span><i class="fa fa-edit del_comment" aria-hidden="true" onclick="editComment({{$comment->id}},{{$post->id}})" data-toggle="modal" data-target=".editComment"></i></span>
                                                    <span><i class="fa fa-trash-o del_comment" aria-hidden="true" onclick="deleteComment({{$comment->id}},{{$post->id}})"></i></span>
                                                </div>
                                            @endif
                                            <div class="col-xs-12 col-sm-12 commt comment_item_text_{{$comment->id}}">{{$comment->comment}}</div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-xs-12 col-sm-12 w3-center" id="no_posts">
                    <p>No posts yet here</p>
                </div>
            @endif

        </div>
    </div>
    {{--Edit post list modal--}}
    <div class="modal fade w3-center editPost"  role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">EDIT POST</h4>
                </div>
                <div class="modal-body" id="editPost">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" value="" id="edit_post_submit"  data-dismiss="modal" onclick="editPostAjax()">Edit</button>
                </div>
            </div>
        </div>
    </div>

    {{--Edit comment list modal--}}
    <div class="modal fade w3-center editComment" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">EDIT COMMENT</h4>
                </div>
                <div class="modal-body" id="editComment">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" value="" id="edit_comment_submit"  data-dismiss="modal" onclick="editCommentAjax()">Edit</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>

        @if(Session::has('wall_change'))
                new Noty({
            type: 'success',
            layout: 'bottomLeft',
            text: '{{session('wall_change')}}'

        }).show();
        @endif
    </script>
    <script>
        var limit=3;
        var offset=5;
        var token='{{\Illuminate\Support\Facades\Session::token()}}';
        $(document).ready(function () {
            $('.post_item').mouseover(function() {
                $(this).find('.del').css('display', 'block')
            });
            $('.post_item').mouseleave(function() {
                $(this).find('.del').css('display', 'none')
            });


            $("#send").click(function(e) {
                e.preventDefault();
                var text=$('#text').val();
                var url_wall='{{ URL::to('wall_post_add') }}';
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                var dateTime = date+' '+time;
                var user_post_id='{{Auth::id()}}';
                var wall_user_id='{{$user->id}}';
                var image_sent=$('#remove_image').val();
                $.ajax({
                    method:'POST',
                    url:url_wall,
                    data:{text:text,wall_user_id:wall_user_id,user_post_id:user_post_id,image_sent:image_sent,_token:token},
                    success: function(data) {
                        if (data['status']) {
                            $('#no_posts').remove();
                            $('.dz-image-preview').hide();
                            $('#remove_image').hide();
                            $('#text').val('');
                            var post_id = data['post_id'];
                            var x = document.getElementById("image_input");
                            $('.dropzone').css('display','none');
                            x.className = x.className.replace(" w3-show", "");
                        var photo_image='{{$path}}'+data['image_path'];
                        var edit_button="<span><i class='fa fa-edit del' aria-hidden='true' onclick='editPost("+post_id+")' data-toggle='modal' data-target='.editPost'></i></span>";
                        var delete_post_button="<div class='col-xs-2 col-sm-2'>"+edit_button+"<span><i class='fa fa-trash-o del' aria-hidden='true' onclick='deletePost("+post_id+")'></i></span></div>";
                        var post_image_block="<p class='post_image'><img style='border-radius: 30px;' src='"+photo_image+"' ></p>";
                        var like_block= "<hr><span data-item-id='"+post_id+"' style='float:right;'><a  data-like='"+post_id+"' class='like button_like_"+post_id+"' onclick='actionLike("+post_id+",true)'>Like</a><a data-like='"+post_id+"' class='like button_dislike_"+post_id+"' onclick='actionLike("+post_id+",false)'>Dislike</a></span><br><p class='w3-right'><i class='fa fa-thumbs-up w3-text-green' aria-hidden='true'></i><span class='w3-text-green'id='like_icon_"+post_id+"' >0</span><i class='fa fa-thumbs-down w3-text-red' aria-hidden='true'></i><span class='w3-text-red' id='dislike_icon_"+post_id+"' >0</span></p>";
                        var comment_block="<div id='comments_block_"+post_id+"' class='w3-hide '><input class='w3-input w3-padding-16 w3-border' type='text' placeholder='Comment now' id='comment_"+post_id+"'><button class='btn btn-small w3-green send_comment' data-post-id='"+post_id+"' onclick='sendComments("+post_id+")' type='submit' >SEND</button><div id='comments_list_"+post_id+"'></div></div>";
                        $('<div class="col-xs-12 col-sm-12 w3-center">').html("<div class='post_item post_item_"+post_id+" col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2' onmouseover='showDeleteButton("+post_id+")' onmouseout='hideDeleteButton("+post_id+")'><div class='col-xs-3 col-sm-3 w3-left'><a href='{{$path}}/users/"+user_id+"' style='font-size:15px'><img style='border-radius: 30px;' width='60' height='60' src='"+"{{Auth::user()->photo ? $path.Auth::user()->photo->path :$path.'/images/noimage.png'}}"+"'/></a></div><div class='col-xs-7 col-sm-7 w3-left post_info'><a href='/users/"+user_id+"' style='font-size:15px'>{{Auth::user()->name}}</a><br><span>"+time+"</span></div>"+delete_post_button+"<hr><hr><p id='post_item_text_"+post_id+"'>"+text+"</p><hr>"+post_image_block+like_block+"<span onclick='showComments("+post_id+")' style='float:left;'>Comments</span>"+comment_block+"</div></div>").prependTo('#wall_posts');
                        new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'Your post is added!'
                            }).show();

                        }
                        offset += 1;
                    }
                });

            });
            //Loading posts functionality when scroll top
            var status=true;
            $(window).scroll(function() {
                if($(window).scrollTop() == $(document).height() - $(window).height()) {
                    var url_load_posts='{{ URL::to('wall_load_posts') }}';
                    var wall_user_id='{{$user->id}}';
                    if(status){
                        $('<span>').html('<img id="load_image"  src="{{$path}}/images/includes/loading.gif"></span>').appendTo('#wall_posts');
                    }
                    $.ajax({
                        method:'POST',
                        url:url_load_posts,
                        data: {
                            wall_user_id:wall_user_id,
                            numberOfPosts:limit,
                            offsetPosts:offset,
                            _token:token},
                        success: function(data) {
                            $('#load_image').remove();
                            if(data['data']!== 'undefined'){
                                status=false;
                            }
                            console.log(data['data']);
                            for(var i=0;i<data['data'].length;i++){
//                        alert(data['data'][i]['user']['photo']['path']);
                                if(data['data'][i]['user']['photo']['path']!=''){
                                    var photo='{{$path}}'+data['data'][i]['user']['photo']['path'];
                                }
                                var name=data['data'][i]['user']['name'];
                                var text=data['data'][i]['text'];
                                var time=data['data'][i]['created_at'];
                                var post_like=data['data'][i]['like'];
                                var post_id=data['data'][i]['id'];
                                var post_dislike=data['data'][i]['dislike'];
                                var post_button_like=data['data'][i]['button_like'];
                                var post_button_dislike=data['data'][i]['button_dislike'];
                                if(data['data'][i]['comments'].length>0){
                                    var comment_num="("+data['data'][i]['comments'].length+")";
                                }else{
                                    var comment_num="";
                                }

                                if(data['data'][i]['image']!=null){
                                    var photo_image='{{$path}}'+data['data'][i]['image']['photo']['path'];
                                    var post_image_block="<p class='post_image'><img style='border-radius: 30px;' src='"+photo_image+"' ></p>";
                                }else{
                                    var post_image_block="<p class='no-image'>No image</p>";
                                }
                                var user_id_post=data['data'][i]['user']['id'];
                                var current_user_id=data['current_user_id'];
                                if(user_id_post==current_user_id){
                                    var edit_button="<span><i class='fa fa-edit del' aria-hidden='true' onclick='editPost("+post_id+")' data-toggle='modal' data-target='.editPost'></i></span>";
                                    var delete_post_button="<div class='col-xs-3 col-sm-3'>"+edit_button+"<span><i class='fa fa-trash-o del' aria-hidden='true' onclick='deletePost("+post_id+")'></i></span></div>";
                                }else{
                                    var edit_button="";
                                    var delete_post_button="";
                                }
                                var like_block= "<hr><span data-item-id='"+post_id+"' style='float:right;'><a  data-like='"+post_id+"' class='like button_like_"+post_id+"' onclick='actionLike("+post_id+",true)'>"+post_button_like+"</a><a data-like='"+post_id+"' class='like button_dislike_"+post_id+"' onclick='actionLike("+post_id+",false)'>"+post_button_dislike+"</a></span><br><p class='w3-right'><i class='fa fa-thumbs-up w3-text-green' aria-hidden='true'></i><span class='w3-text-green'id='like_icon_"+post_id+"' >"+post_like+"</span><i class='fa fa-thumbs-down w3-text-red' aria-hidden='true'></i><span class='w3-text-red' id='dislike_icon_"+post_id+"' >"+post_dislike+"</span></p>";
                                var comment_block="<div id='comments_block_"+post_id+"' class='w3-hide '><input class='w3-input w3-padding-16 w3-border' type='text' placeholder='Comment now' id='comment_"+post_id+"'><button class='btn btn-small w3-green send_comment' data-post-id='"+post_id+"' onclick='sendComments("+post_id+")' type='submit' >SEND</button><div id='comments_list_"+post_id+"'></div></div>";
                                $('<div class="col-xs-12 col-sm-12 w3-center">').html("<div class='post_item post_item_"+post_id+" col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2' onmouseover='showDeleteButton("+post_id+")' onmouseout='hideDeleteButton("+post_id+")'><div class='col-xs-3 col-sm-3 w3-left'><a href='users/"+user_id_post+"' style='font-size:15px'><img style='border-radius: 30px;' width='60' height='60' src='"+photo+"'/></a></div><div class='col-xs-6 col-sm-6 w3-left post_info'><a href='users/"+user_id_post+"' style='font-size:15px'>"+name+"</a><br><span>"+time+"</span></div>"+delete_post_button+"<hr><hr><p id='post_item_text_"+post_id+"'>"+text+"</p><hr>"+post_image_block+like_block+"<span onclick='showComments("+post_id+")' style='float:left;'>Comments"+comment_num+"</span>"+comment_block+"</div></div>").appendTo('#wall_posts');
                                for(var j=0;j<data['data'][i]['comments'].length;j++){
                                    var photo_comment='{{$path}}'+data['data'][i]['comments'][j]['user']['photo']['path'];
                                    var user_comment=data['data'][i]['comments'][j]['user']['name'];
                                    var comment=data['data'][i]['comments'][j]['comment'];
                                    var comment_created_at=data['data'][i]['comments'][j]['created_at'];
                                    var comment_id=data['data'][i]['comments'][j]['id'];
                                    var user_id=data['data'][i]['comments'][j]['user']['id'];
                                    if(user_id==current_user_id){
                                        var edit_button="<span><i class='fa fa-trash-o del_comment' aria-hidden='true' onclick='deleteComment("+comment_id+","+post_id+")'></i></span>";
                                        var delete_post_button="<div class='col-xs-3 col-sm-3'><span><i class='fa fa-edit del_comment' aria-hidden='true' onclick='editComment("+comment_id+","+post_id+")' data-toggle='modal' data-target='.editComment'></i></span>"+edit_button+"</div>";
                                    }else{
                                        var edit_button="";
                                        var delete_post_button="";
                                    }
                                    var comment_list="<div class='col-xs-3 col-sm-3 w3-left'><a href='/users/"+user_id+"'><img style='border-radius: 20px;' height='40' src='"+photo_comment+"'></a></div><div class='col-xs-6 col-sm-6 comment_data'><a href='/users/"+user_id+"'>"+user_comment+"</a><br>"+comment_created_at+"<hr></div>"+delete_post_button+"<div class='col-xs-12 col-sm-12 commt comment_item_text_"+comment_id+"'>"+comment+"</div>";
                                    $('<div class="col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2 w3-center  comment_item comment_item_'+comment_id+'" onmouseover="showDeleteButtonComment('+comment_id+')" onmouseout="hideDeleteButtonComment('+comment_id+')">').html(comment_list+"</div>").appendTo('#comments_list_'+post_id);
                                }
                            }

                        }
                    });
                    offset+=3;
                }
            });


            //Changing value of likes icon on like action click
            $(".button_like").click(function (e) {
                var btn_text=$(this).text();
                var btn_text_sibling=$(this).parent().find('.button_dislike').text();
                var btn_id=$(this).data('like');
                var icon_text=$('#like_icon_'+btn_id).text();
                var dislike_icon_text=$('#dislike_icon_'+btn_id).text();
                if(btn_text=='Like'){
                    if(btn_text_sibling!='Dislike'){
                        if(dislike_icon_text=='0'){
                            $('#dislike_icon_'+btn_id).text('0');
                        }else{
                            dislike_icon_text=+dislike_icon_text-1;
                            $('#dislike_icon_'+btn_id).text(dislike_icon_text);
                        }
                    }
                    icon_text=+icon_text+1;
                    $('#like_icon_'+btn_id).text(icon_text);
                }else{
                    icon_text=+icon_text-1;
                    $('#like_icon_'+btn_id).text(icon_text);
                }
            });

            //Changing value of dislikes icon on dislike action click
            $(".button_dislike").click(function (e) {
                var btn_text=$(this).text();
                var btn_text_sibling=$(this).parent().find('.button_dislike').text();
                var btn_id=$(this).data('like');
                var icon_text=$('#dislike_icon_'+btn_id).text();
                var like_icon_text=$('#like_icon_'+btn_id).text();
                if(btn_text=='Dislike'){
                    if(btn_text_sibling!='Like'){
                        if(like_icon_text=='0'){
                            $('#like_icon_'+btn_id).text('0');
                        }else {
                            like_icon_text = +like_icon_text - 1;
                            $('#like_icon_' + btn_id).text(like_icon_text);
                        }
                    }
                    icon_text=+icon_text+1;
                    $('#dislike_icon_'+btn_id).text(icon_text);
                }else{
                    icon_text=+icon_text-1;
                    $('#dislike_icon_'+btn_id).text(icon_text);
                }
            });


        });
    </script>
    <script>
        function showDeleteButton(id){
            $('.post_item_'+id).find('.del').css('display', 'block');
        }
        function hideDeleteButton(id){
            $('.post_item_'+id).find('.del').css('display', 'none');
        }
        function showDeleteButtonComment(id){
            $('.comment_item_'+id).find('.del_comment').css('display', 'block');
        }
        function hideDeleteButtonComment(id){
            $('.comment_item_'+id).find('.del_comment').css('display', 'none');
        }

        //Display comments block for post
        function showComments(id) {
            var x = document.getElementById("comments_block_"+id);
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
        }


        //Display image input
        $('.dropzone').css('display','none');
        function showImageInput() {
            var x = document.getElementById("image_input");
            if (x.className.indexOf("w3-show") == -1) {
                $('.dropzone').css('display','block');
                x.className += " w3-show";
            } else {
                $('.dropzone').css('display','none');
                x.className = x.className.replace(" w3-show", "");
            }
        }
    </script>
    <script>
        function sendComments(id) {
            var post_id=id;
            var comment=$('#comment_'+post_id).val();
            var wall_user_id='{{$user->id}}';
            var url_add_comment='{{ URL::to('wall_comment_add') }}';
            var module_id='5';
            var module_name='UserWall';
            var today = new Date();
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var dateTime = date+' '+time;
            var user_id='{{Auth::id()}}';
            $.ajax({
                method:'POST',
                url:url_add_comment,
                data:{comment:comment,wall_user_id:wall_user_id,post_id:post_id,module_id:module_id,module_name:module_name,user_id:user_id,_token:token},
                success: function(data) {
                    if(data['status']) {
                        $('#comment_'+post_id).val('');
                        var comment_id=data['comment_id'];
                        var user_id=data['user_id'];
                        $('<div class="col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2 w3-center comment_item comment_item_'+comment_id+'" onmouseover="showDeleteButtonComment('+comment_id+')" onmouseout="hideDeleteButtonComment('+comment_id+')">').html("<div class='col-xs-3 col-sm-3 w3-left'><a href='/users/"+user_id+"'><img style='border-radius: 20px;' height='40' src='" + "{{Auth::user()->photo ? $path.Auth::user()->photo->path :$path.'/images/noimage.png'}}" + "'/></a></div><div class='col-xs-6 col-sm-6 comment_data'><a href='/users/"+user_id+"'>{{Auth::user()->name}}</a><br>"+dateTime+"<hr></div><div class='col-xs-3 col-sm-3'><span><i class='fa fa-trash-o del_comment' aria-hidden='true' onclick='deleteComment("+comment_id+","+post_id+")'></i></span><span><i class='fa fa-edit del_comment' aria-hidden='true' onclick='editComment("+comment_id+","+post_id+")' data-toggle='modal' data-target='.editComment'></i></span></div><div class='col-xs-12 col-sm-12 commt comment_item_text_"+comment_id+"'>" + comment + "</div></div>").appendTo('#comments_list_'+post_id);
                    }
                }
            });

        }


        function deletePost(id) {
            var post_id=id;
            var wall_user_id='{{$user->id}}';
            var url_delete_post='{{ URL::to('wall_post_delete') }}';
            var conf=confirm("Do you want to delete this post?");
            if(conf){
                $.ajax({
                    method:'POST',
                    url:url_delete_post,
                    data:{post_id:post_id,wall_user_id:wall_user_id,_token:token},
                    success: function(data) {
                        if(data['status']) {
                            var post_id=data['post_id'];
                            console.log(data['t']);
                            $('.post_item_'+post_id).remove();
                            new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text:'Post was successfully deleted!'
                            }).show();
                        }
                    }
                });
            }
        }


        function deleteComment(id,post_id) {
            var post_id=post_id;
            var comment_id=id;
            var wall_user_id='{{$user->id}}';
            var url_delete_comment='{{ URL::to('wall_comment_delete') }}';
            var conf=confirm("Do you want to delete this comment?");
            if(conf){
                $.ajax({
                    method:'POST',
                    url:url_delete_comment,
                    data:{post_id:post_id,wall_user_id:wall_user_id,comment_id:comment_id,_token:token},
                    success: function(data) {
                        if(data['status']) {
                            var comment_id=data['comment_id'];
                            console.log(data['t']);
                            $('.comment_item_'+comment_id).remove();
                            new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text:'Comment was successfully deleted!'
                            }).show();
                        }
                    }
                });
            }
        }

        function editPost(id) {
            var post_text=$('#post_item_text_'+id).html();
            $('#editPost').html('<textarea  cols="60" rows="4" onpaste="return forbiddenInsert(event)"  onkeypress="return isNumberKey(event)" class=" post_edit_textarea"  name="post_edit_textarea"></textarea>');
            $('.post_edit_textarea').html(post_text);
            $('#edit_post_submit').val(id);

        }
        function editComment(comment_id,post_id) {

            var comment_text=$('.comment_item_text_'+comment_id).html();
            $('#editComment').html('<textarea  cols="60" rows="4"  class="comment_edit_textarea"  name="comment_edit_textarea"></textarea>');
            $('.comment_edit_textarea').text(comment_text);
            $('#edit_comment_submit').val(comment_id+"_"+post_id);
        }
        function editPostAjax() {
            var post_id=$('#edit_post_submit').val();
            var wall_user_id='{{$user->id}}';
            var post_text=$('.post_edit_textarea').val();
            var url_edit_post='{{ URL::to('wall_post_edit') }}';
            $.ajax({
                method:'POST',
                url:url_edit_post,
                data:{post_id:post_id,wall_user_id:wall_user_id,post_text:post_text,_token:token},
                success: function(data) {
                    if(data['status']) {
                        $('#post_item_text_'+post_id).html(post_text);
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text:'Post was successfully edited!'
                        }).show();
                    }
                }
            });
        }
        function editCommentAjax() {
            var comment_post_both=$('#edit_comment_submit').val();

            var arr = comment_post_both.split("_");
            var comment_id=arr[0];
            var post_id=arr[1];
            var wall_user_id='{{$user->id}}';
            var comment_text=$('.comment_edit_textarea').val();
            var url_edit_comment='{{ URL::to('wall_comment_edit') }}';
            $.ajax({
                method:'POST',
                url:url_edit_comment,
                data:{post_id:post_id,comment_id:comment_id,wall_user_id:wall_user_id,comment_text:comment_text,_token:token},
                success: function(data) {
                    if(data['status']) {

                        $('.comment_item_text_'+comment_id).html(comment_text);
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text:'Comment was successfully edited!'
                        }).show();
                    }
                }
            });
        }
    </script>
@endsection
@section ('scripts')
    <script>
        window.onload = function() {
            var myInput = document.getElementById('text');
            myInput.onpaste = function(e) {
                e.preventDefault();
            }
        }
        function forbiddenInsert(event) {
                event.preventDefault();
        }
        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode == 36 || charCode == 60 || charCode == 62)
                return false;
            return true;
        }
    </script>
    <script>
        $(document).ready(function () {
            var blnStatus=false;
            $('#emojiBlockShow').on('click', function() {
                if(blnStatus){
                    $('#emojiBlockShow').html('@emojione(':smile:')');
                    blnStatus=false;
                }else{
                    $('#emojiBlockShow').html('@emojione(':x:')');
                    blnStatus=true;
                }

                $('#emojiBlock').toggle();
            });
        });
    </script>
    <script>
        var token='{{\Illuminate\Support\Facades\Session::token()}}';
        var url='{{ URL::to('likes') }}';
        var moduleId='5';
        var moduleName='UserWall';
    </script>
    <script src="{{asset('js/ajax-likes.js')}}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.js"></script>
            <script>
                //File Upload response from the server
                $('#remove_image').css('display','none');
                Dropzone.options.myAwesomeDropzone = {
                    accept: function(file, done) {
                        $('#remove_image').css('display','inline-block');
                        $('#remove_image').val('true');
                        console.log("uploaded");
                        done();
                    },
                    init: function() {
                        this.on("addedfile", function() {
                            if (this.files[1]!=null){
                                this.removeFile(this.files[0]);
                            }
                        });
                    }
                };

                //Deleting post image before post current item
                $("#remove_image").click(function(e) {
                    var user_id='{{Auth::id()}}';
                    var user_wall_id='{{$user->id}}';
                    var url_delete_user_wall_post_image='{{ URL::to('delete_user_wall_post_image') }}';
                    $.ajax({
                        method:'POST',
                        url:url_delete_user_wall_post_image,
                        data:{user_wall_id:user_wall_id,user_id:user_id,_token:token},
                        success: function(data) {
                            $('.dz-image-preview').hide();
                            $('#remove_image').css('display','none');
                            $('#remove_image').val('false');
                            if(data['status']){
                                new Noty({
                                    type: 'warning',
                                    layout: 'topRight',
                                    text: 'Image was removed!'

                                }).show();
                            }

                        }
                    });

                });
            </script>
@stop