<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommunityPost;
use App\Friendship;
use App\Gift;
use App\Like;
use App\Message;
use App\Notice;
use App\Post;
use App\User;
use App\UserCommunity;
use App\WallComment;
use App\Community;
use App\UserWall;
use Illuminate\Http\Request;
use Auth;

class NoticeController extends Controller
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
        $arrTabs=['General'];
        $active="active";
        $title="Notifications";
        $arrInvitations=[];
        $arrMessages=[];
        $emptyLikes=true;
        //-- Notifications about new Community invitations
        $noticesUserCommunity=Notice::where('module_id','3')->where('user_id',Auth::id())->orderBy('id','desc')->get();
        foreach ($noticesUserCommunity as $item){
            $arrInvitations[]=$item->user_sender_id;
        }
        if(!empty($arrInvitations)){
        $invitations=UserCommunity::where('user_id',Auth::id())->whereIn('user_inviter_id',$arrInvitations)->where('accepted',0)->orderBy('id','desc')->get();
            }
        else
        {
            $invitations='false';
        }
        //-- Notifications about new messages
        $noticesMessages=Notice::where('module_id','4')->where('user_id',Auth::id())->orderBy('id','desc')->get();
        foreach ($noticesMessages as $item){
            $arrMessages[]=$item->user_sender_id;
        }
        if(!empty($arrMessages)){
            $messages=Message::where('receiver_id',Auth::id())->whereIn('user_id',$arrMessages)->where('read_already',0)->orderBy('id','desc')->get();
        }
        else
        {
            $messages='false';
        }

        //-- Notifications about new likes of posts on your profile wall
        $noticesUserWall=UserWall::where('wall_user_id',Auth::id())->get();
        foreach ($noticesUserWall as $item){
            $arrLikesUserWall[]=$item->id;
        }

        $noticesLikesWall=Notice::where('module_id','5')->whereIn('module_item_id',$arrLikesUserWall)->orderBy('id','desc')->get();
        foreach ($noticesLikesWall as $item){
            $arrModuleItemId[]=$item->module_item_id;
        }


        if(!empty($arrModuleItemId)){
            $likesWall=Like::whereIn('item_id',$arrModuleItemId)->where('read_already',0)->orderBy('id','desc')->get();
            foreach ($likesWall as $like){
                $post=UserWall::findOrFail($like->item_id);
                    $like['post_id'] = $post->id;
                    $like['post_name'] = $post->text;
                    $like['wall_user_id'] = $post->wall_user_id;
            }


        }
        else
        {
            $likesWall='false';
        }


        //-- Notifications about new received gifts
        $noticesGifts=Notice::where('module_id','7')->where('user_id',Auth::id())->orderBy('id','desc')->get();
        foreach ($noticesGifts as $item){
            $arrGifts[]=$item->user_sender_id;
        }
        if(!empty($arrGifts)){
            $gifts=Gift::where('user_receiver_id',Auth::id())->whereIn('user_sender_id',$arrGifts)->where('read_already',0)->orderBy('id','desc')->get();
        }
        else
        {
            $gifts='false';
        }


        //-- Notifications about friends requests
        $noticesFriends=Notice::where('module_id','6')->where('user_id',Auth::id())->orderBy('id','desc')->get();

        foreach ($noticesFriends as $item){
            $arrRequests[]=$item->user_sender_id;
        }

        if(!empty($arrRequests)){
            $friend_requests=Friendship::where('user_requested',Auth::id())->whereIn('requester',$arrRequests)->where('status',0)->orderBy('id','desc')->get();
        }
        else
        {
            $friend_requests='false';
        }


        //-- Notifications about new posts on your wall
        $noticesWallPosts=Notice::where('module_id','8')->where('user_id',Auth::id())->orderBy('id','desc')->get();

        foreach ($noticesWallPosts as $item){
            $arrWallPosts[]=$item->user_sender_id;
        }

        if(!empty($arrWallPosts)){
            $wall_posts=UserWall::where('wall_user_id',Auth::id())->whereIn('user_post_id',$arrWallPosts)->where('read_already',0)->orderBy('id','desc')->get();
        }
        else
        {
            $wall_posts='false';
        }


        //-- Notifications about new posts on your community
        $noticesCommunityPosts=Notice::where('module_id','9')->where('user_id',Auth::id())->orderBy('id','desc')->get();

        foreach ($noticesCommunityPosts as $item){
            $arrCommunityPosts[]=$item->user_sender_id;
        }

        if(!empty($arrCommunityPosts)){
            $community_posts=CommunityPost::whereIn('id',$arrCommunityPosts)->where('read_already',0)->orderBy('id','desc')->get();
            foreach ($community_posts as $item){
                $community=Community::findOrFail($item->community_id);
                $item['community_name'] = $community->name;
            }
        }
        else
        {
            $community_posts='false';
        }


        //-- Notifications about new comments on your wall
        $noticesWallComments=Notice::where('module_id','10')->where('user_id',Auth::id())->orderBy('id','desc')->get();

        foreach ($noticesWallComments as $item){
            $arrWallComments[]=$item->user_sender_id;
        }

        if(!empty($arrWallComments)){
            $wall_comments=WallComment::where('user_id',Auth::id())->whereIn('wall_user_id',$arrWallComments)->where('read_already',0)->orderBy('id','desc')->get();
            foreach ($wall_comments as $item){
                $post=UserWall::findOrFail($item->post_id);
                $item['post_name'] = $post->text;
            }
        }
        else
        {
            $wall_comments='false';
        }


        //-- Notifications about new comments on your community
        $noticesCommunityComments=Notice::where('module_id','11')->where('user_id',Auth::id())->orderBy('id','desc')->get();

        foreach ($noticesCommunityComments as $item){
            $arrCommunityComments[]=$item->user_sender_id;
        }

        if(!empty($arrCommunityComments)){
            $community_comments=Comment::whereIn('id',$arrCommunityComments)->where('read_already',0)->orderBy('id','desc')->get();
            foreach ($community_comments as $item){
                $community=Community::findOrFail($item->community_id);
                $post=CommunityPost::findOrFail($item->post_id);
                $item['community_name'] = $community->name;
                $item['post_name'] = $post->text;
            }
        }
        else
        {
            $community_comments='false';
        }
        
        
              //-- Notifications about new likes in your community
    $noticesCommunityPost=Community::where('user_id',Auth::id())->get();
        foreach ($noticesCommunityPost as $item){
            $arrLikesPostCommunity[]=$item->id;
        }

        $noticesLikesCommunity=Notice::where('module_id','2')->whereIn('module_item_id',$arrLikesPostCommunity)->orderBy('id','desc')->get();
        foreach ($noticesLikesCommunity as $item){
            $arrModuleItemId[]=$item->module_item_id;
        }

  if(!empty($arrModuleItemId)){
  $noticesListPostsInCommunity=CommunityPost::whereIn('community_id',$arrModuleItemId)->orderBy('id','desc')->get();
        foreach ($noticesListPostsInCommunity as $item){
            $arrListPostsInCommunity[]=$item->id;
        }
  }

        if(!empty($arrListPostsInCommunity)){
            $community_likes=Like::whereIn('item_id',$arrListPostsInCommunity)->where('module_id',2)->where('like',1)->where('read_already',0)->orderBy('id','desc')->get();
            foreach ($community_likes as $like){
                $post=CommunityPost::findOrFail($like->item_id);
                $community=Community::findOrFail($post->community_id);
                    $like['post_id'] = $post->id;
                    $like['post_name'] = $post->text;
                    $like['community_id'] = $community->id;
                    $like['community_name'] = $community->name;
            }


        }
        else
        {
            $community_likes='false';
        }



        //-- Notifications about new like on your post in blog
        $noticesBlogLikes=Notice::where('module_id','1')->where('user_id',Auth::id())->orderBy('id','desc')->get();

        foreach ($noticesBlogLikes as $item){
            $arrBlogLikes[]=$item->module_item_id;
        }

        if(!empty($arrBlogLikes)){
            $blog_likes=Like::whereIn('item_id',$arrBlogLikes)->where('module_id',1)->where('like',1)->where('read_already',0)->orderBy('id','desc')->get();
            foreach ($blog_likes as $item){
                $post=Post::findOrFail($item->item_id);
                $item['post_name'] = $post->title;
                $item['post_id'] = $post->id;
            }
        }
        else
        {
            $blog_likes='false';
        }
     
if($invitations=='false' && $likesWall=='false' && $messages=='false' && $gifts=='false' && $friend_requests=='false' && $wall_posts=='false' && $community_posts=='false' && $wall_comments=='false' && $community_comments=='false' && $community_likes=='false' && $blog_likes=='false' ){
    $emptyLikes=false;
}
       // return  $blog_likes;
   return view('layouts.notices', compact('arrTabs', 'active','title','path','emptyLikes','invitations','likesWall','messages','gifts','friend_requests','wall_posts','community_posts','wall_comments','community_comments','community_likes','blog_likes'));
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

    public function checkNotice(Request $request)
    {
        $notices=Notice::where('user_id',Auth::id())->get();
        $notices=count($notices);
        return ["quantity"=>$notices];


    }



}
