<?php

namespace App\Http\Controllers;

use App\CommunityPost;
use App\Community;
use App\Like;
use App\Notice;
use App\UserWall;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
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
        $itemId=$request['itemId'];
        $moduleId=$request['moduleId'];
        $moduleName=$request['moduleName'];
        $isLike=$request['isLike']==='true' ? true : false;
    $update=false;
        $item=Post::findOrFail($itemId);
        if(!$item){
        return null;
        }
        $user=Auth::user();
        $like=$user->likes()->where('id',$itemId)->first();
        if($like){
            $already_like=$like->like;
            $update=true;
            if($already_like==$isLike){
                $like->delete();
                return null;
            }
        }else{
            $like=new Like();
        }
        $like->like=$isLike;
        $like->item_id=$itemId;
        $like->module_id=$moduleId;
        $like->module_name=$moduleName;
        $like->user_id=$user->id;
        if($update){
            $like->update();
        }else{
            $like->save();
        }
        return null;
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
    public function like(Request $request)
    {
        $itemId=$request['itemId'];
        $moduleId=$request['moduleId'];
        $moduleName=$request['moduleName'];
        $isLike=$request['isLike']==='true' ? true : false;
        $update=false;
        $user=Auth::user();
        $like=$user->likes()->where('item_id',$itemId)->where('like',1)->first();
        if($moduleId=='1') {
            $item = Post::findOrFail($itemId);
            if($isLike && !isset($like) ) {
                Notice::create(['user_id' => $item->user_id, 'module_item_id' => $item->id,'user_sender_id' =>Auth::id(), 'module_id' => '1', 'module_name' => 'Post']);
            }else{
                Notice::where('module_id',1)->where('module_item_id',$item->id)->delete();
            }
              
        }elseif ($moduleId=='2') {
            $item = CommunityPost::findOrFail($itemId);
            $community = Community::findOrFail($item->community_id);

            if($isLike && !isset($like) ) {
                Notice::create(['user_id' => $community->user_id, 'user_sender_id' => $item->id, 'module_item_id' => $community->id, 'module_id' => '2', 'module_name' => 'Community']);
            }else{
                Notice::where('user_sender_id',$item->id)->where('module_id',2)->where('module_item_id',$community->id)->delete();
            }
            }elseif ($moduleId=='5') {
            $item = UserWall::findOrFail($itemId);
            if($isLike && !isset($like) ) {
                Notice::create(['user_id'=>$item->wall_user_id,'user_sender_id'=>Auth::id(),'module_item_id'=>$itemId,'module_id'=>'5','module_name'=>'UserWall']);
            }else{
                Notice::where('user_sender_id',Auth::id())->where('module_id',5)->where('module_item_id',$itemId)->delete();
            }

        }
        if(!$item){
            return null;
        }
        $user=Auth::user();
        $like=$user->likes()->where('item_id',$itemId)->first();
        if($like){
            $already_like=$like->like;
            $update=true;
            if($already_like==$isLike){
                $like->delete();
                return null;
            }
        }else{
            $like=new Like();
        }
        $like->like=$isLike;
        $like->item_id=$itemId;
        $like->module_id=$moduleId;
        $like->module_name=$moduleName;
        $like->user_id=$user->id;
        $like->read_already=0;
        if($update){
            $like->update();
        }else{
            $like->save();
        }
    
        return null;
    }

    public function hideInvitation(Request $request)
    {
        $like_id=$request['like_id'];
        $like_post_id=$request['like_post_id'];
        $moduleId=$request['moduleId'];
        $like=Like::findOrFail($like_id);
        $like->read_already='1';
        $like->save();
        Notice::where('module_id',$moduleId)->where('module_item_id',$like_post_id)->delete();
        return ["status"=>true];
    }
    
    
    
    
}
