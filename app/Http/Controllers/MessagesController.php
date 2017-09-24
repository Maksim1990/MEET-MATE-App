<?php

namespace App\Http\Controllers;

use App\Notice;
use App\User;
use App\Message;
use Auth;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
//    public $path="/laravelvue/";
    public $path="";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrTabs=['General','Settings'];
        $active="active";
        $path=$this->path;
        $messages=Message::where('user_id',Auth::id())->orWhere('receiver_id',Auth::id())->get();

        $receivers=[];
        $messages1=Message::where('user_id',Auth::id())->get();
        foreach ($messages1 as $message){
            array_push($receivers, $message->receiver_id);
        }
        $users=[];
        $messages2=Message::where('receiver_id',Auth::id())->get();
        foreach ($messages2 as $message){
            array_push($users, $message->user_id);
        }
        $users=array_merge($users,$receivers);

        $users=array_unique($users);
        $users=User::whereIn('id',$users)->get();
        return view('chat.index', compact('arrTabs', 'active','path','messages','users'));
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
        $arrTabs=['General','Settings'];
        $active="active";
        $chat_user=User::findOrFail($id);
        $path=$this->path;
        Notice::where('module_id','4')->where('user_sender_id',$id)->delete();
        $messages=Message::whereIn('receiver_id',[Auth::id(),$id])->whereIn('user_id',[Auth::id(),$id])->get();
        foreach ($messages as $mes)
        {
            $mes->read_already=1;
            $mes->save();
        }
        return view('chat.chat_user', compact('arrTabs', 'active','path','chat_user'));
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
    
    public function markAsRead(Request $request)
    {
        $message_id=$request['message_id'];
        $message=Message::findOrFail($message_id);
        $message->read_already=1;
        $message->save();
        Notice::where('module_id','4')->where('module_item_id',$message_id)->delete();
        return ["status"=>true];
    }
    
    
}
