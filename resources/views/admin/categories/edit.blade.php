@extends('layouts.admin')
@section ('General')
    <div>
        <p>Create Post</p>

        {!! Form::model($category,['method'=>'PATCH','action'=>['AdminCategoryController@update',$category->id], 'files'=>true])!!}
        <div class="group-form">
            {!! Form::label('name','Name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>

        {!! Form::submit('Update category') !!}

        {!! Form::close() !!}
        {{ Form::open(['method' =>'DELETE' , 'action' => ['AdminCategoryController@destroy',$category->id]])}}

        {!! Form::submit('Delete category') !!}

        {!! Form::close() !!}
    </div>
    @include('includes.formErrors')
@stop
