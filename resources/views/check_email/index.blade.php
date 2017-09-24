@extends('layouts.admin')
@section('General')
    <h2>CHECK EMAIL MODULE</h2>

    <div class="w3-col m6 l6">
            <div class="group-form w3-col m6 l6">
                {!! Form::label('check_email','Enter email for checking:') !!}
                {!! Form::text('check_email', null, ['class'=>'form-control']) !!}
            </div>
            <div class="group-form w3-col m6 l6" style="padding-top: 30px;padding-left: 20px;">
                {!! Form::submit('CHECK',['class'=>'btn-success','id'=>'check_email_button']) !!}
            </div>
    </div>

    <div class="w3-col m6 l6">
            <div id="result_check_email" class="w3-xxlarge w3-padding-16 w3-center"></div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#check_email_button').on('click', function() {
                var token='{{\Illuminate\Support\Facades\Session::token()}}';
                var url='{{ URL::to('check_email_get') }}';
                var check_email=$('#check_email').val();
                $('#result_check_email').html('');
                $('<span>').html('<img id="load_image"  src="/images/includes/loading.gif"></span>').appendTo('#result_check_email');
                $.ajax({
                    method:'POST',
                    url:url,
                    data:{check_email:check_email,_token:token},
                    success: function(data) {
                        $('#load_image').remove();
                        var response = data['result'];
                        console.log(response);


if(response){
    $('<p>').html('<img id="load_image"  src="{{$path}}/images/includes/true.png"></p>').appendTo('#result_check_email');
    $('<p>').html('This is valid email</p>').appendTo('#result_check_email');
}else{
    $('<p>').html('<img id="load_image"  src="{{$path}}/images/includes/false.png"></p>').appendTo('#result_check_email');
    $('<p style="color:red;">').html('Sorry, you typed invalid email.<br>Please try one again!</p>').appendTo('#result_check_email');
}



                    }

                });
            });
        });
    </script>
@endsection