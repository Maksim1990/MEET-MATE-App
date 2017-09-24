<?php

namespace App\Http\Controllers;

use App\ImageUserWall;
use App\Like;
use App\Notice;
use App\Photo;
use App\User;
use App\UserWall;
use App\WallComment;
use Auth;
use Illuminate\Http\Request;

class UserWallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 //    public $path="/laravelvue";
 public $path="";
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
        $user_wall_id=$request['user_wall_id'];
        $file=$request->file('file');
        $name=time().$file->getClientOriginalName();
        $file->move('images/',$name);
        $photo=Photo::create(['path'=>$name]);
        $photo_id=$photo->id;
        ImageUserWall::create(['photo_id'=>$photo_id, 'user_id'=>Auth::id(),'user_wall_id'=>$user_wall_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        $user=User::findOrFail($id);
        $title=$user->name.'\'s wall';
        $wall_posts=UserWall::where('wall_user_id',$id)->limit(5)->orderBy('id','desc')->get();
    // return $wall_posts;
        //Adding existing likes number to specific post
        $arrLikes=[];
        $post_likes_num=Like::where('module_id',5)->where('like',1)->get();
        foreach ($post_likes_num as $like){
            $arrLikes[]=$like->item_id;
        }

        $arr=array_count_values($arrLikes);
        foreach ($wall_posts as $post){
            if(in_array($post->id,$arrLikes)) {
                $post['like'] = $arr[$post->id];
            }else {
                $post['like'] = 0;
            }

        }

        //Adding existing dislikes number to specific post
        $arrDislikes=[];
        $post_likes_num=Like::where('module_id',5)->where('like',0)->get();
        foreach ($post_likes_num as $like){
            $arrDislikes[]=$like->item_id;
        }
        $arr=array_count_values($arrDislikes);
        foreach ($wall_posts as $post){
            if(in_array($post->id,$arrDislikes)) {
                $post['dislike'] = $arr[$post->id];
            }else {
                $post['dislike'] = 0;
            }
        }

        Notice::where('module_id','8')->where('user_id',Auth::id())->delete();
        $wallPosts=UserWall::where('wall_user_id',Auth::id())->get();
        foreach ($wallPosts as $post)
        {
            $post->read_already=1;
            $post->save();
        }

        Notice::where('module_id','10')->where('user_id',Auth::id())->delete();
        $wallComments=WallComment::where('wall_user_id',Auth::id())->get();
        foreach ($wallComments as $comment)
        {
            $comment->read_already=1;
            $comment->save();
        }

        //-- Mark likes as read and delete notices
        Notice::where('module_id','5')->where('user_id',$id)->delete();
        $likes=Like::where('module_id','5')->where('user_id',Auth::id())->get();
        foreach ($likes as $like)
        {
            $like->read_already=1;
            $like->save();
        }

        //   $myDirectory = opendir($path."images/emoji/flag");
        $myDirectory = opendir(public_path()."/images/emoji/flag");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiFlags[] = $entryName;
            }
        }
        closedir($myDirectory);
//        $myDirectory = opendir($path."images/emoji/sport");
        $myDirectory = opendir(public_path()."/images/emoji/sport");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiSport[] = $entryName;
            }
        }
        closedir($myDirectory);
        //        $myDirectory = opendir($path."images/emoji/animals");
        $myDirectory = opendir(public_path()."/images/emoji/animals");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiAnimals[] = $entryName;
            }
        }
        closedir($myDirectory);
        //        $myDirectory = opendir($path."images/emoji/classic");
        $myDirectory = opendir(public_path()."/images/emoji/classic");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiClassic[] = $entryName;
            }
        }
        closedir($myDirectory);
        //        $myDirectory = opendir($path."images/emoji/clothes");
        $myDirectory = opendir(public_path()."/images/emoji/clothes");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiClothes[] = $entryName;
            }
        }
        closedir($myDirectory);
        //        $myDirectory = opendir($path."images/emoji/emojis");
        $myDirectory = opendir(public_path()."/images/emoji/emojis");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiEmojis[] = $entryName;
            }
        }
        closedir($myDirectory);
        //        $myDirectory = opendir($path."images/emoji/food");
        $myDirectory = opendir(public_path()."/images/emoji/food");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiFood[] = $entryName;
            }
        }
        closedir($myDirectory);
        //        $myDirectory = opendir($path."images/emoji/holidays");
        $myDirectory = opendir(public_path()."/images/emoji/holidays");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiHolidays[] = $entryName;
            }
        }
        closedir($myDirectory);
        //        $myDirectory = opendir($path."images/emoji/other");
        $myDirectory = opendir(public_path()."/images/emoji/other");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiOther[] = $entryName;
            }
        }
        closedir($myDirectory);
        //        $myDirectory = opendir($path."images/emoji/rest");
        $myDirectory = opendir(public_path()."/images/emoji/rest");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiRest[] = $entryName;
            }
        }
        closedir($myDirectory);
        //        $myDirectory = opendir($path."images/emoji/travel");
        $myDirectory = opendir(public_path()."/images/emoji/travel");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiTravel[] = $entryName;
            }
        }
        closedir($myDirectory);
        //        $myDirectory = opendir($path."images/emoji/weather");
        $myDirectory = opendir(public_path()."/images/emoji/weather");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiWeather[] = $entryName;
            }
        }
        closedir($myDirectory);




        return view('admin.users.wall', compact('user','arrTabs', 'active','path','title','wall_posts',
            'emojiFlags','emojiSport','emojiAnimals','emojiClassic','emojiClothes','emojiEmojis','emojiFood','emojiHolidays','emojiOther','emojiRest','emojiTravel','emojiWeather'));
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
        $user_post_id=$request['user_post_id'];
        $wall_user_id=$request['wall_user_id'];
        $image_sent=$request['image_sent'];
        if($image_sent=='true'){
            $image=ImageUserWall::where('user_id',$user_post_id)->where('user_wall_id',$wall_user_id)->orderBy('id','desc')->first();
            $post=UserWall::create(['user_post_id'=>$user_post_id,'wall_user_id'=>$wall_user_id,'text'=>$text,'photo_id'=>$image->photo_id]);
            $image->post_id=$post->id;
            $image->save();
            $image_path=$post->image->photo->path;
        }else{
           $post=UserWall::create(['user_post_id'=>$user_post_id,'wall_user_id'=>$wall_user_id,'text'=>$text]);
            $image_path="";
        }
        Notice::create(['user_id'=>$wall_user_id,'user_sender_id'=>$user_post_id,'module_item_id'=>$post->id,'module_id'=>'8','module_name'=>'UserWallPosts']);
        return ["status"=>true,
            "post_id"=>$post->id,
            "image_path"=>$image_path];

        
    }

    public function loadPosts(Request $request)
    {
        $wall_user_id=$request['wall_user_id'];
        $numberOfPosts=$request['numberOfPosts'];
        $offsetPosts=$request['offsetPosts'];
        $posts=UserWall::where('wall_user_id',$wall_user_id)->orderBy('id','desc')->offset($offsetPosts)->limit($numberOfPosts)->get();
        //Adding existing likes number to specific post
        $arrLikes=[];
        $post_likes_num=Like::where('module_id',5)->where('like',1)->get();
        $post_likes_current_user=Like::where('module_id',5)->where('like',1)->where('user_id',Auth::id())->orderBy('item_id','desc')->get();
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
        $post_likes_num=Like::where('module_id',5)->where('like',0)->get();
        $post_dislikes_current_user=Like::where('module_id',5)->where('like',0)->where('user_id',Auth::id())->orderBy('item_id','desc')->get();
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
        $user_wall_id=$request['user_wall_id'];
        $user_id=$request['user_id'];
        $image=ImageUserWall::where('user_id',$user_id)->where('user_wall_id',$user_wall_id)->orderBy('id','desc')->first();
        $photo=Photo::findOrFail($image->photo_id);
        unlink(public_path(). $photo->path);
        $photo->delete();
        $image->delete();
        return ["status"=>true];
    }

    public function deletePost(Request $request)
    {
        $post_id=$request['post_id'];
        $user_wall_id=$request['wall_user_id'];
        $wallPost=UserWall::where('wall_user_id',$user_wall_id)->where('id',$post_id)->first();
        $imagePost=ImageUserWall::where('user_wall_id',$user_wall_id)->where('post_id',$post_id);
        $comment=WallComment::where('post_id',$post_id)->where('wall_user_id',$user_wall_id);
        $like=Like::where('item_id',$post_id)->where('module_id','5');
        if($comment) {
            $comment->delete();
        }
        if($like) {
            $like->delete();
        }
        if($wallPost->photo_id) {
            unlink(public_path() . $wallPost->image->photo->path);
        }
        if(isset($photo)) {
            $photo = Photo::findOrFail($wallPost->photo_id);
        }
        if(isset($photo)) {
            $photo->delete();
        }
        $wallPost->delete();
        if($imagePost) {
            $imagePost->delete();
        }
        return ["status"=>true,
            "post_id"=>$post_id];
    }
    public function editPost(Request $request)
    {
        $post_id=$request['post_id'];
        $wall_user_id=$request['wall_user_id'];
        $post_text=$request['post_text'];
        $communityPost=UserWall::where('wall_user_id',$wall_user_id)->where('id',$post_id)->first();
        $communityPost->text=$post_text;
        $communityPost->update();
        return ["status"=>true];
    }

    public function hideInvitation(Request $request)
    {
        $post_id=$request['post_id'];
        $post=UserWall::findOrFail($post_id);
        $post->read_already='1';
        $post->save();
        Notice::where('module_id','8')->where('module_item_id',$post_id)->delete();
        return ["status"=>true];
    }

}
