@extends('layouts.admin')
@section ('styles')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.css" rel="stylesheet">
@endsection
@section ('General')
    <div>
        <p>Upload photo</p>

        {!! Form::open(['method'=>'POST','action'=>'AdminPhotoController@store', 'class'=>'dropzone'])!!}

        {{ Form::hidden('user_id', Auth::id() ) }}
        {!! Form::close() !!}
    </div>
    @include('includes.formErrors')
@stop
@section ('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.js"></script>
@endsection