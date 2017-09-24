@extends('layouts.admin')
@section ('General')
    <div class="col-xs-10 col-sm-10">
        <div>
    @if(!$images)
        <h2>Still no images here</h2>
    @else
    @foreach($images as $image)

     <a data-toggle="modal"  data-target="#image_{{$user->id}}_{{$image->photo->id}}">
        <img style="border-radius: 20px;" height="200" width="200" src="{{$image->photo ? $path.$image->photo->path :$path."/images/noimage.png"}}" alt="">
     </a>

     <div class="modal fade" id="image_{{$user->id}}_{{$image->photo->id}}" role="dialog" >
          <div class="modal-dialog">
               <div class="modal-content" style=" width:550px;   height: 550px;">
                      <div class="modal-body">
                         <img style="border-radius: 20px;" class="img-responsive" src="{{$image->photo ? $path.$image->photo->path :$path."/images/noimage.png"}}" alt="">
                          @if($user->id==Auth::id())
                          <button class="delete_mage btn btn-danger" data-photo-id="{{$image->photo->id}}" style="position: absolute;bottom: -10%;left:0;" >Delete image</button>
                            @endif
                      </div>
               </div>
          </div>
     </div>
    @endforeach
    @endif
        </div>
        @if($images)
        <div class="w3-center">
            {!! $images->links() !!}
        </div>
        @endif
    </div>
    <div class="col-xs-2 col-sm-2">
        @if($user->id==Auth::id())
        <a href="{{URL::to('media/create ')}}" style="font-size:15px">
            <i  data-container="body" data-placement="bottom" data-toggle="tooltip" title="Edit profile" class="fa fa-plus-circle" ></i>
            Add new image
        </a>
            @endif
    </div>
    <script>
        var token='{{\Illuminate\Support\Facades\Session::token()}}';
        var url_delete_user_image ='{{ URL::to('delete_user_image') }}';
        var user_id='{{ $user->id }}';
    </script>
@stop
@section ('scripts')
    <script src="{{asset('js/ajax-functions.js')}}"></script>
@endsection