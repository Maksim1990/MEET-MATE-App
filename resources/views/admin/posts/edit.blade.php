@extends('layouts.admin')
@section ('General')
    <div>
        <p >Edit Post</p>

        {!! Form::model($post,['method'=>'PATCH','action'=>['AdminPostsController@update',$post->id], 'files'=>true])!!}
        <div class="group-form">
            {!! Form::label('title','Title:') !!}
            {!! Form::text('title', null, ['class'=>'form-control']) !!}
        </div>

        <div class="group-form">
            {!! Form::label('category_id','Category:') !!}
            {!! Form::select('category_id',$category ,null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('photo_id','Photo:') !!}
            {!! Form::file('photo_id') !!}
        </div>

        <div class="group-form">
            {!! Form::label('body','Body:') !!}
            <a id="noticeBlockShow" style="color:red;font-weight:bold;">Notice!</a>
        <span id="noticeBlock">Pasting content in textarea below and following symbols ( $ , < , >) are prohibited!</span>
            {{ Form::textarea('body', null, ['class'=>'form-control','id'=>'postInput', 'onkeypress'=>'return isNumberKey(event);','onpaste'=>'return isNumberKey(event);']) }}
        </div>

        {!! Form::submit('Update Post',['class'=>'btn btn-warning']) !!}
        <div style="display: inline-block;">
            <a id="emojiBlockShow" style="font-size: 18px;">@emojione(':smile:') </a>
        <span id="emojiBlock" class="w3-right">
         <p  data-placement="top" data-container="body" data-toggle="emojiClassic" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':slight_smile:')</p>
        <p  data-placement="top" data-container="body" data-toggle="emojiFlag" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':triangular_flag_on_post:')</p>
        <p  data-placement="top" data-container="body" data-toggle="emojiSport" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':person_bouncing_ball:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiAnimals" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':bear:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiClothes" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':shirt:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiEmojis" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':boy:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiFood" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':hamburger:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiHolidays" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':tada:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiOther" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':copyright:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiRest" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':carousel_horse:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiTravel" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':island:')</p>
         <p  data-placement="top" data-container="body" data-toggle="emojiWeather" data-placement="left" data-html="true" href="#" class="w3-left emoji_div">@emojione(':white_sun_small_cloud:')</p>
        </span>
        </div>
        {!! Form::close() !!}
        {{ Form::open(['method' =>'DELETE' , 'action' => ['AdminPostsController@destroy',$post->id]])}}

        {!! Form::submit('Delete User',['class'=>'btn btn-danger']) !!}
       
        {!! Form::close() !!}
    </div>

    @include('includes.formErrors')
@stop
@section('scripts')
	<script>
        	window.onload = function() {
            var myInput = document.getElementById('postInput');
            myInput.onpaste = function(e) {
            e.preventDefault();
                 }
            }
		function isNumberKey(evt)
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			console.log(charCode);
			if (charCode == 36 || charCode == 60 || charCode == 62)
				return false;
			return true;
		}
	</script>
    <script>
        $(document).ready(function () {
            var blnStatus=false;
        $('#emojiBlockShow').on('click', function() {
            if(blnStatus){
                $('#emojiBlockShow').html('@emojione(':smile:')');
                blnStatus=false;
            }else{
                $('#emojiBlockShow').html('@emojione(':x:')');
                blnStatus=true;
            }

            $('#emojiBlock').toggle();
            });
        });

        $('#noticeBlockShow').on('click', function() {
    if ($('#noticeBlock').css('opacity') == 0) $('#noticeBlock').css('opacity', 1);
    else $('#noticeBlock').css('opacity', 0);
            });
    </script>


@endsection
