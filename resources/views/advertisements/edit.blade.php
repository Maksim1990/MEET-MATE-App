@extends('layouts.admin')
@section ('scripts_header')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@endsection
@section ('General')
    <div class="col-xs-10 col-sm-10">
        <p>Update advertisement</p>

        {{ Form::model($adds, ['method' =>'PATCH' , 'action' => ['AdvertisementController@update',$adds->id],'files'=>true])}}
        <div class="group-form">
            {!! Form::label('title','Title:') !!}
            {!! Form::text('title', null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('type_id','Type:') !!}
            {!! Form::select('type_id',$types,null, ['class'=>'form-control','id'=>'chooseType']) !!}
        </div>
        <div class="group-form" id="chooseCategory" style="font-weight:bold;">

        </div>
        <div class="group-form">
            {!! Form::label('photo_id','Photo:') !!}
            {!! Form::file('photo_id') !!}
        </div>
        <div class="group-form">
            {!! Form::label('description','Description:') !!}
            {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('show_to_friends','Show advertisement to friends:') !!}
            {{ Form::checkbox('show_to_friends','Y',null, ['class' => 'field']) }}
        </div>
        <div class="group-form">
            {!! Form::label('active','Active:') !!}
            {{ Form::checkbox('active','Y',null, ['class' => 'field','id'=>'add_active']) }}
        </div>
        <div class="group-form">
            {!! Form::label('active_till','Active till:') !!}
            {!!  Form::text('active_till', null, array('id' => 'datepicker')) !!}
        </div>
        <br/><br/>
        {!! Form::submit('Update advertisement',['class'=>'btn btn-warning']) !!}

        {!! Form::close() !!}
    </div>
    <br/>
    {{ Form::open(['method' =>'DELETE' , 'action' => ['AdvertisementController@update',$adds->id]])}}

    {!! Form::submit('Delete advertisement',['class'=>'btn btn-danger']) !!}

    {!! Form::close() !!}
    {{--@include('includes.formErrors')--}}
@stop
@section('scripts')
    <script>
        @if(Session::has('add_change'))
                new Noty({
            type: 'error',
            layout: 'bottomLeft',
            text: '{{session('add_change')}}'

        }).show();
        @endif
    </script>
    <script>
        $(document).ready(function () {
            $('#chooseType').on('change', function() {
                var token='{{\Illuminate\Support\Facades\Session::token()}}';
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
    </script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

    <script>
        $(function() {
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                yearRange: '1950:2035',
                defaultDate: '2017',
                changeYear: true
            });
        });
    </script>
@endsection