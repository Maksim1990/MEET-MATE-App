<?php

namespace App\Http\Controllers;
use App\Community;
use App\Gift;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UsersRequest;
use App\Message;
use App\Notice;
use App\Photo;
use App\Profile;
use App\Role;
use App\User;
use App\Like;
use App\Post;
use Carbon\Carbon;

use App\UserImage;
use App\UserWall;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   //public $path="/laravelvue";
 public $path="";
    public function index()
    {    $arrTabs=['General'];
        $active="active";
        $users=User::where('is_active','=','1')->where('id','!=',Auth::id())->orderBy('id')->paginate(10);
        $path=$this->path;
        $title='Users';
//        $search=\Request::get('search');
//        $users=User::where('name','like','$'.$search.'$')->orderBy('id')->paginate(3);
//       return Auth::user()->friendsIds();
  // return Auth::user()->pendingFriendRequestIds();
  // return Auth::user()->pendingFriendRequestSentIds();
//-- Status types:
//-- 1- ADD TO FRIEND
//-- 2- DECLINE REQUEST
//-- 3- REMOVE FROM FRIENDS
//-- 4- ACCEPT REQUEST


        if(!Auth::user()->friendsIds()->isEmpty()) {
            foreach (Auth::user()->friendsIds() as $us) {
                $friendsIds[] =$us;
            }

        }else{
            $friendsIds=[];
        }

        if(count(Auth::user()->pendingFriendRequestIds())>0){
            foreach (Auth::user()->pendingFriendRequestIds() as $us) {
                $pendingFriendRequestIds[] = $us;
            }
        }else{
            $pendingFriendRequestIds=[];
        }

        if(count(Auth::user()->pendingFriendRequestSentIds())>0) {
            foreach (Auth::user()->pendingFriendRequestSentIds() as $us){
                $pendingFriendRequestSentIds[] = $us;
        }
        }else{
            $pendingFriendRequestSentIds=[];
        }
        foreach ($users as $user){
            if(!empty($friendsIds) && in_array($user->id,$friendsIds)) {
                $user['status_type'] = 3;
            }elseif(!empty($pendingFriendRequestIds) && in_array($user->id,$pendingFriendRequestIds)) {
                $user['status_type'] = 4;
            }elseif(!empty($pendingFriendRequestSentIds) && in_array($user->id,$pendingFriendRequestSentIds)) {
                $user['status_type'] = 2;
            }else{
                $user['status_type'] =1;
            }
        }
        return view('admin.users.index', compact('users','arrTabs', 'active','path','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::pluck('name','id')->all();
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        $title='Create user';
        return view('admin.users.create',compact('arrTabs', 'active','roles','path','title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {

        if(trim($request->password)==""){
            $input=$request->except('password');
        }else{
            $input=$request->all();
        }
        if($file=$request->file('photo_id'))
        {
          $name=time().$file->getClientOriginalName();
        $file->move('images',$name);
            $photo=Photo::create(['path'=>$name]);
            $input['photo_id']=$photo->id;
        }
        $input['password']=bcrypt($request->password);
        User::create($input);
        Session::flash('user_change','The user has been successfully created!');
        return redirect('/users');

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
        $arrTabs=['General','Gifts','Users'];
        $active="active";
        $user=User::findOrFail($id);
        $images=UserImage::where('user_id','=',$id)->orderBy('id')->paginate(6);
        if(count($images)==0){
            $images=false;
        }
        $friend_birthday_array=Array();
        foreach ($user->friends() as $friend ){
        if(!empty($friend->profile->birthdate)){

        $i=0;
        $current_year=date("Y");
        $current_day=date("d");
        $current_month=date("m");
//        echo $current_year . "<br/>";
//        echo $current_day . "<br/>";
//        echo $current_month . "<br/>";
        $date = explode("/", $friend->profile->birthdate);
//        echo $date[0] . "<br/>";
//        echo $date[1] . "<br/>";
//        echo $date[2] . "<br/>";
//        return $current_day."=".$date[1] ."<br>".$current_month."=".$date[0];
        if($current_day==$date[1] && $current_month==$date[0]){

            $friend['current_age']=(int)$current_year-(int)$date[2];
            $friend_birthday_array[$i]=$friend;
        }
            $i++;
                }
        }

        $posts=Post::where('user_id',$id)->orderBy('id')->paginate(10);
        $communities=Community::where('user_id','=',$id)->orderBy('id')->get();
        $countries=\Countries::getList('en', 'php');
        if(isset($user->profile->country) && !empty($user->profile->country) ){
            $country=$countries[$user->profile->country];
        }
        $title=$user->name.'\'s profile';
        $wall_posts=UserWall::where('wall_user_id',$id)->limit(5)->orderBy('id','desc')->get();

        $myDirectory = opendir(public_path()."/images/gifts/");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'png') {
                $gifts[] = $entryName;
            }
        }
        closedir($myDirectory);

        //-- Mark Gifts as read and delete notices
        Notice::where('module_id','7')->where('user_id',$id)->delete();
        $giftsList=Gift::where('user_receiver_id',Auth::id())->get();
        foreach ($giftsList as $gift)
        {
            $gift->read_already=1;
            $gift->save();
        }

           $date = Carbon::parse($user->online);
           $now = Carbon::now();
            $diff = $date->diffInMinutes($now);
            if($diff<=10){
                $online=true;
            }else{
                $online=false;
            }
        $giftsUser=Gift::where('user_receiver_id',$id)->orderBy('id','desc')->limit(3)->get();
        return view('admin.users.user', compact('user','arrTabs','online', 'active','images','path','gifts','giftsUser','communities','friend_birthday_array','posts','country','title','wall_posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $profile=Profile::where('user_id',$user->id)->get()->first();
        if(!$profile){
            $profile=new Profile();
            $profile->user_id=Auth::id();
            $profile->save();
        }
        $roles=Role::pluck('name','id')->all();
        $path=$this->path;
        $arrTabs=['General','Password','Profile'];
        $active="active";
        $countries=\Countries::getList('en', 'php');
        $title='Edit profile';
        return view('admin.users.edit',compact('arrTabs', 'active','roles','user','profile','path','countries','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, $id)
    {
        $user=User::findOrFail($id);
        $input=$request->all();
        if($file=$request->file('photo_id')) {
            if (!($file->getClientSize() > 2100000)) {
                if ($user->photo) {
                    unlink(public_path() . $user->photo->path);
                }
                $photo_user = Photo::findOrFail($user->photo_id);
                $photo_user->delete();

                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['path' => $name]);
                $input['photo_id'] = $photo->id;
                Message::where('user_id', $user->id)->update(['photo_id' => $photo->id, 'path' => '/images/' . $name]);
            } else {
                Session::flash('user_change', 'Image size should not exceed 2 MB');
                return redirect('users/' . $id . '/edit');
            }
        }

        $user->update($input);
        Session::flash('user_change','The user has been successfully edited!');
        return redirect('users/'.$user->id);
    }
    public function updatePassword(UpdatePasswordRequest $request, $id)
    {

        $user=User::findOrFail(Auth::id());
        $input=$request->all();
        $old_password=bcrypt(\Request::input('old_password'));
        $password=\Request::input('password');
        $password_2=\Request::input('password_2');
        if (Hash::check(\Request::input('old_password'), $user->password)) {
           if($password==$password_2){
               $input['password'] = bcrypt(\Request::input('password'));
               $user->update($input);
               Session::flash('user_change','The password has been successfully edited!');
               return redirect('users/'.Auth::id());
           }else{
               $arrTabs=['General'];
               $active="active";
               $user=User::findOrFail(Auth::id());
               $path=$this->path;
               $title='Change password';
               Session::flash('user_change','You repeated new password not correct');
               return view('admin.users.change_password', compact('user','arrTabs', 'active','path','title'));
           }
        }else{
            $arrTabs=['General'];
            $active="active";
            $user=User::findOrFail(Auth::id());
            $path=$this->path;
            $title='Change password';
            Session::flash('user_change','You entered wrong old password');
            return view('admin.users.change_password', compact('user','arrTabs', 'active','path','title'));
        }
    }
    public function changeUserPassword()
    {
        $arrTabs=['General'];
        $active="active";
        $user=User::findOrFail(Auth::id());
        $path=$this->path;
        $title="Change password";
        return view('admin.users.change_password', compact('user','arrTabs', 'active','path','title'));
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        if($user->photo) {
            unlink(public_path() . $user->photo->path);
            Photo::findOrfail($user->photo->id)->delete();
        }

        Session::flash('user_change','The user has been successfully deleted!');
        $user->delete();
        return redirect('users');
    }
    public function images($id)
    {
        $path=$this->path;
        $arrTabs=['General','Statistic'];
        $active="active";
        $user=User::findOrFail($id);
        $images=UserImage::where('user_id','=',$id)->orderBy('id')->paginate(10);
        if(count($images)==0){
            $images=false;
        }
        $title='Images';
        return view('admin.users.images', compact('images','arrTabs', 'active','user','path','title'));
    }
    public function friends($id)
    {
        $path=$this->path;
        $arrTabs=['General','Statistic'];
        $active="active";
        $user=User::findOrFail($id);
        $friends=$user->friends();
//        $friends=User::where('is_active','=',$id)->orderBy('id')->paginate(10);
        if(count($friends)==0){
            $friends=false;
        }
        $title='Friends';
        return view('admin.users.friends', compact('friends','arrTabs', 'active','user','path','title'));
    }
}
