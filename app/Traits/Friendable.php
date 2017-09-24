<?php

namespace App\Traits;

use App\Friendship;
use App\User;

trait Friendable
{

    public function addFriend($user_requested_id)
    {
        if($this->id===$user_requested_id){
            return response()->json('fail',501);
        }

        if($this->hasPendingFriendRequestTo($user_requested_id)===1){
            return "Friend request already sent";
        }

        if($this->isFriendWith($user_requested_id)===1){
            return "Already friend with this user";
        }



        if($this->hasPendingFriendRequestFrom($user_requested_id)===1){
            return $this->acceptFriend($user_requested_id);
        }

       $friendship=Friendship::create([
           'requester'=>$this->id,
           'user_requested'=>$user_requested_id
       ]);
        if($friendship){
            return 1;
        }else{
            return 0;
        }
    }

    public function acceptFriend($requester)
    {
        if($this->hasPendingFriendRequestFrom($requester)===0){
            return 0;
        }




        $friendship=Friendship::where('requester',$requester)->where('user_requested',$this->id)->first();
        if($friendship){
            $friendship->update([
                'status'=>1
            ]);
            return 1;
        }
        return 0;
    }
    public function friends()
    {
            $friendsRequest = array();
            $f1=Friendship::where('status',1)->where('requester', $this->id)->get();
            foreach ($f1 as $friendship){
                array_push($friendsRequest,User::find($friendship->user_requested));
            };

            $friendsRequested = array();
            $f2=Friendship::where('status',1)->where('user_requested', $this->id)->get();
            foreach ($f2 as $friendship){
                array_push($friendsRequested,User::find($friendship->requester));
            };

            return array_unique(array_merge($friendsRequested,$friendsRequest));
    }

    public function pendingFriendRequests()
    {
        $users = array();
        $friendships=Friendship::where('status',0)->where('user_requested', $this->id)->get();
        foreach ($friendships as $friendship){
            array_push($users ,User::find($friendship->requester));
        };
        return $users;
    }


    public function friendsIds()
    {
        return collect($this->friends())->pluck('id');
    }



    public function isFriendWith($user_id)
    {
        if(in_array($user_id,$this->friendsIds()->toArray())){
            return 1;
        }else{
            return 0;
        }
    }


    public function pendingFriendRequestIds()
    {
        return collect($this->pendingFriendRequests())->pluck('id')->toArray();
    }


    public function pendingFriendRequestSent()
    {
        $users = array();
        $friendships=Friendship::where('status',0)->where('requester', $this->id)->get();
        foreach ($friendships as $friendship){
            array_push($users ,User::find($friendship->user_requested));
        };
        return $users;
    }

    public function pendingFriendRequestSentIds()
    {
        return collect($this->pendingFriendRequestSent())->pluck('id')->toArray();
    }


    public function hasPendingFriendRequestFrom($user_id)
    {
    if(in_array($user_id,$this->pendingFriendRequestIds()))
        {
        return 1;
         }else
        {
        return 0;
        }
    }

    public function hasPendingFriendRequestTo($user_id)
    {
        if(in_array($user_id,$this->pendingFriendRequestSentIds()))
        {
            return 1;
        }else
        {
            return 0;
        }
    }





}