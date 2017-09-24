@extends('layouts.admin')
@section('General')
    <div class="col-xs-10 col-sm-10 tab_main_body" >

            @if(count($jobs)>0)
            <h1>All job offers</h1>
            <div class="table-responsive" id="job_block">
                @foreach($jobs as $job)

                <div class="w3-row post_item">
                    <div class="w3-col m4 l4 ">
                        <img style="width:200px;margin-bottom: 20px;" src="{{$job->image->photo ? $path.$job->image->photo->path :$path."/images/noimage.png"}}" alt="">
                    </div>
                    <div class="w3-col m4 l4 " style="padding: 10px 0 0 20px;">
                        <div class="w3-col m12 l12 ">
                       <a href="{{ URL::to('jobs/' . $job->id ) }}">{{$job->title}}</a>
                        <span class="w3-xlarge w3-text-red">{{$job->salary}}</span>
                        </div>
                        <div class="w3-col m12 l12 ">
                            <p>{{$job->description}}</p>
                        </div>
                    </div>
                    <div class="w3-col m4 l4 ">
                      <span class="w3-large"> Created at:</span>  {{$job->created_at}}<br/>
                        <span class="w3-large"> Active till: </span> {{$job->active_till}}<br/>
                        <span class="w3-large">Company: </span> {{$job->company_name}}
                    </div>


                    </div>
                <hr/>
                @endforeach
            </div>
        @else
            <div class="w3-center">
                <p style='margin-top:150px;font-size:55px;color:gray;'>No jobs have been created yet</p><br>
                <img style="border-radius:70px;" width="300" src="{{$path."/images/includes/nothing2.png"}}" alt="">
            </div>

        @endif

                <div class="w3-center">{!! $jobs->links() !!}</div>
    </div>

    <div class="col-xs-2 col-sm-2 w3-center">
        <h3>SEARCH</h3>

        {{ Form::hidden('user_id', Auth::id(), array('id' => 'created_user_id')) }}

        <div class="group-form">
            {!! Form::label('title','Search by title:') !!}
            {!! Form::text('title', null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('company_name','Search by company name:') !!}
            {!! Form::text('company_name', null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('type_id','Type:') !!}
            {!! Form::select('type_id', [""=>"Choose type"]+$type,null, ['class'=>'form-control','id'=>'chooseType']) !!}
        </div>
        <div class="group-form" id="chooseCategory" style="font-weight:bold;"></div>
        <div class="group-form">
            {!! Form::label('description','Search by description:') !!}
            {!! Form::text('description', null, ['class'=>'form-control']) !!}
        </div>
        <br>
        {!! Form::submit('Search job',['class'=>'btn btn-warning','id'=>'search']) !!}
        <p><br><hr><a href="{{ URL::to('jobs/create' ) }}"  class="btn btn-success">New job</a></p>
    </div>

@endsection
@section ('scripts')
    <script>
        @if(Session::has('job_change'))
                new Noty({
            type: 'success',
            layout: 'bottomLeft',
            text: '{{session('job_change')}}'
        }).show();
        @endif
    </script>
    <script>
        $(document).ready(function () {
            var token='{{\Illuminate\Support\Facades\Session::token()}}';
            $('#chooseType').on('change', function() {
                var url='{{ URL::to('get_category_list') }}';
                var type=$(this).val();
                $.ajax({
                    method:'POST',
                    url:url,
                    data:{type:type,_token:token},
                    success: function(data) {
                        var response = data['categories'];
                        console.log(response);
                        var chooseCategory = document.getElementById("chooseCategory");
                        while (chooseCategory.firstChild) {
                            chooseCategory.removeChild(chooseCategory.firstChild);
                        }
                        chooseCategory.append("Category:");
                        //Create array of options to be added

                        //Create and append select list
                        var selectList = document.createElement("select");
                        selectList.setAttribute("id", "category_id");
                        selectList.setAttribute("name", "category_id");
                        selectList.setAttribute("class", "form-control");
                        selectList.style.fontWeight = "normal";
                        chooseCategory.appendChild(selectList);

                        //Create and append the options
                        for (var i = 0; i < response.length; i++) {
                            var option = document.createElement("option");
                            option.setAttribute("value", response[i]['id']);
                            option.text = response[i]['name'];
                            selectList.appendChild(option);
                        }
                    }
                });
            });
        });


        $("#search").click(function(e) {
            var type_id=$('select[name=type_id]').val();
            var category_id=$('select[name=category_id]').val();
            var title=$('input[name=title]').val();
            var company_name=$('input[name=company_name]').val();
            var description=$('input[name=description]').val();

            var url_search='{{ URL::to('job_search') }}';
            $.ajax({
                method:'POST',
                url:url_search,
                data:{category_id:category_id,type_id:type_id,company_name:company_name,description:description,title:title,_token:token},
                success: function(data) {
                    console.log(data['data']);
                    $('#job_block').html('');
                    if(data['data'].length>0){
                    for(var i=0;i<data['data'].length;i++){

                        if(data['data'][i]['image']!=null){
                            var photo_image='{{$path}}'+data['data'][i]['image']['photo']['path'];
                            var image_block="<img style='width:200px;margin-bottom: 20px;' src='"+photo_image+"' >";
                        }else{
                            var photo_image='{{$path}}'+'/images/noimage.png';
                            var image_block="<img style='width:200px;margin-bottom: 20px;' src='"+photo_image+"' >";
                        }
                        var job_id=data['data'][i]['id'];
                        var title=data['data'][i]['title'];
                        var salary=data['data'][i]['salary'];
                        var description=data['data'][i]['description'];
                        var active_till=data['data'][i]['active_till'];
                        var company_name=data['data'][i]['company_name'];
                        var job_created_at=data['data'][i]['created_at'];
                        var result="<div class='w3-col m4 l4'>"+image_block+"</div><div class='w3-col m4 l4' style='padding: 10px 0 0 20px;'><div class='w3-col m12 l12'><a href='{{$path}}jobs/"+job_id+"'>"+title+"</a><span class='w3-xlarge w3-text-red'>"+salary+"</span></div><div class='w3-col m12 l12'><p>"+description+"</p></div></div><div class='w3-col m4 l4'><span class='w3-large'> Created at:</span>"+job_created_at+"<br/><span class='w3-large'> Active till: </span>"+active_till+"<br/><span class='w3-large'>Company: </span>"+company_name+"</div>";
                        $("<div class='w3-row post_item'>").html(result+"</div><hr/>").appendTo('#job_block');
                    }
                    }else{
                $("<div class='w3-row post_item'>").html("<h4>No results found"+"</h4></div><hr/>").appendTo('#job_block');
            }
                }
            });

        });
    </script>
@endsection