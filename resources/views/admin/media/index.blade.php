@extends('layouts.admin')
@section('General')
    @if(Session::has('photo_change'))
        <p class="alert alert-success">{{session('photo_change')}}</p>
    @endif
    <h1>All photos</h1>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Photo</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
            </thead>
            <tbody>
           
            @if($photos)
                @foreach($photos as $photo)
                    <tr>
                        <td>{{$photo->id}}</td>
                        <td><img style="border-radius: 20px;" height="40" src="{{$photo ? $path.$photo->path :$path."/images/noimage.png"}}" alt=""></td>
                        <td>{{$photo->created_at? $photo->created_at->diffForHumans(): "No date"}}</td>
                        <td>{{$photo->updated_at ? $photo->updated_at->diffForHumans():"No date"}}</td>
                        <td>
                             @if( Auth::user()->role_id=='1')
                            {{ Form::open(['method' =>'DELETE' , 'action' => ['AdminPhotoController@destroy',$photo->id]])}}

                            {!! Form::submit('Delete',['class'=>'btn-danger']) !!}

                            {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="w3-center">
{!! $photos->links() !!}
  </div>
    </div>
@endsection


