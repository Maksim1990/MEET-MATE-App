@extends('layouts.admin')
@section ('scripts_header')

@endsection
@section ('General')
    <div>
        <p >Edit contact</p>
        {{--<div class="col-sm-3">--}}
            {{--<img height="200"  src="{{$user->photo ? $path.$user->photo->path :$path."/images/noimage.png"}}" class="image-responsive" alt="">--}}
        {{--</div>--}}
        <div class="col-sm-9">
            {{ Form::model($contact, ['method' =>'PATCH' , 'action' => ['ContactController@update',$contact->id],'files'=>true])}}
            <div class="group-form">
                {!! Form::label('name','Contact name:') !!}
                {!! Form::text('name', null, ['class'=>'form-control']) !!}
            </div>

            <div class="group-form">
                {!! Form::label('country','Country:') !!}
                {!! Form::select('country',$countries ,null, ['class'=>'form-control']) !!}
            </div>

            <div class="group-form">
                {!! Form::label('email','Contact email:') !!}
                {!! Form::email('email', null, ['class'=>'form-control']) !!}
            </div>
            <div class="group-form">
                {!! Form::label('email2','Contact second email:') !!}
                {!! Form::email('email2', null, ['class'=>'form-control']) !!}
            </div>

            <div class="group-form">
                {!! Form::label('photo_id','Photo:') !!}
                {!! Form::file('photo_id') !!}
            </div>


            {!! Form::submit('Update contact') !!}

            {!! Form::close() !!}
            {{ Form::open(['method' =>'DELETE' , 'action' => ['ContactController@destroy',$contact->id]])}}

            {!! Form::submit('Delete contact') !!}

            {!! Form::close() !!}
            @include('includes.formErrors')
        </div>

    </div>

@stop