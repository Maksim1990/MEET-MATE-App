<?php

namespace App\Http\Controllers;

use App\Notice;
use App\WallComment;
use Illuminate\Http\Request;

class WallCommentController extends Controller
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
        $wall_user_id=$request['wall_user_id'];
        $user_id=$request['user_id'];
        $module_id=$request['module_id'];
        $module_name=$request['module_name'];
        $post_id=$request['post_id'];
        $wall_comment=WallComment::create(['user_id'=>$user_id,'wall_user_id'=>$wall_user_id,'comment'=>$comment,'module_id'=>$module_id,'module_name'=>$module_name,'post_id'=>$post_id]);
        Notice::create(['user_id'=>$wall_user_id,'user_sender_id'=>$user_id,'module_item_id'=>$wall_comment->id,'module_id'=>'10','module_name'=>'UserWallComments']);
        return ["status"=>true];
    }

    public function editComment(Request $request)
    {
        $post_id=$request['post_id'];
        $comment_id=$request['comment_id'];
        $wall_user_id=$request['wall_user_id'];
        $comment_text=$request['comment_text'];
        $communityCommment=WallComment::where('post_id',$post_id)->where('wall_user_id',$wall_user_id)->where('id',$comment_id)->first();
        $communityCommment->comment=$comment_text;
        $communityCommment->update();
        return ["status"=>true];
    }

    public function deleteComment(Request $request)
    {
        $post_id=$request['post_id'];
        $comment_id=$request['comment_id'];
        $wall_user_id=$request['wall_user_id'];
        WallComment::where('post_id',$post_id)->where('wall_user_id',$wall_user_id)->where('id',$comment_id)->delete();
        return ["status"=>true,
            "comment_id"=>$comment_id];
    }

    public function hideInvitation(Request $request)
    {

        $comment_id=$request['comment_id'];
        $comment=WallComment::findOrFail($comment_id);
        $comment->read_already='1';
        $comment->save();
        Notice::where('module_id','10')->where('module_item_id',$comment->id)->delete();
        return ["status"=>true];
    }
    
    
}
