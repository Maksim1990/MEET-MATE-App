@extends('layouts.admin')
@section('General')

    <div class="w3-col m6 l6">
        <p>Create new type</p>

        {!! Form::open(['method'=>'POST','action'=>'CommunityTypeController@store'])!!}
        <div class="group-form">
            {!! Form::label('name','Name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>
        {{ Form::hidden('user_id', Auth::id(), array('id' => 'created_user_id')) }}
        {!! Form::submit('Create type',['class'=>'btn-success']) !!}

        {!! Form::close() !!}

    </div>
    <div class="w3-col m6 l6">
        <h1>All types</h1>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
            </tr>
            </thead>
            <tbody>
            @if($types)
                @foreach($types as $type)
                    <tr>
                        <td>{{$type->id}}</td>
                        <td><a href="{{ URL::to('type/' . $type->id . '/edit') }}">{{$type->name}}</a></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    </div>
@endsection
@section ('Statistics')
    <div class="w3-col m12 l12">
        <h1>All types</h1>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
                </thead>
                <tbody>
                @if($types)
                    @foreach($types as $type)
                        <tr>
                            <td>{{$type->id}}</td>
                            <td><a href="{{ URL::to('type/' . $type->id . '/edit') }}">{{$type->name}}</a></td>
                            <td>{{$type->created_at->diffForHumans()}}</td>
                            <td>{{$type->updated_at->diffForHumans()}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section ('scripts')
    <script>
        @if(Session::has('type_change'))
                new Noty({
            type: 'success',
            layout: 'bottomLeft',
            text: '{{session('type_change')}}'

        }).show();
        @endif
    </script>
@endsection
