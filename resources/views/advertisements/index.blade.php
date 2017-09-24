@extends('layouts.admin')
@section('General')
    <div class="col-xs-10 col-sm-10 tab_main_body" >

            @if(count($adds)>0)
            <h1>All advertisements</h1>
            <div class="table-responsive" id="advertisement_block">

            @foreach($adds as $advertisement)
                <div class="w3-row post_item">

                    <div class="w3-col m4 l4 ">
                        <img style="width:200px;margin-bottom: 20px;" src="{{$advertisement->image->photo ? $path.$advertisement->image->photo->path :$path."/images/noimage.png"}}" alt="">
                        </div>
                    <div class="w3-col m7 l7" style="padding: 10px 0 0 20px;">
                        <div class="w3-col m12 l12 ">
                            <h3><a href="{{ URL::to('advertisement/' . $advertisement->id ) }}">{{$advertisement->title}}</a></h3>
                        </div>
                        <div class="w3-col m12 l12 ">
                            <p>{{$advertisement->description}}</p>
                        </div>

                        <span class="w3-large"> Created at:</span>  {{$advertisement->created_at}}<br/>
                        <span class="w3-large"> Active till: </span> {{$advertisement->active_till}}<br/>
                    </div>


                </div>
                <hr/>
                @endforeach
            </div>
        @else
                <div class="w3-center">
                    <p style='margin-top:150px;font-size:55px;color:gray;'>There is no have any advertisement yet</p><br>
                    <img style="border-radius:70px;" width="300" src="{{$path."/images/includes/nothing2.png"}}" alt="">
                </div>

        @endif
                <div class="w3-center">{!! $adds->links() !!}</div>


    </div>
    <div class="col-xs-2 col-sm-2 w3-center">
        <h3>SEARCH</h3>

        {{ Form::hidden('user_id', Auth::id(), array('id' => 'created_user_id')) }}
        <div class="group-form">
            {!! Form::label('title','Search by title:') !!}
            {!! Form::text('title', null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('description','Search by description:') !!}
            {!! Form::text('description', null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('type_id','Type:') !!}
            {!! Form::select('type_id', [""=>"Choose type"]+$type,null, ['class'=>'form-control','id'=>'chooseType']) !!}
        </div>
        <div class="group-form" id="chooseCategory" style="font-weight:bold;"></div>
        <br>
        {!! Form::submit('Search community',['class'=>'btn btn-warning','id'=>'search']) !!}
       <p><br><hr><a href="{{ URL::to('advertisement/create' ) }}"  class="btn btn-success">New advertisement</a></p>
    </div>

@endsection
@section ('scripts')
<script>
    @if(Session::has('add_change'))
            new Noty({
        type: 'success',
        layout: 'bottomLeft',
        text: '{{session('add_change')}}'
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
        var description=$('input[name=description]').val();

        var url_search='{{ URL::to('advertisement_search') }}';
        $.ajax({
            method:'POST',
            url:url_search,
            data:{category_id:category_id,type_id:type_id,description:description,title:title,_token:token},
            success: function(data) {
                console.log(data['data']);
                $('#advertisement_block').html('');
                if(data['data'].length>0){
                for(var i=0;i<data['data'].length;i++){
                    if(data['data'][i]['image']!=null){
                        var photo_image='{{$path}}'+data['data'][i]['image']['photo']['path'];
                        var image_block="<img style='width:200px;margin-bottom: 20px;' src='"+photo_image+"' >";
                    }else{
                        var photo_image='{{$path}}'+'/images/noimage.png';
                        var image_block="<img style='width:200px;margin-bottom: 20px;' src='"+photo_image+"' >";
                    }
                    var advertisement_id=data['data'][i]['id'];
                    var title=data['data'][i]['title'];
                    var description=data['data'][i]['description'];
                    var active_till=data['data'][i]['active_till'];
                    var add_created_at=data['data'][i]['created_at'];
                    var result="<div class='w3-col m4 l4'>"+image_block+"</div><div class='w3-col m7 l7' style='padding: 10px 0 0 20px;'><div class='w3-col m12 l12'><h3><a href='{{$path}}advertisement/"+advertisement_id+"'>"+title+"</a></h3></div><div class='w3-col m12 l12'><p>"+description+"</p></div><span class='w3-large'> Created at:</span>"+add_created_at+"<br/><span class='w3-large'> Active till: </span>"+active_till+"<br/></div>";
                    $("<div class='w3-row post_item'>").html(result+"</div><hr/>").appendTo('#advertisement_block');
                }
            }else{
                $("<div class='w3-row post_item'>").html("<h4>No results found"+"</h4></div><hr/>").appendTo('#advertisement_block');
            }
            }
        });

    });
</script>

</script>
@endsection