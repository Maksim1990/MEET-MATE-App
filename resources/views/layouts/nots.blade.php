@extends('layouts.admin')
@section ('General')
    <div>
        <h2>Notifications</h2>
        <div class="w3-col m12 l12">
            <div>
<ul>
        @foreach($nots as $not)
        <li>{{$not->data['name']}}&nbsp;{{$not->data['message']}}
        <span class="pull-right">{{$not->created_at}} </span>
        </li>
        @endforeach
</ul>
            </div>
        </div>
    </div>

@stop
@section ('scripts')

@endsection