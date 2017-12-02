@extends('layouts.admin')
@section ('General')
    <div>
        <p >Create Community</p>

        {!! Form::open(['method'=>'POST','action'=>'CommunityController@store', 'files'=>true])!!}
        <div class="group-form">
            {!! Form::label('name','Category name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>
        {{ Form::hidden('user_id', Auth::id(), array('id' => 'created_user_id')) }}
        <div class="group-form">
            {!! Form::label('type_id','Type:') !!}
            {!! Form::select('type_id', [""=>"Choose type"]+$type,null, ['class'=>'form-control','id'=>'chooseType']) !!}
        </div>
        <div class="group-form" id="chooseCategory" style="font-weight:bold;">

        </div>
        <div class="group-form">
            {!! Form::label('description','Description:') !!}
            {!! Form::textarea('description', null,['class'=>'form-control','required'=>'required']) !!}
         </div>
            <div class="group-form">
                {!! Form::label('photo_id','Community image:') !!}
                {!! Form::file('photo_id') !!}
            </div>
        <br>
        {!! Form::submit('Create community',['class'=>'btn btn-warning']) !!}

        {!! Form::close() !!}
    </div>
    @include('includes.formErrors')
@stop
@section('scripts')
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
    <script>
        @if(Session::has('community_change'))
                new Noty({
            type: 'error',
            layout: 'bottomLeft',
            text: '{{session('community_change')}}'

        }).show();
        @endif
    </script>
@endsection