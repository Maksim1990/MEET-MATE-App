@extends('layouts.admin')
@section('General')
 <div class="col-xs-10 col-sm-10 tab_main_body" id="community_block">
     @if(count($communities)>0)
         @foreach($communities as $community)
             <div class="w3-row post_item">
                 <div class="w3-col m4 l4 w3-center">
                    <img style="border-radius:20px;width:90%;"  src="{{$community->photo?$path.$community->photo->path:$path."/images/noimage.png"}}" alt="">
                 </div>
                 <div class="w3-col m8 l8">
                 <div class="w3-col m8 l8">
                     <p><h3><a href="{{ URL::to('community/' . $community->id ) }}" style="font-size:15px">{{$community->name}}</a></h3></p>
                     <p>{{$community->description}}<br>
                        Type: {{$community->type->name}}<br>
                        Category: {{$community->category->name}}</p>
                     Created by <a href="{{ URL::to('users/' . $community->user->id) }}">{{$community->user ? $community->user->name : "No owner"}}</a>
                 </div>
                     <div class="w3-col m4 l4">
                         <p style='margin-top: 20px;'>Created {{$community->created_at->diffForHumans()}}<br>
                         @if($community->user->id==Auth::id())
                             <a href="{{ URL::to('community/' . $community->id . '/edit') }}">Edit</a>
                         @endif
                         </p>
                     </div>
                 </div>
             </div>
         @endforeach
     @else
         <div class="w3-center">
             <p style='margin-top:150px;font-size:55px;color:gray;'>There is no any communities yet</p><br>
             <img style="border-radius:70px;" width="300" src="{{$path."/images/includes/nothing2.png"}}" alt="">
         </div>

     @endif
</div>

 <div class="col-xs-2 col-sm-2 w3-center">
     <h3>SEARCH</h3>

     {{ Form::hidden('user_id', Auth::id(), array('id' => 'created_user_id')) }}
     <div class="group-form">
         {!! Form::label('type_id','Type:') !!}
         {!! Form::select('type_id', [""=>"Choose type"]+$type,null, ['class'=>'form-control','id'=>'chooseType']) !!}
     </div>
     <div class="group-form" id="chooseCategory" style="font-weight:bold;"></div>
     <div class="group-form">
         {!! Form::label('community_name','Search by name:') !!}
         {!! Form::text('community_name', null, ['class'=>'form-control']) !!}
     </div>
     <div class="group-form">
         {!! Form::label('community_description','Search by description:') !!}
         {!! Form::text('community_description', null, ['class'=>'form-control']) !!}
     </div>
     <br>
     {!! Form::submit('Search community',['class'=>'btn btn-warning','id'=>'search']) !!}
     <p><br><hr><a href="{{ URL::to('community/create' ) }}"  class="btn btn-success">New community</a></p>
 </div>
@endsection
@section ('Users')
    <h1>Users who created communities</h1>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>User name</th>
                <th>Community</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
            </thead>
            <tbody>
            @if($communities)
                @foreach($communities as $community)
                    <tr>
                        <td>
                            <a href="{{ URL::to('users/' . $community->user->id ) }}">
                            <img style="border-radius: 20px;" height="40" src="{{$community->user->photo ? $path.$community->user->photo->path :$path."/images/noimage.png"}}" alt=""></td>
                        </a>
                        <td><a href="{{ URL::to('community/' . $community->id ) }}">{{$community->name}}</a></td>
                        <td>{{$community->created_at->diffForHumans()}}</td>
                        <td>{{$community->updated_at->diffForHumans()}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
@section ('Statistics')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
            </thead>
            <tbody>
            @if($communities)
                @foreach($communities as $community)
                    <tr>
                        <td>{{$community->id}}</td>
                        <td><a href="{{ URL::to('community/' . $community->id ) }}">{{$community->name}}</a></td>
                        <td>{{$community->created_at->diffForHumans()}}</td>
                        <td>{{$community->updated_at->diffForHumans()}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
@section ('scripts')
    <script>
        @if(Session::has('community_change'))
                new Noty({
            type: 'success',
            layout: 'bottomLeft',
            text: '{{session('community_change')}}'

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
            var community_name=$('input[name=community_name]').val();
            var community_description=$('input[name=community_description]').val();
            var url_search='{{ URL::to('community_search') }}';
            $.ajax({
                method:'POST',
                url:url_search,
                data:{category_id:category_id,type_id:type_id,community_name:community_name,community_description:community_description,_token:token},
                success: function(data) {
                    console.log(data['data']);
                    $('#community_block').html('');
                     if(data['data'].length>0){
                    for(var i=0;i<data['data'].length;i++){

                        if(data['data'][i]['photo']!=null){
                            var photo_image='{{$path}}'+data['data'][i]['photo']['path'];
                            var image_block="<p class='post_image'><img style='border-radius:20px;width:90%;' src='"+photo_image+"' ></p>";
                        }else{
                            var image_block="<p class='no-image'>No image</p>";
                        }
                        var community_id=data['data'][i]['id'];
                        var community_name=data['data'][i]['name'];
                        var community_description=data['data'][i]['description'];
                        var community_type=data['data'][i]['type']['name'];
                        var community_category=data['data'][i]['category']['name'];
                        var community_user_id=data['data'][i]['user_id'];
                        var community_user_name=data['data'][i]['user']['name'];
                        if(community_user_name!=""){
                            user_name=community_user_name;
                        }else{
                            user_name="No owner";
                        }
                        var community_created_at=data['data'][i]['created_at'];
                    var result="<div class='w3-col m4 l4 w3-center'>"+image_block+"</div><div class='w3-col m8 l8'><div class='w3-col m8 l8'><p><h3><a href='{{$path}}community/"+community_id+"' style='font-size:15px'>"+community_name+"</a></h3></p><p>"+community_description+"<br>Type:"+community_type+"<br>Category:"+community_category+"</p>Created by <a href='{{$path}}users/"+community_user_id+"'>"+user_name+"</a></div><div class='w3-col m4 l4'> <p style='margin-top: 20px;'>Created "+community_created_at+"<br><a href='{{$path}}community/"+community_id+"/edit'>Edit</a></p></div></div>";
                        $("<div class='w3-row post_item'>").html(result+"</div>").appendTo('#community_block');
                    }
                         
                     }else{
                $("<div class='w3-row post_item'>").html("<h4>No results found"+"</h4></div><hr/>").appendTo('#community_block');
            }

                }
            });

        });
    </script>
@endsection
