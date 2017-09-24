@extends('layouts.admin')
@section ('General')
<div>
        <p>Create User</p>

            {!! Form::open(['method'=>'POST','action'=>'AdminUserController@store', 'files'=>true])!!}
            <div class="group-form">
                {!! Form::label('name','User name:') !!}
                {!! Form::text('name', null, ['class'=>'form-control']) !!}
            </div>
            <div class="group-form">
                {!! Form::label('email','User email:') !!}
                {!! Form::email('email', null, ['class'=>'form-control']) !!}
            </div>
            <div class="group-form">
                {!! Form::label('role_id','Role:') !!}
                {!! Form::select('role_id', [""=>"Choose Option"]+$roles,null, ['class'=>'form-control']) !!}
            </div>
    <div class="group-form">
        {!! Form::label('photo_id','Photo:') !!}
        {!! Form::file('photo_id') !!}
    </div>
            <div class="group-form">
                {!! Form::label('is_active','Status:') !!}
                {!! Form::select('is_active',[1=>"Active",0=>"Not Active"],0, ['class'=>'form-control']) !!}
            </div>
    <div class="group-form">
        {!! Form::label('password','Password:') !!}
        {!! Form::password('password', ['class'=>'form-control']) !!}
    </div>
            {!! Form::submit('Create User') !!}

        {!! Form::close() !!}
</div>
@include('includes.formErrors')
@stop
