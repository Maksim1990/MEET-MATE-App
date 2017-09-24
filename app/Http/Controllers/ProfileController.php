<?php

namespace App\Http\Controllers;

use App\Profile;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
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
        $update=false;
        $profile=Profile::where('user_id',Auth::id())->first();
        if($profile){

            $update=true;
        }else{
            $profile=new Profile();
        }
        $profile->status=$request['status'];
        $profile->country=$request['country'];
        $profile->city=$request['city'];
        $profile->user_gender=$request['user_gender'];
        $profile->lastname=$request['lastname'];
        $profile->birthdate=$request['birthdate'];
        if($update){
            $profile->update();
        }else{
            $profile->save();
        }
        Session::flash('user_change','Profile has been successfully updated!');
        return redirect('users/'.Auth::id());

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
    public function updateStatus(Request $request)
    {

        $status=$request['status'];
        $user_id=$request['user_id'];

        $profile=Profile::where('user_id',$request['user_id'])->first();
        if($profile){
            $profile->update(['status' => $status]);
            $profile->save();
        }else{
            Profile::create(['status'=>$status,'user_id'=>$user_id]);
        }

        $response = array(
            'status' => 'true',
            'statusText'=>$status

        );

        return Response::json( $response );
    }

    public function editStatus(Request $request)
    {

        $status=$request['status'];
        $user_id=$request['user_id'];

        Profile::create(['status'=>$status,'user_id'=>$user_id]);

        $response = array(
            'status' => 'true',
            'statusText'=>$status

        );

        return Response::json( $response );
    }
    public function deleteStatus(Request $request)
    {


        $user_id=$request['user_id'];

        $profile=Profile::where('user_id',$user_id)->first();
        $profile->status='0';
        $profile->save();
        $response = array(
            'status' => 'true'

        );

        return Response::json( $response );
    }


}
