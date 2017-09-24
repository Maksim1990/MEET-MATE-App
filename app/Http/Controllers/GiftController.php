<?php

namespace App\Http\Controllers;

use App\Gift;
use App\Notice;
use Illuminate\Http\Request;

class GiftController extends Controller
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
    public function sendGift(Request $request)
    {
        $gift_image_path=$request['gift_image_path'];
        $gift_text=$request['gift_text'];
        $user_receiver_id=$request['user_receiver_id'];
        $user_sender_id=$request['user_sender_id'];
        $gift=Gift::create(['gift_path'=>$gift_image_path,'gift_text'=>$gift_text,'user_receiver_id'=>$user_receiver_id,'user_sender_id'=>$user_sender_id]);
        Notice::create(['user_id'=>$user_receiver_id,'user_sender_id'=>$user_sender_id,'module_item_id'=>$gift->id,'module_id'=>'7','module_name'=>'Gifts']);
        return ["status"=>true,
        "gift_image_path"=>$gift_image_path];
    }
    public function deleteGift(Request $request)
    {
        $gift_id=$request['gift_id'];
        Gift::findOrFail($gift_id)->delete();
        return ["status"=>true,
        "gift_id"=>$gift_id];
    }

    public function hideInvitation(Request $request)
    {
        $gift_id=$request['gift_id'];
        $gift=Gift::findOrFail($gift_id);
        $gift->read_already='1';
        $gift->save();
        Notice::where('module_id','7')->where('module_item_id',$gift_id)->delete();
        return ["status"=>true];
    }


}
