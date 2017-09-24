@extends('layouts.admin')

@section ('General')

    <div class="col-sm-6">
        {{ Form::model($user, ['method' =>'PATCH' , 'action' => ['AdminUserController@updatePassword',$user->id],'files'=>true])}}
        <div class="group-form">
            {!! Form::label('password','Old password:') !!}
            {!! Form::password('old_password', ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('password','New password:') !!}
            {!! Form::password('password', ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('password','Repeat new password:') !!}
            {!! Form::password('password_2', ['class'=>'form-control']) !!}
        </div><br>
        {!! Form::submit('Update password',['class'=>'btn btn-warning']) !!}
        {!! Form::close() !!}

        @include('includes.formErrors')
    </div>

@stop

@section ('scripts')
    <script>
        @if(Session::has('user_change'))
                new Noty({
            type: 'error',
            layout: 'bottomLeft',
            text: '{{session('user_change')}}'

        }).show();
        @endif
    </script>
@endsection