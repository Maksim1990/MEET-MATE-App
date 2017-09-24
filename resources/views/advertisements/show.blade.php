@extends('layouts.admin')
@section ('scripts_header')
    <link href="{{asset('js/jquery.bxslider.css')}}" rel="stylesheet">
@endsection
@section ('General')

    <div class="col-xs-10 col-sm-10 tab_main_body ">

        <div class="col-xs-10 col-sm-12">
            <img style="width: 100%;margin-bottom: 20px;max-height:400px;object-fit: cover;" src="{{$add->image ? $path.$add->image->photo->path :$path."/images/includes/add.jpeg"}}" alt="">
        </div>

        <h2 class="w3-center"> {{$add->title}}</h2>
        <div class="col-xs-12 col-sm-12 " style="background-color: white;border-radius: 50px;">
        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Description:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$add->description}}
            </div>
        </div>


        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Created at:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$add->created_at}}
            </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Active till:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$add->active_till}}
            </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Advertisement type:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$add->type->name}}
            </div>
        </div>

        <div class="w3-raw w3-margin-bottom w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Advertisement category:
            </div>
            <div class="col-xs-10 col-sm-8">
                {{$add->category->name}}
            </div>
         </div>
        </div>

        <div class="w3-row w3-center" style="width: 100%;border-top:1px dashed gray;margin-top: 300px">
            <h3 ><a style="color:gray;;" href="{{ URL::to('advertisement/') }}">OTHER RECENT ADVERTISEMENTS</a></h3>
        </div>

        @if(count($adds)>0)
            <div class="w3-row w3-center" style="padding-left:15%;">
                <ul class="bxslider" >
                    @foreach($adds as $add)
                        <li>
                            <a href="{{ URL::to('advertisement/' . $add->id ) }}">
                                <img data-container="body" data-placement="bottom" data-toggle="tooltip" title="{{$add->title}}" src="{{$add->image ? $path.$add->image->photo->path :$path."/images/noimage.png"}}" />
                            </a>
                        </li>
                    @endforeach
                </ul>
                @else
                    <div class="w3-row w3-center" style="width: 90%">
                        <h6>There are no available advertisements now</h6>
                        @endif
                    </div>

    </div>
    <div class="col-xs-10 col-sm-2 w3-center">
        @if($add->user_id==Auth::id())
            <a href="{{ URL::to('advertisement/' . $add->id . '/edit') }}" class="btn btn-small btn-success">Edit this advertisement</a>
        @endif
        <a href="{{ URL::to('advertisement/create') }}" class="btn btn-small btn-warning">Create new advertisement</a>
    </div>

@stop
@section ('scripts')
            <script src="{{asset('js/jquery.bxslider.js')}}" type="text/javascript"></script>
            <script>
                $('.bxslider').bxSlider({
                    minSlides: 3,
                    maxSlides: 4,
                    slideWidth: 170,
                    slideMargin: 10
                });
            </script>
@endsection
