<?php

namespace App\Http\Controllers;

use App\Photo;
use App\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminPhotoController extends Controller
{
  public $path="";
//public $path="/laravelvue/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrTabs=['General','Statistics','Messages','Settings'];
        $active="active";
        $path=$this->path;
        $photos=Photo::all();
        return view('admin.media.index', compact('photos','arrTabs', 'active','path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrTabs=['General','Statistics','Messages','Settings'];
        $active="active";
        return view('admin.media.upload', compact('arrTabs', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $file=$request->file('file');

            $name=time().$file->getClientOriginalName();
            $file->move('images',$name);
           $photo=Photo::create(['path'=>$name]);
        $photo_id=$photo->id;
        UserImage::create(['photo_id'=>$photo_id, 'user_id'=>Auth::id()]);
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
        $photo=Photo::findOrFail($id);
            unlink(public_path() . $photo->path);

        Session::flash('photo_change','The photo has been successfully deleted!');
        $photo->delete();
        return redirect('/media');
    }  
    
    public function deleteImage(Request $request)
    {
        $user_id=$request['user_id'];
        $image_id=$request['image_id'];
        $photo=Photo::findOrFail($image_id);
        unlink(public_path() . $photo->path);
        $photo->delete();
        UserImage::where('user_id',$user_id)->where('photo_id',$image_id)->delete();
        $response = array(
            'status' => 'true'
        );
        return Response::json( $response );
    }
}
