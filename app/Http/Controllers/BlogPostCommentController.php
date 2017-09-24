<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPostComment;

class BlogPostCommentController extends Controller
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
        $user_id=$request['user_id'];
        $module_id=$request['module_id'];
        $module_name=$request['module_name'];
        $post_id=$request['post_id'];
        $comment=BlogPostComment::create(['user_id'=>$user_id,'comment'=>$comment,'module_id'=>$module_id,'module_name'=>$module_name,'post_id'=>$post_id]);
        return ["status"=>true,
        "comment_id"=>$comment->id,
        "user_id"=>$comment->user_id];
    }

    public function deleteComment(Request $request)
    {
        $comment_id=$request['comment_id'];
        BlogPostComment::where('id',$comment_id)->delete();
        return ["status"=>true,
            "comment_id"=>$comment_id];
    }
    
    public function editComment(Request $request)
    {
        $comment_id=$request['comment_id'];
        $comment_text=$request['comment_text'];
        $comment=BlogPostComment::where('id',$comment_id)->first();
        $comment->comment=$comment_text;
        $comment->save();
        return ["status"=>true,
            "comment_id"=>$comment_id];
    }



}
