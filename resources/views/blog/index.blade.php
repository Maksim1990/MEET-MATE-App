@extends('layouts.admin')
@section('General')
    <h1>All posts
    @if(isset($user))
       of
            <a href="{{ URL::to('users/' . $user->id ) }}" >
            {{$user->name}}
        </a>
    @endif
    </h1>

    <div class="col-xs-12 col-sm-12 tab_main_body" >
        @if(count($posts)>0)

            @foreach($posts as $post)
            <div class="w3-row post_item">
        <div class="w3-col m4 l4 w3-center">
            <img style="border-radius: 20px;" width="250" height="250" src="{{$post->photo ? $path.$post->photo->path :$path."/images/noimage.png"}}" alt="">
        </div>
        <div class="w3-col m8 l8">
            <div>
                <span>
                    Posted by <a href="{{ URL::to('users/' . $post->user->id) }}">{{$post->user ? $post->user->name : "No owner"}}</a>
                </span>
                <span class="w3-right">Post category: {{$post->category ? $post->category->name: "Uncategorized"}}</span>

            </div>
            <div >
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

            <div>
            <hr>
            <h3><a href="{{ URL::to('posts/' . $post->id ) }}">{{$post->title}}</a></h3>
            <p>{!! $post->body !!}</p>
             </div>
            <hr>
            <div>
                <span id="itemid" data-item-id="{{$post->id}}" style="float:right;">
                           <a  data-like="{{$post->id}}" class="like button_like">{{Auth::user()->likes()->where('item_id',$post->id)->first() ? Auth::user()->likes()->where('item_id',$post->id)->first()->like==1 ?'You like this post':'Like':'Like' }}</a>
                            <a data-like="{{$post->id}}" class="like button_dislike">{{Auth::user()->likes()->where('item_id',$post->id)->first() ? Auth::user()->likes()->where('item_id',$post->id)->first()->like==0 ?'You dislike this post':'Dislike':'Dislike' }}</a>
                        </span><br>
                <p class="w3-right">
                    <i class="fa fa-thumbs-up w3-text-green" aria-hidden="true"></i><span class="w3-text-green" id="like_icon_{{$post->id}}" >{{$post->like}}</span>
                    <i class="fa fa-thumbs-down w3-text-red" aria-hidden="true"></i><span class="w3-text-red" id="dislike_icon_{{$post->id}}" >{{$post->dislike}}</span>
                </p>   <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox w3-right"></div>
             </div>
            <hr>
        </div>

                        <td></td>
            </div>
                @endforeach
            @else
            <h3>Still no any posts here</h3>
            @endif
</div>
    <script>
        $(document).ready(function () {
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
    </script>
@endsection
@section('Authors')
    <div class="w3-col m10 l10">
        <table class="table table-striped">
            @if(count($users))
    @foreach($users as $user)
                <tr>
                    <td>
            <a href="{{ URL::to('users/' . $user->id ) }}" style="font-size:15px">
                <img style="border-radius: 10px;" height="100" width="100" src="{{$user->photo ? $path.$user->photo->path :$path."/images/noimage.png"}}" alt="">
            </a>
            {{$user->name}}
                </td>
                <td class="w3-right">
                <a href="{{ URL::to('blog/' . $user->id ) }}" style="font-size:15px">
                    @if($user->id!=Auth::id())
            See all posts of this user
                        @else
            See all your posts
                    @endif
              </a>
                </td>
                </tr>
    @endforeach
            @else
                <h3>Still no any authors in this list</h3>
            @endif
        </table>
        </div>


@endsection
@section('scripts')
    <script src="{{asset('js/ajax-likes.js')}}"></script>
@endsection

