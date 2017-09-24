<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Dashboard;
use App\JobOffer;
use App\Like;
use App\Message;
use App\User;
use App\UserWall;
use App\WallComment;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   //public $path="/laravelvue/";
   public $path="";
    public function index()
    {    $arrTabs=['Dashboard','Settings'];
        $active="active";
        $dashboard=Dashboard::where('user_id',Auth::id())->first();
        if(!$dashboard){
            $dashboard=new Dashboard();
            $dashboard->user_id=Auth::id();
            $dashboard->save();
            $dashboard=Dashboard::where('user_id',Auth::id())->first();
        }
        $path=$this->path;
        $posts=UserWall::where('wall_user_id',Auth::id())->orderBy('id','desc')->limit(2)->get();
        $comments=WallComment::where('wall_user_id',Auth::id())->orderBy('id','desc')->limit(2)->get();
        if(!empty($comments)){
            foreach ($comments as $item){
                $post=UserWall::findOrFail($item->post_id);
                $item['post_name'] = $post->text;
            }
        }

        $messages=Message::where('receiver_id',Auth::id())->orderBy('id','desc')->limit(2)->get();




        $postsUserWall=UserWall::where('wall_user_id',Auth::id())->get();
        foreach ($postsUserWall as $item){
            $arrLikesUserWall[]=$item->id;
        }
        if(!empty($arrLikesUserWall)) {
            $likes = Like::whereIn('item_id', $arrLikesUserWall)->orderBy('id', 'desc')->limit(2)->get();
            foreach ($likes as $like) {
                $post = UserWall::findOrFail($like->item_id);
                $like['post_id'] = $post->id;
                $like['post_name'] = $post->text;
                $like['wall_user_id'] = $post->wall_user_id;
            }
        }else{
            $likes=[];
        }


        $user=User::findOrFail(Auth::id());
        $friend_birthday_array=[];
        foreach ($user->friends() as $friend ){
            if(!empty($friend->profile->birthdate)){
                $i=0;
                $current_year=date("Y");
                $current_day=date("d");
                $current_month=date("m");
                $date = explode("/", $friend->profile->birthdate);
                if($current_day==$date[1] && $current_month==$date[0]){
                    $friend['current_age']=(int)$current_year-(int)$date[2];
                    $friend_birthday_array[$i]=$friend;
                }
                $i++;
            }
        }
        $adds=Advertisement::where('id','>','0')->where('show_to_friends','Y')->where('active','Y')->orderBy('id','desc')->limit(10)->get();
        $jobs=JobOffer::where('id','>','0')->where('show_to_friends','Y')->where('active','Y')->orderBy('id','desc')->limit(10)->get();

  //return $friend_birthday_array;
        return view('admin.index', compact('dashboard','arrTabs', 'active','path','posts','comments','messages','likes','friend_birthday_array','adds','jobs'));
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
        //
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
        $update=false;
        $dashboard=Dashboard::where('user_id',Auth::id())->first();
        if($dashboard){

            $update=true;
        }else{
            $dashboard=new Dashboard();
        }
            $dashboard->date_time=$request['date_time'];
            $dashboard->posts=$request['posts'];
            $dashboard->dash_birthday=$request['dash_birthday'];
            $dashboard->dash_comment=$request['dash_comment'];
            $dashboard->dash_likes=$request['dash_likes'];
            $dashboard->dash_messages=$request['dash_messages'];


//            $dashboard->comments=$request['comments'];

        if($update){
            $dashboard->update();
        }else{
            $dashboard->save();
        }
        return redirect('/dashboard');
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
}
