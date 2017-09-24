@extends('layouts.admin')
@section ('scripts_header')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@endsection
@section ('General')
    <div>
        <p>Create job</p>

        {!! Form::open(['method'=>'POST','action'=>'JobOfferController@store', 'files'=>true])!!}
        <div class="group-form">
            {!! Form::label('title','Title:') !!}
            {!! Form::text('title', null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('company_name','Company name:') !!}
            {!! Form::text('company_name', null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('country','Country:') !!}
            {!! Form::select('country',[""=>"Choose country"]+$countries ,null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('city','City:') !!}
            {!! Form::text('city', null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('type_id','Type:') !!}
            {!! Form::select('type_id', [""=>"Choose type"]+$types,null, ['class'=>'form-control','id'=>'chooseType']) !!}
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
            {!! Form::label('salary','Salary:') !!}
            {!! Form::text('salary', null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('show_to_friends','Show advertisement to friends:') !!}
            {{ Form::checkbox('show_to_friends','Y',null, ['class' => 'field']) }}
        </div>
        <div class="group-form">
            {!! Form::label('active','Link this job to some your of advertisements:') !!}
            {{ Form::checkbox('active','Y',null, ['class' => 'field','id'=>'showAdds','onclick'=>'return validateAdds(event);']) }}
        </div>
        <div class="group-form parentDiv" >
            {!! Form::label('advertisement_id','Choose your advertisement:') !!}
            {!! Form::select('advertisement_id', [""=>"Choose type"]+$adds,null, ['class'=>'form-control','id'=>'chooseAdds']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('active','Active:') !!}
            {{ Form::checkbox('active','Y',null, ['class' => 'field','id'=>'add_active','onclick'=>'return validate(event);']) }}
        </div>
        <div class="group-form parentDiv">
            {!! Form::label('active_till','Active till:') !!}
            {!!  Form::text('active_till', null, array('id' => 'datepicker')) !!}
        </div>
        <br/><br/>
        {!! Form::submit('Create job',['class'=>'btn btn-warning']) !!}

        {!! Form::close() !!}
    </div>
    @include('includes.formErrors')
@stop
@section('scripts')
    <script>
        @if(Session::has('job_change'))
                new Noty({
            type: 'error',
            layout: 'bottomLeft',
            text: '{{session('job_change')}}'
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
    <script type="text/javascript">
        var show_adds= document.getElementById('chooseAdds').parentNode;
        function validateAdds() {
            if (document.getElementById('showAdds').checked) {
                show_adds.style.display='inline-block';
            } else {
               //   alert("You didn't check it! Let me check it for you.");
                show_adds.style.display='none';
            }
        }
    </script>
    <script type="text/javascript">
        var active_till= document.getElementById('datepicker').parentNode;
        function validate() {
            if (document.getElementById('add_active').checked) {
                // alert("checked");
                active_till.style.display='inline-block';
            } else {
                //  alert("You didn't check it! Let me check it for you.");
                active_till.style.display='none';
            }
        }
    </script>
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