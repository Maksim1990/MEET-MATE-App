<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
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
    public function showSidebar(Request $request)
    {

        $active_left_sidebar=$request['active_left_sidebar'];
        if($active_left_sidebar=='Y'){
            $active_left_sidebar='N';
        }else{
            $active_left_sidebar='Y';
        };
        $user_id=$request['user_id'];
        $setting=Setting::where('user_id',$request['user_id'])->first();
        if($setting){
            $setting->update(['active_left_sidebar' => $active_left_sidebar, 'user_id' => $user_id]);
            $setting->save();
        }else{
            Setting::create(['active_left_sidebar' => $active_left_sidebar, 'user_id' => $user_id]);
        }



    }


}
