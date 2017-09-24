@extends('layouts.admin')
@section ('General')
    <div>
        <p >Edit community</p>
        {!! Form::model($community,['method'=>'PATCH','action'=>['CommunityController@update',$community->id], 'files'=>true])!!}
        <div class="group-form">
            {!! Form::label('name','Community name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>
        {{ Form::hidden('user_id', Auth::id(), array('id' => 'created_user_id')) }}

        <div class="group-form">
            {!! Form::label('category_id','Community category:') !!}
            {!! Form::select('category_id',$category ,null, ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('type_id','Community type:') !!}
            {!! Form::select('type_id',$type ,null, ['class'=>'form-control']) !!}
        </div>

        <div class="group-form">
            {!! Form::label('photo_id','Photo:') !!}
            {!! Form::file('photo_id') !!}
        </div>

        <div class="group-form">
            {!! Form::label('description','Description:') !!}
            {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
        </div>

        {!! Form::submit('Update community',['class'=>'btn btn-warning']) !!}

        {!! Form::close() !!}
        {{ Form::open(['method' =>'DELETE' , 'action' => ['CommunityController@destroy',$community->id]])}}

        {!! Form::submit('Delete community',['class'=>'btn btn-danger']) !!}

        {!! Form::close() !!}
    </div>
    @include('includes.formErrors')
@stop
@section ('scripts')
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