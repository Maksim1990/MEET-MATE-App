<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Community;
use App\CommunityImage;
use App\CommunityPost;
use App\CommunityType;
use App\Like;
use App\Notice;
use App\Photo;
use App\User;
use App\UserCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public $path="/laravelvue/";
    public $path="";
    public function index()
    {
        $path=$this->path;
        $arrTabs=['General','Users','Statistics'];
        $active="active";
        $title="Communities";
        $communities=Community::all();
        $category=Category::pluck('name','id')->all();
        $type=CommunityType::pluck('name','id')->all();
        return view('community.index', compact('arrTabs', 'active', 'communities','path','category','type','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category=Category::pluck('name','id')->all();
        $type=CommunityType::pluck('name','id')->all();
        $arrTabs=['General'];
        $active="active";
        return view('community.create', compact('arrTabs', 'active','category','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $file=$request->file('photo_id');
        if(!($file->getClientSize()>2100000)){
            $input=$request->all();

            if($file=$request->file('photo_id'))
            {
                $name=time().$file->getClientOriginalName();
                $file->move('images',$name);
                $photo=Photo::create(['path'=>$name]);
                
            }
            $input['user_id']=Auth::id();
            $input['photo_id']=$photo->id;
            $community=Community::create($input);
            CommunityImage::create(['photo_id'=>$input['photo_id'], 'community_id'=>$community->id,'user_id'=>Auth::id()]);
            Session::flash('community_change','New community has been successfully created!');
            return redirect('community');
        }else{
            Session::flash('community_change','Image size should not exceed 2 MB');
            return redirect('community/create');
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
        $community=Community::findOrFail($id);
        $path=$this->path;
        $arrTabs=['General','Statistics'];
        $active="active";
        $user_online=Auth::user();
        $arrUsers=[];
        $arrUsersAll=[];
        $arrUsersPending=[];
        $posts=CommunityPost::where('community_id',$id)->limit(3)->orderBy('id','desc')->get();

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


        $community_users=UserCommunity::where('community_id',$id)->where('accepted','1')->get();
        $community_users_with_pending=UserCommunity::where('community_id',$id)->get();
        $community_users_pending=UserCommunity::where('community_id',$id)->where('accepted','0')->get();
        foreach ($community_users as $user_community){
            $arrUsers[]=$user_community->user_id;
        }
        foreach ($community_users_with_pending as $user_community){
            $arrUsersAll[]=$user_community->user_id;
        }
        foreach ($community_users_pending as $user_community){
            $arrUsersPending[]=$user_community->user_id;
        }
        $users=User::where('id','!=',Auth::id())->whereNotIn('id',$arrUsersAll)->orderBy('id')->get();
        $users_in_community=User::where('id','!=',Auth::id())->whereIn('id',$arrUsers)->orderBy('id')->limit(10)->get();
        $users_pending=User::where('id','!=',Auth::id())->whereIn('id',$arrUsersPending)->orderBy('id')->limit(10)->get();



        Notice::where('module_id','9')->where('module_item_id',$id)->delete();
        $wallPosts=CommunityPost::where('community_id',$id)->get();
        foreach ($wallPosts as $post)
        {
            $post->read_already=1;
            $post->save();
        }

        Notice::where('module_id','2')->where('module_item_id',$id)->delete();
        $comments=Comment::where('community_id',$id)->get();
        foreach ($comments as $comment)
        {
            $comment->read_already=1;
            $comment->save();
        }
    
        $postsInCommunity=CommunityPost::where('community_id',$id)->get();
          foreach ($postsInCommunity as $item){
            $arrListPostsInCommunity[]=$item->id;
        }
        if(!empty($arrListPostsInCommunity)){
        $likes=Like::whereIn('item_id',$arrListPostsInCommunity)->where('module_id',2)->get();
        foreach ($likes as $like)
                {
                    $like->read_already=1;
                    $like->save();
                }
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
       
       
       
       
        return view('community.community', compact('arrTabs', 'active', 'user_online','users','community','path','posts','users_in_community','users_pending','emojiFlags','emojiSport','emojiAnimals','emojiClassic','emojiClothes','emojiEmojis','emojiFood','emojiHolidays','emojiOther','emojiRest','emojiTravel','emojiWeather'));
  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $community=Community::findOrFail($id);
        $category=Category::pluck('name','id')->all();
        $type=CommunityType::pluck('name','id')->all();
        
        $arrTabs=['General'];
        $active="active";
        return view('community.edit',compact('arrTabs', 'active','type','category','community'));
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
        $community=Community::findOrFail($id);
        $file=$request->file('photo_id');
        if(!($file->getClientSize()>2100000)){
        $input=$request->all();
        if($file=$request->file('photo_id'))
        {
            if($community->photo) {
                unlink(public_path() . $community->photo->path);
            }
            $photo_user=Photo::findOrFail($community->photo_id);
            $photo_user->delete();
            $name=time().$file->getClientOriginalName();
            $file->move('images',$name);
            $photo=Photo::create(['path'=>$name]);
            $input['photo_id']=$photo->id;
       }
        $community->update($input);
        Session::flash('community_change','Community has been successfully updated!');
        return redirect('community/'.$community->id);
        }else{
            Session::flash('community_change','Image size should not exceed 2 MB');
            return redirect('community/'.$community->id.'/edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Community::findOrFail($id)->delete();

        return redirect('community');
    }

    public function inviteUser(Request $request)
    {
        $community_id=$request['community_id'];
        $user_id=$request['user_id'];
        $userCommunity=UserCommunity::create(['user_id'=>$user_id,'user_inviter_id'=>Auth::id(),'community_id'=>$community_id,'accepted'=>0]);
        Notice::create(['user_id'=>$user_id,'user_sender_id'=>Auth::id(),'module_item_id'=>$userCommunity->id,'module_id'=>'3','module_name'=>'CommunityUser']);
        return ["status"=>true];
    }

    public function search(Request $request)
    {
        $category_id=$request['category_id'];
        $type_id=$request['type_id'];
        $community_name=$request['community_name'];
        $community_description=$request['community_description'];
        $search=(!empty($community_name))?$community_name:"";
        $searchDescription=(!empty($community_description))?$community_description:"";
        if(!empty($type_id)){
            $communities=Community::where('category_id',$category_id)->where('type_id',$type_id)->where('name', 'like', '%' . $search . '%')->where('description', 'like', '%' . $searchDescription . '%')->get();
        }else{
            $communities=Community::where('name', 'like', '%' . $search . '%')->where('description', 'like', '%' . $searchDescription . '%')->get();
        }
        return ["data"=> $communities];
    }

    public function acceptInvitation(Request $request)
    {
        $invitation_id=$request['invitation_id'];
        $invitation=UserCommunity::findOrFail($invitation_id);
        $invitation->accepted=1;
        $invitation->save();
        Notice::where('module_id','3')->where('module_item_id',$invitation_id)->delete();
        return ["status"=>true];
    }
    public function declineInvitation(Request $request)
    {
        $invitation_id=$request['invitation_id'];
        UserCommunity::findOrFail($invitation_id)->delete();
        Notice::where('module_id','3')->where('module_item_id',$invitation_id)->delete();
        return ["status"=>true];
    }


    
}
