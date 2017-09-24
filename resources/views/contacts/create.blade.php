@extends('layouts.admin')
@section ('General')
    <div>
        <p>Create Contact</p>

        {!! Form::open(['method'=>'POST','action'=>'ContactController@store', 'files'=>true])!!}
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


        {!! Form::submit('Create contact') !!}

        {!! Form::close() !!}
    </div>
    @include('includes.formErrors')
@stop
