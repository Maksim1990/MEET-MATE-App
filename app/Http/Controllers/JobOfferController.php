<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Category;
use App\CommunityType;
use App\Http\Requests\JobsCreateRequest;
use App\ImageJob;
use App\JobOffer;
use App\Photo;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JobOfferController extends Controller
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
        $arrTabs=['General','Settings'];
        $active="active";
        $jobs=JobOffer::where('id','>','0')->orderBy('id')->paginate(10);
        $title='Job offers';
        $category=Category::pluck('name','id')->all();
        $type=CommunityType::pluck('name','id')->all();

        //return $jobs;
        return view('joboffer.index', compact('arrTabs', 'active', 'jobs','path','title','category','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types=CommunityType::pluck('name','id')->all();
        $adds=Advertisement::where('user_id',Auth::id())->pluck('title','id')->all();
        $arrTabs=['General'];
        $active="active";
        $title='Create job offer';
        $path=$this->path;
        $countries=\Countries::getList('en', 'php');
        return view('joboffer.create', compact('arrTabs', 'active','types','path','adds','countries','title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobsCreateRequest $request)
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
            $job=JobOffer::create($input);
            Session::flash('job_change','New job has been successfully created!');

            ImageJob::create(['job_id'=>$job->id,'photo_id'=>$input['photo_id']]);
            Session::flash('job_change','New advertisement has been successfully created!');
            return redirect('jobs/'.$job->id);
        }else{
            Session::flash('job_change','Image size should not exceed 2 MB');
            return redirect('jobs/create');
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
        $job=JobOffer::findOrFail($id);
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        $countries=\Countries::getList('en', 'php');
        if(isset($job->country) && !empty($job->country) ){
            $country=$countries[$job->country];
        }else{
            $country='Not defined';
        }
        $jobs=JobOffer::where('id','>','0')->where('id','!=',$id)->where('show_to_friends','Y')->where('active','Y')
            ->orderBy('id','desc')->limit(10)->get();
        return view('joboffer.show',compact('arrTabs', 'active','job','path','country','jobs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job=JobOffer::findOrFail($id);
        $adds=Advertisement::where('user_id',Auth::id())->pluck('title','id')->all();
        $types=CommunityType::pluck('name','id')->all();
        $path=$this->path;
        $arrTabs=['General'];
        $active="active";
        $title='Edit job offer';
        $countries=\Countries::getList('en', 'php');
        return view('joboffer.edit',compact('arrTabs', 'active','job','path','adds','types','countries','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobsCreateRequest $request, $id)
    {

        $job=JobOffer::findOrFail($id);
        $input=$request->all();

        if ($file = $request->file('photo_id')) {
            if (!($file->getClientSize() > 2100000)) {
                if($job->image->photo) {
                    unlink(public_path() . $job->image->photo->path);
                }
                $photo_user=Photo::findOrFail($job->photo_id);
                $photo_user->delete();

                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['path' => $name]);
                $input['photo_id'] = $photo->id;
                $imageAdd=ImageJob::where('job_id',$id)->first();
                if($imageAdd){
                    $imageAdd->photo_id=$input['photo_id'];
                    $imageAdd->save();
                }else{
                    ImageJob::create(['job_id'=>$id,'photo_id'=>$input['photo_id']]) ;
                }

            } else {
                Session::flash('job_change', 'Image size should not exceed 2 MB');
                return redirect('jobs/'.$id.'/edit');
            }
        }
        $job->update($input);
        Session::flash('job_change','Job has been successfully updated!');
        return redirect('jobs/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job=JobOffer::findOrFail($id);
        Session::flash('job_change','Job has been successfully deleted!');
        $job->delete();
        return redirect('jobs');
    }

    public function search(Request $request)
    {
        $category_id=$request['category_id'];
        $type_id=$request['type_id'];
        $company_name=$request['company_name'];
        $title=$request['title'];
        $description=$request['description'];
        $searchCompany=(!empty($company_name))?$company_name:"";
        $searchTitle=(!empty($title))?$title:"";
        $searchDescription=(!empty($description))?$description:"";
        if(!empty($type_id)){
            $jobs=JobOffer::where('category_id',$category_id)->where('type_id',$type_id)->where('company_name', 'like', '%' . $searchCompany . '%')
                ->where('title', 'like', '%' . $searchTitle . '%')->where('description', 'like', '%' . $searchDescription . '%')->get();
        }else{
            $jobs=JobOffer::where('company_name', 'like', '%' . $searchCompany . '%')->where('title', 'like', '%' . $searchTitle . '%')
                ->where('description', 'like', '%' . $searchDescription . '%')->get();
        }
        return ["data"=> $jobs];
    }


}
