<?php

namespace App\Http\Controllers;


use App\Community;
use App\CommunityPost;
use App\ImageCommunityPost;
use App\Like;
use App\Notice;
use App\Photo;
use Auth;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CommunityPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $community_id=$request['community_id'];
        $file=$request->file('file');
        $name=time().$file->getClientOriginalName();
        $file->move('images/',$name);
        $photo=Photo::create(['path'=>$name]);
        $photo_id=$photo->id;
        ImageCommunityPost::create(['photo_id'=>$photo_id, 'user_id'=>Auth::id(),'community_id'=>$community_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function addPost(Request $request)
    {
        $text=$request['text'];
        $community_id=$request['community_id'];
        $user_id=$request['user_id'];
        $image_sent=$request['image_sent'];
        if($image_sent=='true') {
            $image = ImageCommunityPost::where('user_id', $user_id)->where('community_id', $community_id)->orderBy('id', 'desc')->first();
            $post = CommunityPost::create(['user_id' => $user_id, 'community_id' => $community_id, 'text' => $text, 'photo_id' => $image->photo_id]);
            $image->post_id = $post->id;
            $image->save();
            $image_path=$post->image->photo->path;
        }else{
            $post = CommunityPost::create(['user_id' => $user_id, 'community_id' => $community_id, 'text' => $text]);
            $image_path="";
        }
        $community=Community::findOrFail($community_id);
        Notice::create(['user_id'=>$community->user->id,'user_sender_id'=>$post->id,'module_item_id'=>$community_id,'module_id'=>'9','module_name'=>'CommunityPosts']);
        return ["status"=>true,
        "post_id"=>$post->id,
        "image_path"=>$image_path];
    }

    public function loadPosts(Request $request)
    {
        $community_id=$request['community_id'];
        $numberOfPosts=$request['numberOfPosts'];
        $offsetPosts=$request['offsetPosts'];
        $posts=CommunityPost::where('community_id',$community_id)->orderBy('id','desc')->offset($offsetPosts)->limit($numberOfPosts)->get();
        //Adding existing likes number to specific post
        $arrLikes=[];
        $post_likes_num=Like::where('module_id',2)->where('like',1)->get();
        $post_likes_current_user=Like::where('module_id',2)->where('like',1)->where('user_id',Auth::id())->orderBy('item_id','desc')->get();
        foreach ($post_likes_num as $like){
            $arrLikes[]=$like->item_id;
        }
        $arr=array_count_values($arrLikes);
        foreach ($posts as $post){
            if(in_array($post->id,$arrLikes)) {
                $post['like'] = $arr[$post->id];
            }else {
                $post['like'] = 0;
            }
            $post['button_like'] = 'Like';
            if(count($post_likes_current_user)>0) {
                foreach ($post_likes_current_user as $like) {
                    if ($like->user_id == Auth::id() && $like->item_id == $post->id) {
                        $post['button_like'] = 'You like this post';
                    }
                }
            }


        }
        //Adding existing dislikes number to specific post
        $arrDislikes=[];
        $post_likes_num=Like::where('module_id',2)->where('like',0)->get();
        $post_dislikes_current_user=Like::where('module_id',2)->where('like',0)->where('user_id',Auth::id())->orderBy('item_id','desc')->get();
        foreach ($post_likes_num as $like){
            $arrDislikes[]=$like->item_id;
        }
        $arr=array_count_values($arrDislikes);
        foreach ($posts as $post){
            if(in_array($post->id,$arrDislikes)) {
                $post['dislike'] = $arr[$post->id];
            }else {
                $post['dislike'] = 0;
            }
            $post['button_dislike'] = 'Dislike';
            if(count($post_dislikes_current_user)>0) {
                foreach ($post_dislikes_current_user as $dislike) {
                    if ($dislike->user_id == Auth::id() && $dislike->item_id == $post->id) {
                        $post['button_dislike'] = 'You dislike this post';
                    }
                }
            }
        }
        $current_user_id=Auth::id();
        return ["data"=>$posts,
        'current_user_id'=>$current_user_id];

    }


    public function deletePostImage(Request $request)
    {
        $community_id=$request['community_id'];
        $user_id=$request['user_id'];
        $image=ImageCommunityPost::where('user_id',$user_id)->where('community_id',$community_id)->orderBy('id','desc')->first();
        $photo=Photo::findOrFail($image->photo_id);
        unlink(public_path(). $photo->path);
        $photo->delete();
        $image->delete();
        return ["status"=>true];
    }

    public function deletePost(Request $request)
    {
        $post_id=$request['post_id'];
        $community_id=$request['community_id'];
        $communityPost=CommunityPost::where('community_id',$community_id)->where('id',$post_id)->first();
        $imagePost=ImageCommunityPost::where('community_id',$community_id)->where('post_id',$post_id);
        Comment::where('post_id',$post_id)->where('community_id',$community_id)->delete();
        $like=Like::where('item_id',$post_id)->where('module_id','2');
      
        if($like) {
            $like->delete();
        }
        if($communityPost->image) {
            unlink(public_path() . $communityPost->image->photo->path);
        }
        if($communityPost->photo_id) {
            $photo = Photo::findOrFail($communityPost->photo_id);
        }
        if(isset($photo)) {
            $photo->delete();
        }
        $communityPost->delete();
        if($imagePost) {
            $imagePost->delete();
        }
        return ["status"=>true,
            "post_id"=>$post_id];
    }

    public function editPost(Request $request)
    {
        $post_id=$request['post_id'];
        $community_id=$request['community_id'];
        $post_text=$request['post_text'];
        $communityPost=CommunityPost::where('community_id',$community_id)->where('id',$post_id)->first();
        $communityPost->text=$post_text;
        $communityPost->update();
        return ["status"=>true];
    }

    public function hideInvitation(Request $request)
    {
        $post_id=$request['post_id'];
        $community_id=$request['community_id'];
        $post=CommunityPost::findOrFail($post_id);
        $post->read_already='1';
        $post->save();
        Notice::where('module_id','9')->where('user_sender_id',$post_id)->where('module_item_id',$community_id)->delete();
        return ["status"=>true];
    }


}
