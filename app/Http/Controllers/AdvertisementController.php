<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\CommunityType;
use App\Category;
use App\ImageAdvertisement;
use App\Photo;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   //public $path="/laravelvue/";
    public $path="";
    public function index()
    {
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        $title='Advertisements';
        $category=Category::pluck('name','id')->all();
        $type=CommunityType::pluck('name','id')->all();
        $adds=Advertisement::where('id','>','0')->orderBy('id')->paginate(10);
        return view('advertisements.index', compact('arrTabs', 'active', 'adds','path','title','category','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types=CommunityType::pluck('name','id')->all();
        $arrTabs=['General'];
        $active="active";
        $path=$this->path;
        return view('advertisements.create', compact('arrTabs', 'active','types','path'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file=$request->file('photo_id');
        if(!($file->getClientSize()>2100000)){
            $input=$request->all();
            $user=Auth::user();
            if($file=$request->file('photo_id'))
            {
                $name=time().$file->getClientOriginalName();
                $file->move('images',$name);
                $photo=Photo::create(['path'=>$name]);
                $input['photo_id']=$photo->id;
            }
            $input['user_id']=$user->id;
            $adds=Advertisement::create($input);
            ImageAdvertisement::create(['advertisement_id'=>$adds->id,'photo_id'=>$input['photo_id']]);
            Session::flash('add_change','New advertisement has been successfully created!');
            return redirect('advertisement/'.$adds->id);
        }else{
            Session::flash('add_change','Image size should not exceed 2 MB');
            return redirect('advertisement/create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $add=Advertisement::findOrFail($id);
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        $adds=Advertisement::where('id','>','0')->where('id','!=',$id)->where('show_to_friends','Y')->where('active','Y')
            ->orderBy('id','desc')->limit(10)->get();
        //return $add;
        return view('advertisements.show',compact('arrTabs', 'active','add','path','adds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adds=Advertisement::findOrFail($id);

        $types=CommunityType::pluck('name','id')->all();
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        return view('advertisements.edit',compact('arrTabs', 'active','adds','path','types'));
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
        $add=Advertisement::findOrFail($id);
        $input = $request->all();

        if ($file = $request->file('photo_id')) {
            if (!($file->getClientSize() > 2100000)) {
                if($add->image->photo) {
                    unlink(public_path() . $add->image->photo->path);
                }
                $photo_user=Photo::findOrFail($add->photo_id);
                $photo_user->delete();

                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['path' => $name]);
                $input['photo_id'] = $photo->id;
                $imageAdd=ImageAdvertisement::where('advertisement_id',$id)->first();
                if($imageAdd){
                    $imageAdd->photo_id=$input['photo_id'];
                    $imageAdd->save();
                }else{
                    ImageAdvertisement::create(['advertisement_id'=>$id,'photo_id'=>$input['photo_id']]) ;
                }

            } else {
                Session::flash('add_change', 'Image size should not exceed 2 MB');
                return redirect('advertisement/'.$id.'/edit');
            }
        }

        $add->update($input);
        Session::flash('add_change','Advertisement has been successfully updated!');
        return redirect('advertisement/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adds=Advertisement::findOrFail($id);
        unlink(public_path().$adds->image->photo->path);
        Photo::findOrfail($adds->image->photo->id)->delete();
        ImageAdvertisement::where('advertisement_id',$id)->delete();
        Session::flash('add_change','Advertisement has been successfully deleted!');
        $adds->delete();
        return redirect('advertisement');
    }

    public function search(Request $request)
    {
        $category_id=$request['category_id'];
        $type_id=$request['type_id'];
        $title=$request['title'];
        $description=$request['description'];
        $searchTitle=(!empty($title))?$title:"";
        $searchDescription=(!empty($description))?$description:"";
        if(!empty($type_id)){
            $advertisements=Advertisement::where('category_id',$category_id)
                ->where('title', 'like', '%' . $searchTitle . '%')->where('description', 'like', '%' . $searchDescription . '%')->get();
        }else{
            $advertisements=Advertisement::where('title', 'like', '%' . $searchTitle . '%')
                ->where('description', 'like', '%' . $searchDescription . '%')->get();
        }
        return ["data"=> $advertisements];
    }


}
