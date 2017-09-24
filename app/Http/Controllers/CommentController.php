<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Community;
use App\Notice;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $path="/laravelvue/";
    //public $path="";
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

    public function addComment(Request $request)
    {
        $comment=$request['comment'];
        $community_id=$request['community_id'];
        $user_id=$request['user_id'];
        $module_id=$request['module_id'];
        $module_name=$request['module_name'];
        $post_id=$request['post_id'];
        $community=Community::findOrFail($community_id);
        $comment=Comment::create(['user_id'=>$user_id,'community_id'=>$community_id,'comment'=>$comment,'module_id'=>$module_id,'module_name'=>$module_name,'post_id'=>$post_id]);
        Notice::create(['user_id'=>$community->user->id,'user_sender_id'=>$comment->id,'module_item_id'=>$community_id,'module_id'=>'11','module_name'=>'CommunityPostComments']);
        return ["status"=>true,
            "comment_id"=>$comment->id,
            "user_id"=>$comment->user_id];
    }

    public function editComment(Request $request)
    {
        $post_id=$request['post_id'];
        $comment_id=$request['comment_id'];
        $community_id=$request['community_id'];
        $comment_text=$request['comment_text'];
        $communityCommment=Comment::where('post_id',$post_id)->where('community_id',$community_id)->where('id',$comment_id)->first();
        $communityCommment->comment=$comment_text;
        $communityCommment->update();
        return ["status"=>true];
    }

    public function deleteComment(Request $request)
    {
        $post_id=$request['post_id'];
        $comment_id=$request['comment_id'];
        $community_id=$request['community_id'];
        Comment::where('post_id',$post_id)->where('community_id',$community_id)->where('id',$comment_id)->delete();
        return ["status"=>true,
            "comment_id"=>$comment_id];
    }

    public function hideInvitation(Request $request)
    {

        $comment_id=$request['comment_id'];
        $comment=Comment::findOrFail($comment_id);
        $comment->read_already='1';
        $comment->save();
        Notice::where('module_id','11')->where('user_sender_id',$comment->id)->delete();
        return ["status"=>true];
    }


}
