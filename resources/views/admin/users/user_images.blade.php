<div class="user-image w3-center">

    <h3><a href="{{URL::to('image/'.$user->id)}}" >All images</a></h3>
    @if(!$images)
        <p>Still no images here</p>
    @else
    @foreach($images as $image)

            <a data-toggle="modal" data-target="#image_{{$user->id}}_{{$image->id}}">
        <img height="100" width="100"  src="{{$image->photo ? $path.$image->photo->path :$path."/images/noimage.png"}}" alt="">
           </a>

            <div class="modal fade" id="image_{{$user->id}}_{{$image->id}}" role="dialog" >
                <div class="modal-dialog">
                    <div class="modal-content" style=" width:550px;   height: 550px;">

                        <div class="modal-body">
                            <img style="border-radius: 20px;" class="img-responsive" src="{{$image->photo ? $path.$image->photo->path :$path."/images/noimage.png"}}" alt="">
                        </div>

                    </div>

                </div>
            </div>
    @endforeach
@endif

</div>