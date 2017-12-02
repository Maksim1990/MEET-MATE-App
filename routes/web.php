<?php
use App\Events\MessageSent;
use App\Notice;
use App\Role;
use App\Setting;
use App\User;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/video', function () {
    return view('test');
});
//Route::get('/user/role',function(){
//    $user=User::findOrFail(2);
//    return $user->role->name;
//});


Route::get('/admin',function(){

    return view('admin.index');
});
Route::get('/norights',function(){
    return view('includes.norights');
});
Route::get('/add',function(){
    return Auth::user()->addFriend(5);
});
Route::get('/accept',function(){
    return User::find(3)->acceptFriend(28);
});
Route::get('/friends_list',function(){
    return Auth::user()->friends();
});
Route::get('/pending',function(){
    return Auth::user()->pendingFriendRequests();
});
Route::get('/ids',function(){
    return Auth::user()->friendsIds();
});
Route::get('/idfriend',function(){
    return Auth::user()->isFriendWith(5);
});
Route::get('/check_relationship_status/{id}',[
    'uses'=>'FriendshipsController@check',
    'as'=>'check'] );
Route::get('/add_friend/{id}',[
    'uses'=>'FriendshipsController@add_friend',
    'as'=>'add_friend'] );
Route::get('/accept_friend/{id}',[
    'uses'=>'FriendshipsController@accept_friend',
    'as'=>'accept_friend'] );

Auth::routes();

Route::get('/home', 'DashboardController@index')->name('home');
Route::group(['middleware'=>'admin'], function (){

//    Route::get('/admin',function(){
//        $arrTabs=['Dashboard','Settings'];
//        $active="active";
//        return view('admin.index', compact('arrTabs', 'active'));
//    });

    Route::resource('/users','AdminUserController');
    Route::get('/image/{id}','AdminUserController@images');
    Route::get('/friends/{id}','AdminUserController@friends');
    Route::patch('/users/update/{id}','AdminUserController@updatePassword');
    Route::post ( '/search', function () {

        $arrTabs=['General'];
        $active="active";
        //$path="/laravelvue/";
        $path="";
        $q = Input::get ( 'q' );
       if(!empty($q)){

                $users_array = User::where ( 'name', 'LIKE', '%' . $q . '%' )->orderBy('id')->get ();
        $users=[];
        foreach ($users_array as $user) {
            if($user->id == 32){
                continue;
            }
            $users[]=$user;
        }
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

        if (count ( $users ) > 0)
            return view ( 'admin.users.search', compact('arrTabs', 'active','path') )->withDetails ( $users )->withQuery ( $q );
        else
            return view ( 'admin.users.search', compact('arrTabs', 'active','path') )->withMessage ( 'No Details found. Try to search again !' );

       }else
       {

            return view ( 'admin.users.search', compact('arrTabs', 'active','path') )->withErrors(['Input should not be empty']);
       }

    } );
    Route::resource('/posts','AdminPostsController');
    Route::resource('/categories','AdminCategoryController');
    Route::resource('/media','AdminPhotoController');
    Route::resource('/profile','ProfileController');
    Route::resource('/community','CommunityController');
    Route::resource('/type','CommunityTypeController');
    Route::resource('/community_post','CommunityPostController');
    Route::resource('/wall','UserWallController');
    Route::post('/community_post_add','CommunityPostController@addPost');
    Route::post('/community_post_edit','CommunityPostController@editPost');
    Route::post('/community_comment_edit','CommentController@editComment');
    Route::post('/wall_post_add','UserWallController@addPost');
    Route::post('/wall_post_edit','UserWallController@editPost');
    Route::post('/wall_comment_edit','WallCommentController@editComment');
    Route::post('/community_comment_add','CommentController@addComment');
    Route::post('/wall_comment_add','WallCommentController@addComment');
    Route::post('/blog_comment_add','BlogPostCommentController@addComment');
    Route::post('/blog_comment_delete','BlogPostCommentController@deleteComment');
    Route::post('/blog_comment_edit','BlogPostCommentController@editComment');
    Route::post('/community_post_delete','CommunityPostController@deletePost');
    Route::post('/wall_post_delete','UserWallController@deletePost');
    Route::post('/community_comment_delete','CommentController@deleteComment');
    Route::post('/wall_comment_delete','WallCommentController@deleteComment');
    Route::post('/community_user_invite','CommunityController@inviteUser');
    Route::post('/community_user_decline','CommunityController@declineUser');
    Route::post('/community_search','CommunityController@search');
    Route::post('/job_search','JobOfferController@search');
    Route::post('/advertisement_search','AdvertisementController@search');
    Route::post('/register_online','HomeController@online');
    Route::post('/community_load_posts','CommunityPostController@loadPosts');
    Route::post('/wall_load_posts','UserWallController@loadPosts');
    Route::post('/delete_community_post_image','CommunityPostController@deletePostImage');
    Route::post('/delete_user_wall_post_image','UserWallController@deletePostImage');
    Route::post('/send_gift','GiftController@sendGift');
    Route::post('/delete_gift','GiftController@deleteGift');
    Route::resource('/notices','NoticeController');
    Route::post('/check_notices','NoticeController@checkNotice');
    Route::resource('/calendar','CalendarController');
    Route::resource('/dashboard','DashboardController');
    Route::resource('/advertisement','AdvertisementController');
    Route::resource('/jobs','JobOfferController');
    Route::resource('/currency','CurrencyController');
    Route::resource('/notes','NotesController');
    Route::resource('/contact_list','ContactController');
    Route::resource('/translate','TranslateController');
    Route::resource('/country','CountryController');
    Route::resource('/community_post','CommunityPostController');
    Route::post('/status/','ProfileController@updateStatus');
    Route::post('/edit_status/','ProfileController@editStatus');
    Route::post('/delete_status/','ProfileController@deleteStatus');
    Route::post('/unfriend_user/','FriendshipsController@deleteFriend');
    Route::post('add_user_request','FriendshipsController@addFriend');
    Route::post('decline_user_request','FriendshipsController@declineFriend');
    Route::post('accept_user_request','FriendshipsController@acceptFriend');
    Route::post('/make_as_read/','MessagesController@markAsRead');
    Route::post('/accept_invitation_notice/','CommunityController@acceptInvitation');
    Route::post('/decline_invitation_notice/','CommunityController@declineInvitation');
    Route::post('/hide_like_wall_notice/','LikesController@hideInvitation');
    Route::post('/hide_gift_notice/','GiftController@hideInvitation');
    Route::post('/hide_post_wall_notice/','UserWallController@hideInvitation');
    Route::post('/hide_post_community_notice/','CommunityPostController@hideInvitation');
    Route::post('/hide_wall_comment_notice/','WallCommentController@hideInvitation');
    Route::post('/hide_community_comment_notice/','CommentController@hideInvitation');
    Route::post('/delete_user_image/','AdminPhotoController@deleteImage');
    Route::get('/users_f/','AdminUserController@filter');
    Route::get('/change_password/','AdminUserController@changeUserPassword');
    Route::post('/show_left_sidebar/','SettingController@showSidebar');
    Route::get('/blog','AdminPostsController@blog');
    Route::get('/blog/{id}','AdminPostsController@blogUser');
    Route::get('/about_us',function (){
        $arrTabs=['General'];
        $active="active";
        return view('about_us', compact('arrTabs', 'active'));
    });
    Route::get('/contact_us',function (){
        $arrTabs=['General'];
        $active="active";
        return view('contact_us', compact('arrTabs', 'active'));
    });
    Route::get('/terms',function (){
        $arrTabs=['General'];
        $active="active";
        return view('terms', compact('arrTabs', 'active'));
    });
    Route::get('/privacy',function (){
        $arrTabs=['General'];
        $active="active";
        return view('privacy', compact('arrTabs', 'active'));
    });
    Route::post('/likes','LikesController@like');
    Route::post('/get_category_list/','AdminCategoryController@categoryList');
    Route::post('/translate_phrase/','TranslateController@translate');
    Route::post('/convert_currency/','CurrencyController@convert');
    Route::post('/country_name/','CountryController@getByName');
    Route::post('/country_capital/','CountryController@getByCapital');
    Route::post('/country_currency/','CountryController@getByCurrency');
    Route::post('/country_code/','CountryController@getByCode');
    Route::resource('/chat','MessagesController');
    Route::get('/messages/{id}',function ($id){
        return Message::whereIn('user_id',[Auth::id(),$id])->whereIn('receiver_id',[Auth::id(),$id])->with('user','photo')->get();
    });
    Route::post('/messages',function (){
        $user=Auth::user();
        $message=$user->messages()->create(['message'=>request()->get('message'),'receiver_id'=>request()->get('user_id'),'photo_id'=>$user->photo->id,
        'path'=>$user->photo->path]);
        Notice::create(['user_id'=>request()->get('user_id'),'user_sender_id'=>Auth::id(),'module_item_id'=>$message->id,'module_id'=>'4','module_name'=>'Messages']);
        broadcast(new MessageSent($message, $user))->toOthers();
        return ['status'=>'OK'];
    });
    Route::get('/get_unread', function (){
        return Auth::user()->unreadNotifications()->get();
    });
    Route::get('/notifications', 'HomeController@notifications')->name('notifications');
    Route::get('/articles','ArticlesController@index');
    Route::post('/articles/create', [
        'uses' => 'ArticlesController@store'
    ]);

    Route::get('/feed',[
        'uses'=>'FeedsController@feed',
        'as'=>'feed'] );
    Route::get('/get_auth_user_data', function(){
        return Auth::user();
    });
    Route::get('/like/{id}', [
        'uses' => 'ArticleLikesController@like'
    ]);
    Route::get('/instagram',function(){
        $arrTabs=['General'];
        $active="active";
        $title="Instagram";
        //$path="/laravelvue/";
         $path="";
        $setting=Setting::where('user_id',Auth::id())->first();
        if(!empty($setting->instagram_accaunt)) {
            $response = Unirest\Request::get("https://madde22-instagram-v1.p.mashape.com/Instagram/GetRecentImages?Username=" . $setting->instagram_accaunt,
                array(
                    "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C"
                )
            );
        }
       $response=$response->body;

        return view('instagram.index', compact('arrTabs', 'active','title','setting','response','path'));
    });
    Route::post('/set_instagram',function (){
        $user_id=Auth::id();
        $instagram_accaunt=request()->get('instagram');
        $setting=Setting::where('user_id',$user_id)->first();
            $setting->instagram_accaunt=$instagram_accaunt;
            $setting->save();
        $response = Unirest\Request::get("https://madde22-instagram-v1.p.mashape.com/Instagram/GetRecentImages?Username=".$instagram_accaunt,
            array(
                "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C"
                )
                );
        return ['result'=>$response->body];
    });


    Route::get('/check_email',function(){
        $arrTabs=['General'];
        $active="active";
        $title="Check Email";
       //$path="/laravelvue/";
       $path="";
        return view('check_email.index', compact('arrTabs', 'active','title','path'));
    });


    Route::post('/check_email_get',function (){
        $check_email=request()->get('check_email');
        $response = Unirest\Request::get("https://pozzad-email-validator.p.mashape.com/emailvalidator/validateEmail/".$check_email,
            array(
                "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
                "Accept" => "application/json"
            )
        );
        if( $response->body->isValid){
            $response=true;
        }else{
            $response=false;
        }
        return ['result'=>$response];
    });

    Route::get('/unlike/{id}', [
        'uses' => 'ArticleLikesController@unlike'
    ]);
    Route::get('/countries', function()
    {
        $countries=Countries::getList('en', 'php');
        $countries=array_values($countries);
        return $countries;
    });
//    Route::get('/translates', function()
//    {
//        $translator = new Dedicated\GoogleTranslate\Translator;
//
//
//        $result = $translator->setSourceLang('en')
//            ->setTargetLang('fr')
//            ->translate('Hello World');
//
//        dd($result); // "Привет мир"
//       // return view('test');
//    });
    Route::get('/redis/{id}','RedisController@showArticle');
//    Route::get('/redis', function()
//    {
//        $redis = Illuminate\Support\Facades\Redis::connection();
//
//        $redis->set('first_name','Alex');
//        $response = $redis->get('first_name');
//
//        return $response;
//    });
  //  Route::get('/imaget', function()
 //   {
   //     $path="/laravelvue/";
   //     $myDirectory = opendir(public_path()."/images/emoji/flag");
   //     while($entryName = readdir($myDirectory)) {
   //         $extension = substr($entryName, -3);
    //        if ($extension == 'png') {
    //            $emojiFlags[] = $entryName;
    //            break;
    //        }

     //   }
     //   closedir($myDirectory);
     //   return view('test', compact('emojiFlags','path'));
    //});

  //      Route::get('/api_test', function()
  //  {
   //     $response = \Unirest\Request::get("https://currencyconverter.p.mashape.com/?from=USD&from_amount=2&to=THB",
   //         array(
    //            "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
     //           "Accept" => "application/json"
     //       )
     //   );
    //  return $response->body->to_amount;
   // });
//    Route::get('/api_instagram', function()
//    {
//        $response = Unirest\Request::get("https://madde22-instagram-v1.p.mashape.com/Instagram/GetRecentImages?Username=maksim_kl",
//            array(
//                "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C"
//                )
//                );
//        foreach ($response->body as $post){
//            echo "<img width='50' src='".$post->DisplayUrl."' ><br>====<br>";
//        };
//    });

    // Route::get('/api_geolocation', function()
    //{
    //    $response = Unirest\Request::get("https://michele-zonca-google-geocoding.p.mashape.com/geocode/json?address=Minsk Pushkinskaya&sensor=true",
    //      array(
    //        "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
    //        "Accept" => "application/json"
     //     )
    //    );
    //    return $response->body->results;
   // });

   //  Route::get('/api_ip', function()
   // {
    //  $response = Unirest\Request::get("https://chrislim2888-ip-address-geolocation.p.mashape.com/?key=a3eea96c43a147abd76a83b5b5c78e423948454a6eaa2d59376ab0b596e43c27&format=json&ip=86.57.110.130",
    //          array(
     //           "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
      //          "Accept" => "text/plain"
       //       )
      //      );
      //  return $response->body->countryName;
   // });

//       Route::get('/api_ip', function()
//    {
//      $response = Unirest\Request::get("https://chrislim2888-ip-address-geolocation.p.mashape.com/?key=a3eea96c43a147abd76a83b5b5c78e423948454a6eaa2d59376ab0b596e43c27&format=json&ip=86.57.110.130",
//              array(
//                "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
//                "Accept" => "text/plain"
//              )
//            );
//        return $response->body->countryName;
//    });


//      Route::get('/api_country_code', function()
//    {
//         $response = Unirest\Request::get("https://restcountries-v1.p.mashape.com/alpha/?codes=MYS",
//              array(
//                "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
//                "Accept" => "application/json"
//              )
//            );
//        return $response->body;
//    });
//
//      Route::get('/api_country_name', function()
//    {
//         $response = Unirest\Request::get("https://restcountries-v1.p.mashape.com/name/belarus",
//          array(
//            "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
//            "Accept" => "application/json"
//          )
//        );
//        return $response->body;
//    });
//
//    Route::get('/api_country_capital', function()
//    {
//           $response = Unirest\Request::get("https://restcountries-v1.p.mashape.com/capital/bangkok",
//                array(
//                        "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
//                        "Accept" => "application/json"
//                      )
//                    );
//        return $response->body;
//    });
//
//    Route::get('/api_country_currency', function()
//    {
//        $response = Unirest\Request::get("https://restcountries-v1.p.mashape.com/currency/THB",
//                 array(
//                             "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
//                             "Accept" => "application/json"
//                        )
//                );
//        return $response->body;
//    });
    //Email validation API
//     Route::get('/api_valid_email', function()
//         {
//               $response = Unirest\Request::get("https://pozzad-email-validator.p.mashape.com/emailvalidator/validateEmail/narushevich.maksim@gmail.com",
//          array(
//            "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
//            "Accept" => "application/json"
//          )
//        );
//        if( $response->body->isValid){
//            return "True";
//        }else{
//            return "False";
//        }
//    });
//
//    //Currency exchange API
//     Route::get('/api_currency_exchange', function()
//                 {
//        $response = Unirest\Request::get("https://currency-exchange.p.mashape.com/exchange?from=USD&q=1.0&to=MYR",
//          array(
//            "X-Mashape-Key" => "HDAKHJDVEYmshOdHwHPotXgpZlrqp1tXLkkjsnlgvVAGTAnm6C",
//            "Accept" => "text/plain"
//          )
//        );
//        return $response->body;
//    });
//      Route::get('/gifts', function()
//       {
//         //$path="/laravelvue/";
//         $path="";
//         $myDirectory = opendir(public_path()."/images/gifts/");
//         while($entryName = readdir($myDirectory)) {
//             $extension = substr($entryName, -3);
//            if ($extension == 'png') {
//                $gifts[] = $entryName;
//
//            }
//
//       }
//       closedir($myDirectory);
//       return view('test', compact('gifts','path'));
//    });

});
