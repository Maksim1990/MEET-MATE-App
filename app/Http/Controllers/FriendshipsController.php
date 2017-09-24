<?php

namespace App\Http\Controllers;

use App\Friendship;
use App\Notice;
use App\Notifications\FriendRequestAccepted;
use App\Notifications\NewFriendRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class FriendshipsController extends Controller 
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

    public function check($id)
    {
       if(Auth::user()->isFriendWith($id)===1){
           return ["status"=>"friends"];
       }
        if(Auth::user()->hasPendingFriendRequestFrom($id)){
            return ["status"=>"pending"];
        }
        if(Auth::user()->hasPendingFriendRequestTo($id)){
            return ["status"=>"waiting"];
        }
        return ["status"=>0];
    }

    public function add_friend($id)
    {
        $resp=Auth::user()->addFriend($id);
        User::find($id)->notify(new NewFriendRequest(Auth::user()));
        $friendship=Friendship::where('requester',$id)->orWhere('user_requested',$id)
            ->where('requester',Auth::id())->orWhere('user_requested',Auth::id())->first();
        Notice::create(['user_id'=>$id,'user_sender_id'=>Auth::id(),'module_item_id'=>$friendship->id,'module_id'=>'6','module_name'=>'Friendship']);
        return $resp;
    }
    public function accept_friend($id)
    {
        $resp=Auth::user()->acceptFriend($id);
        User::find($id)->notify(new FriendRequestAccepted(Auth::user()));
        $friendship=Friendship::where('requester',$id)->orWhere('user_requested',$id)
            ->where('requester',Auth::id())->orWhere('user_requested',Auth::id())->first();
        Notice::where('module_item_id',$friendship->id)->delete();
        return $resp;
    }
    
    public function deleteFriend(Request $request){
        $user_id=$request['user_id'];
        $user=User::findOrFail($user_id);
        Friendship::where('requester',$user_id)->orWhere('user_requested',$user_id)->delete();
        $response = array(
            'status' => 'true',
            'user_id'=>$user_id,
            'user_name'=>$user->name

        );

        return Response::json( $response );
    }
    public function addFriend(Request $request){
        $user_id=$request['user_id'];
        $user=User::findOrFail($user_id);
        $friendship=Friendship::create(['requester'=>Auth::id(),'user_requested'=>$user_id]);
        Notice::create(['user_id'=>$user_id,'user_sender_id'=>Auth::id(),'module_item_id'=>$friendship->id,'module_id'=>'6','module_name'=>'Friendship']);

        $response = array(
            'status' => 'true',
            'user_id'=>$user_id,
             'user_name'=>$user->name

        );
        return Response::json( $response );
    }
    public function declineFriend(Request $request){
        $user_id=$request['user_id'];
        $user=User::findOrFail($user_id);
        $friendship=Friendship::where('requester',$user_id)->orWhere('user_requested',$user_id)->first();
        $response = array(
            'status' => 'true',
            'user_id'=>$user_id,
             'user_name'=>$user->name

        );
        Notice::where('module_item_id',$friendship->id)->where('module_id','6')->delete();
        $friendship->delete();
        return Response::json( $response );
    }

    public function acceptFriend(Request $request){
        $user_id=$request['user_id'];
        $user=User::findOrFail($user_id);
        $friendship=Friendship::where('requester',$user_id)->orWhere('user_requested',$user_id)
            ->where('requester',Auth::id())->orWhere('user_requested',Auth::id())->first();
        $friendship->status=1;
        Notice::where('module_item_id',$friendship->id)->delete();
        $friendship->update();

        $response = array(
            'status' => 'true',
            'user_id'=>$user_id,
             'user_name'=>$user->name

        );
        return Response::json( $response );
    }
}
