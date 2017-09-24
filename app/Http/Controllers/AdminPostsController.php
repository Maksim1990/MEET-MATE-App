<?php

namespace App\Http\Controllers;

use App\Category;
use App\CommunityType;
use App\Http\Requests\PostCreateRequest;
use App\Like;
use App\Photo;
use App\Notice;
use App\Post;
use App\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    //public $path="/laravelvue/";
    public $path="";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        $posts=Post::all();
        $title='Posts';
        return view('admin.posts.index', compact('arrTabs', 'title','active', 'posts','path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     //   $category=Category::pluck('name','id')->all();
        $types=CommunityType::pluck('name','id')->all();
        $arrTabs=['General'];
        $active="active";
        $path=$this->path;
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
        return view('admin.posts.create', compact('arrTabs', 'active','types','emojiFlags','emojiSport','emojiAnimals','emojiClassic','emojiClothes','emojiEmojis','emojiFood','emojiHolidays','emojiOther','emojiRest','emojiTravel','emojiWeather','path'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {
        $file=$request->file('photo_id');
        if(!($file->getClientSize()>2100000)){
            $input=$request->all();
            $user=Auth::user();

            if($file=$request->file('photo_id'))
            {
                $name=time().$file->getClientOriginalName();
                $file->move('images',$name);
                $photo=Photo::create(['path'=>$name]);
                $input['photo_id']=$photo->id;
            }
            $post=$user->posts()->create($input);

            Session::flash('post_change','Post has been successfully created!');
            return redirect('posts/'.$post->id);
        }else{
            Session::flash('post_change','Image size should not exceed 2 MB');
            return redirect('posts/create');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::findOrFail($id);
        $arrTabs=['General'];
        $active="active";
        $title=$post->title;
        $path=$this->path;


        //Adding existing likes number to specific post
        $arrLikes=[];
        $post_likes_num=Like::where('module_id',1)->where('item_id',$id)->where('like',1)->get();
        foreach ($post_likes_num as $like){
            $arrLikes[]=$like->item_id;
        }
        $arr=array_count_values($arrLikes);

            if(in_array($post->id,$arrLikes)) {
                $post['like'] = $arr[$post->id];
            }else {
                $post['like'] = 0;
            }

        //Adding existing dislikes number to specific post
        $arrDislikes=[];
        $post_likes_num=Like::where('module_id',1)->where('item_id',$id)->where('like',0)->get();
        foreach ($post_likes_num as $like){
            $arrDislikes[]=$like->item_id;
        }
        $arr=array_count_values($arrDislikes);

            if(in_array($post->id,$arrDislikes)) {
                $post['dislike'] = $arr[$post->id];
            }else {
                $post['dislike'] = 0;
            }
        //-- Mark likes as read and delete notices
        Notice::where('module_id','1')->where('user_id',Auth::id())->where('module_item_id',$id)->delete();
        $likes=Like::where('module_id','1')->where('user_id',Auth::id())->where('item_id',$id)->get();
        foreach ($likes as $like)
        {
            $like->read_already=1;
            $like->save();
        }

        return view('blog.post', compact('arrTabs', 'active','title','post','path'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=Post::findOrFail($id);
        $category=Category::pluck('name','id')->all();
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        //$myDirectory = opendir($path."images/emoji/flag");
        $myDirectory = opendir(public_path()."/images/emoji/flag");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $emojiFlags[] = $entryName;
            }
        }
        closedir($myDirectory);
     //   $myDirectory = opendir($path."images/emoji/sport");
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
        return view('admin.posts.edit',compact('arrTabs', 'active','post','category','emojiFlags','emojiSport','emojiAnimals','emojiClassic','emojiClothes','emojiEmojis','emojiFood','emojiHolidays','emojiOther','emojiRest','emojiTravel','emojiWeather','path'));
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
        $file = $request->file('photo_id');

            $post = Post::findOrFail($id);

            $input = $request->all();

            if ($file = $request->file('photo_id')) {
                if (!($file->getClientSize() > 2100000)) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['path' => $name]);
                $input['photo_id'] = $photo->id;
                } else {
                    Session::flash('post_change', 'Image size should not exceed 2 MB');
                    return redirect('posts/'.$id.'/edit');
                }
            }

            $post->update($input);
            Session::flash('post_change', 'The post has been successfully updated!');
            return redirect('posts/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::findOrFail($id);
        unlink(public_path().$post->photo->path);
        Photo::findOrfail($post->photo->id)->delete();
        Session::flash('post_change','The post has been successfully deleted!');
        $post->delete();
        return redirect('posts');
    }
    public function blog()
{
    $path=$this->path;
    $arrTabs=['General','Authors'];
    $active="active";
    $posts=Post::all();

    //Adding existing likes number to specific post
    $arrLikes=[];
    $post_likes_num=Like::where('module_id',1)->where('like',1)->get();
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
    }
    //Adding existing dislikes number to specific post
    $arrDislikes=[];
    $post_likes_num=Like::where('module_id',1)->where('like',0)->get();
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
    }
    
    
    $users=[];
    foreach ($posts as $post){
        array_push($users, $post->user);
    }
    $users=array_unique($users);

    return view('blog/index', compact('arrTabs', 'active', 'posts','path','users'));
}
    public function blogUser($id)
    {
        $path=$this->path;
        $arrTabs=['General','Authors'];
        $active="active";
        $postAll=Post::all();
        $posts=Post::where('user_id',$id)->orderBy('id')->paginate(10);

        //Adding existing likes number to specific post
        $arrLikes=[];
        $post_likes_num=Like::where('module_id',2)->where('like',1)->get();
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
        }
        //Adding existing dislikes number to specific post
        $arrDislikes=[];
        $post_likes_num=Like::where('module_id',2)->where('like',0)->get();
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
        }
        
        $users=[];
        foreach ($postAll as $post){
            array_push($users, $post->user);
        }
        $users=array_unique($users);

        $postsOfUser=Post::where('user_id',$id)->first();
        if(!empty($postsOfUser)){
            $user=$postsOfUser->user;
        }
        

        return view('blog/index', compact('arrTabs', 'active', 'posts','path','users','user','postsOfUser'));
    }
}
