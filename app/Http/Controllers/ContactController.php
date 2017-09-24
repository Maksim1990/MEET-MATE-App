<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Photo;
use App\ContactImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public $path="";
//public $path="/laravelvue/";

    public function index()
    {
        $arrTabs=['General','Settings'];
        $active="active";
        $path=$this->path;
        $contacts=Contact::all();
        return view('contacts.index', compact('contacts','arrTabs', 'active','path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        $countries=\Countries::getList('en', 'php');
        return view('contacts.create',compact('arrTabs', 'active','path','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->all();
        if($file=$request->file('photo_id'))
        {
            $name=time().$file->getClientOriginalName();
            $file->move('images',$name);
            $photo=Photo::create(['path'=>$name]);
            $input['photo_id']=$photo->id;
        }
        $input['user_id']=Auth::id();
        $contact=Contact::create($input);
        ContactImage::create(['photo_id'=>$input['photo_id'], 'user_id'=>Auth::id(),'contact_id'=>$contact->id]);
        Session::flash('contact_change','Contact has been successfully created!');
        return redirect('contact_list/'.$contact->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact=Contact::findOrFail($id);
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        $countries=\Countries::getList('en', 'php');
        $country=$countries[$contact->country];
        return view('contacts.show',compact('arrTabs', 'active','contact','country','path'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact=Contact::findOrFail($id);


        $path=$this->path;
        $arrTabs=['General','Password','Profile'];
        $active="active";
        $countries=\Countries::getList('en', 'php');
        return view('contacts.edit',compact('arrTabs', 'active','contact','path','countries'));
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

        $contact=Contact::findOrFail($id);
        $input=$request->all();
        if($file=$request->file('photo_id'))
        {
            if($contact->photo) {
                unlink(public_path() . $contact->photo->path);
            }
            $photo_contact=Photo::findOrFail($contact->photo_id);
            $photo_contact->delete();
            $name=time().$file->getClientOriginalName();
            $file->move('images',$name);
            $photo=Photo::create(['path'=>$name]);
            $input['photo_id']=$photo->id;
            $contactImage=ContactImage::where('contact_id',$id)->first();
            $contactImage->photo_id=$input['photo_id'];
            $contactImage->update();
        }
        $input['user_id']=Auth::id();
        $contact->update($input);
        Session::flash('contacts_change','Contact has been successfully updated!');
        return redirect('contact_list/'.$id);
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
}
