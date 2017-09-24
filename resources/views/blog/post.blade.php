@extends('layouts.admin')
@section('General')



            <div class="w3-row ">
                <div class="w3-col m12 l12 w3-center">
                    <img style="border-radius: 20px;width:100%;max-height:600px;object-fit:cover;"  src="{{$post->photo ? $path.$post->photo->path :$path."/images/noimage.png"}}" alt="">
                </div>
                <div class="w3-col m12 l12" id="post_info_item">
                <span>
                    Posted by <a href="{{ URL::to('users/' . $post->user->id) }}">{{$post->user ? $post->user->name : "No owner"}}</a>
                </span>
                        <span class="w3-right">Post category: {{$post->category ? $post->category->name: "Uncategorized"}}</span>
                    <div>
                <span>
                    Created: {{$post->created_at->diffForHumans()}}    |
                    Updated: {{$post->updated_at->diffForHumans()}}
                </span>
                <span>
                    @if($post->user_id==Auth::id())
                        <a href="{{ URL::to('posts/' . $post->id . '/edit') }}" class="w3-right ">Edit</a>
                    @endif
                </span>
                    </div>
                    </div>

                    <div class="w3-col m12 l12 w3-center">
                        <hr>
                        <h1>{{strtoupper($post->title)}}</h1>
                        <p>{!! $post->body !!}</p>
                    </div>

                    <div>
                  <div class="w3-col m12 l12 w3-center"><hr>
                <span id="itemid" data-item-id="{{$post->id}}" style="float:right;">
                           <a  data-like="{{$post->id}}" class="like button_like">{{Auth::user()->likes()->where('item_id',$post->id)->first() ? Auth::user()->likes()->where('item_id',$post->id)->first()->like==1 ?'You like this post':'Like':'Like' }}</a>
                            <a data-like="{{$post->id}}" class="like button_dislike">{{Auth::user()->likes()->where('item_id',$post->id)->first() ? Auth::user()->likes()->where('item_id',$post->id)->first()->like==0 ?'You dislike this post':'Dislike':'Dislike' }}</a>
                        </span><br>
                        <p class="w3-right">
                            <i class="fa fa-thumbs-up w3-text-green" aria-hidden="true"></i><span class="w3-text-green" id="like_icon_{{$post->id}}" >{{$post->like}}</span>
                            <i class="fa fa-thumbs-down w3-text-red" aria-hidden="true"></i><span class="w3-text-red" id="dislike_icon_{{$post->id}}" >{{$post->dislike}}</span>
                        </p>   <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox w3-right"></div>
                    </div>

                    </div>
                    <hr>
                <div id="comments_block_{{$post->id}}" class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 w3-center" style="margin-bottom: 30px;">
                   <div id="comments_list" >
                        @foreach($post->comments as $comment)
                            <div class="col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2 w3-center comment_item comment_item_{{$comment->id}}">
                                <div class="col-xs-3 col-sm-3 w3-left">
                                 <a href="{{ URL::to('users/' . $comment->user_id) }}">
                                <img style="border-radius: 20px;" height="40" src="{{$comment->user->photo ? $path.$comment->user->photo->path :$path."/images/noimage.png"}}" alt=""></a></div>
                                <div class="col-xs-7 col-sm-7 comment_data">
                                <a href="{{ URL::to('users/' . $comment->user_id) }}">
                                 {{$comment->user->name}}</a><br>
                                 {{$comment->created_at}}<hr>
                                </div>
                                  @if($comment->user->id==Auth::id())
                                <div class="col-xs-2 col-sm-2">
                                <span><i class="fa fa-edit del" aria-hidden="true" onclick="editComment({{$comment->id}})" data-toggle="modal" data-target=".editComment"></i></span>
                                <span><i class="fa fa-trash-o del" aria-hidden="true" onclick="deleteComment({{$comment->id}})"></i></span>
                                </div>
                                    @endif
                                <div class="col-xs-12 col-sm-12 commt comment_item_text_{{$comment->id}}">{{$comment->comment}}</div>
                            </div>
                        @endforeach
                    </div>
               </div>
                <div class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 w3-center">
                <input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Comment now" id="comment_{{$post->id}}"  name="comment">
                <p class="w3-center"><button class="btn btn-small w3-green send_comment " data-post-id="{{$post->id}}" onclick="sendComments({{$post->id}})" type="submit" >SEND</button></p>
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

            <script>
                $(document).ready(function () {
                    $('.comment_item').mouseover(function() {
                        $(this).find('.del').css('display', 'block')
                    });
                    $('.comment_item').mouseleave(function() {
                        $(this).find('.del').css('display', 'none')
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
                var token='{{\Illuminate\Support\Facades\Session::token()}}';
                var url='{{ URL::to('likes') }}';
                var moduleId='1';
                var moduleName='Post';
       
                function sendComments(id) {
                    var post_id=id;
                    var comment=$('#comment_'+post_id).val();
                    var url_add_comment='{{ URL::to('blog_comment_add') }}';
                    var module_id='1';
                    var module_name='Post';
                    var today = new Date();
                    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    var dateTime = date+' '+time;
                    var user_id='{{Auth::id()}}';
                    $.ajax({
                        method:'POST',
                        url:url_add_comment,
                        data:{comment:comment,post_id:post_id,module_id:module_id,module_name:module_name,user_id:user_id,_token:token},
                        success: function(data) {
                            if(data['status']) {
                                $('#comment_'+post_id).val('');
                                var comment_id=data['comment_id'];
                                var user_id=data['user_id'];
                                var edit_comment_button='<span><i class="fa fa-edit del" aria-hidden="true" onclick="editComment('+comment_id+')" data-toggle="modal" data-target=".editComment"></i></span>';
                                $('<div class="col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2 w3-center comment_item comment_item_'+comment_id+'" onmouseover="showDeleteButtonComment('+comment_id+')" onmouseout="hideDeleteButtonComment('+comment_id+')">').html("<div class='col-xs-3 col-sm-3 w3-left'><a href='/users/"+user_id+"'><img style='border-radius: 20px;' height='40' src='" + "{{Auth::user()->photo ? $path.Auth::user()->photo->path :$path.'/images/noimage.png'}}" + "'/></a></div><div class='col-xs-7 col-sm-7 comment_data'><a href='/users/"+user_id+"'>{{Auth::user()->name}}</a><br>"+dateTime+"<hr></div><div class='col-xs-2 col-sm-2'>"+edit_comment_button+"<span><i class='fa fa-trash-o del' aria-hidden='true' onclick='deleteComment("+comment_id+")'></i></span></div><div class='col-xs-12 col-sm-12 commt comment_item_text_"+comment_id+"'>" + comment + "</div></div>").appendTo('#comments_list');
                            }
                        }
                    });

                }

                function deleteComment(id) {
                    var comment_id=id;
                    var url_add_comment='{{ URL::to('blog_comment_delete') }}';
                    var conf=confirm("Do you want to delete this comment?");
                    if(conf){
                        $.ajax({
                            method:'POST',
                            url:url_add_comment,
                            data:{comment_id:comment_id,_token:token},
                            success: function(data) {
                                if(data['status']) {
                                    var comment_id=data['comment_id'];
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
                
       function editComment(comment_id) {
        var comment_text=$('.comment_item_text_'+comment_id).html();
        $('#editComment').html('<textarea  cols="60" rows="4" class="comment_edit_textarea"  name="comment_edit_textarea"></textarea>');
        $('.comment_edit_textarea').text(comment_text);
        $('#edit_comment_submit').val(comment_id);
    }
    
        function editCommentAjax() {
          var comment_id=$('#edit_comment_submit').val();
        var comment_text=$('.comment_edit_textarea').val();
        var url_edit_comment='{{ URL::to('blog_comment_edit') }}';
        $.ajax({
            method:'POST',
            url:url_edit_comment,
            data:{comment_id:comment_id,comment_text:comment_text,_token:token},
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
       function showDeleteButtonComment(id){
                            $('.comment_item_'+id).find('.del').css('display', 'block');
                        }
                        function hideDeleteButtonComment(id){
                            $('.comment_item_'+id).find('.del').css('display', 'none');
                        }
            </script>
@endsection
@section('scripts')
    <script src="{{asset('js/ajax-likes.js')}}"></script>
@endsection
