<?php

namespace App\Http\Controllers;

use App\Dashboard;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //public $path="/laravelvue/";
    public $path="";
    public function index()
    {
        $arrTabs=['Dashboard','Settings'];
        $active="active";
        $dashboard=Dashboard::where('user_id',Auth::id())->first();
        if(!$dashboard){
            $dashboard=new Dashboard();
            $dashboard->user_id=Auth::id();
            $dashboard->save();
            $dashboard=Dashboard::where('user_id',Auth::id())->first();
        }
        $path=$this->path;
        return view('admin.index', compact('dashboard','arrTabs', 'active','path'));
    }
    public function notifications(){
        $arrTabs=['General'];
        $active="active";
        Auth::user()->unreadNotifications->markAsRead();
        return view('layouts.nots', compact('nots','arrTabs', 'active'))->with('nots', Auth::user()->notifications);
    }

    public function online(Request $request)
    {
        $user_id=$request['user_id'];
        $user=User::findOrFail($user_id);
        $user->online=date('Y-m-d H:i:s');
        $user->update();
        return ["status"=>true
        ];
    }

}
