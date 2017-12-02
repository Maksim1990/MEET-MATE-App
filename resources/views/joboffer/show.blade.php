@extends('layouts.admin')
@section ('scripts_header')
    <link href="{{asset('js/jquery.bxslider.css')}}" rel="stylesheet">
@endsection
@section ('General')

    <div class="col-xs-10 col-sm-10 tab_main_body">
        <div class="col-xs-10 col-sm-12">
            <img style="width: 100%;margin-bottom: 20px;max-height:400px;object-fit: cover;" src="{{$job->image ? $path.$job->image->photo->path :$path."/images/includes/job.jpg"}}" alt="">
        </div>

        <h2 class="w3-center">{{$job->title}}</h2>
        <div class="col-xs-12 col-sm-12 " style="background-color: white;border-radius: 50px;">

        <div class="w3-raw w3-padding-16" style="min-height:150px;margin-bottom:30px;">
        <div class="col-xs-10 col-sm-4 w3-large">
            Description:
        </div>
        <div class="col-xs-10 col-sm-8">
            {{$job->description}}
        </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Company:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$job->company_name}}
            </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Country:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$country}}
            </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                City:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{!empty($job->city)?$job->city:'Not defined'}}
            </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Salary:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$job->salary}}
            </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Created at:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$job->created_at}}
            </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Active till:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$job->active_till}}
            </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Job type:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$job->type_id!=0?$job->type->name:"No type chosen"}}
            </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Job category:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$job->category_id!=0?$job->category->name:"No category chosen"}}
            </div>
        </div>
         <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Contact person:
            </div>
            <div class="col-xs-10 col-sm-8">
                <a style="color:green;;" href="{{ URL::to('users/'.$job->user_id) }}">
                {{$job->user->name}}</a>
            </div>
        </div>
        
        </div>
        <div class="w3-row w3-center" style="width: 100%;border-top:1px dashed gray;margin-top: 500px">
            <h3 ><a style="color:gray;;" href="{{ URL::to('advertisement/') }}">OTHER RECENT JOB OFFERS</a></h3>
        </div>

        @if(count($jobs)>0)
            <div class="w3-row w3-center" style="padding-left:15%;">
                <ul class="bxslider" >
                    @foreach($jobs as $job_item)
                        <li>
                            <a href="{{ URL::to('jobs/' . $job_item->id ) }}">
                                <img data-container="body" data-placement="bottom" data-toggle="tooltip" title="{{$job_item->title}}" src="{{$job_item->image ? $path.$job_item->image->photo->path :$path."/images/noimage.png"}}" />
                            </a>
                        </li>
                    @endforeach
                </ul>
                @else
                    <div class="w3-row w3-center" style="width: 90%">
                        <h6>There are no available job offers now</h6>
                        @endif
                    </div>


    </div>
    <div class="col-xs-10 col-sm-2 w3-center">
        @if($job->user_id==Auth::id())
            <a href="{{ URL::to('jobs/' . $job->id . '/edit') }}" class="btn btn-small btn-success">Edit this job</a>
        @endif
            <a href="{{ URL::to('jobs/create') }}" class="btn btn-small btn-warning">Create new job</a>
    </div>

@stop
@section ('scripts')
            <script src="{{asset('js/jquery.bxslider.js')}}" type="text/javascript"></script>
            <script>
                $('.bxslider').bxSlider({
                    minSlides: 3,
                    maxSlides: 4,
                    slideWidth: 170,
                    slideMargin: 10
                });
            </script>
@endsection
