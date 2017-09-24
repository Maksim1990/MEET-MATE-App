@extends('layouts.admin')
@section('General')
    <h2>INSTAGRAM MODULE</h2>

        <div class="w3-col m12 l12">
            @if(empty($setting->instagram_accaunt))
            <div class="group-form w3-col m6 l6">
                {!! Form::label('instagram','Enter Instagram accaunt name:') !!}
                {!! Form::text('instagram', null, ['class'=>'form-control']) !!}
            </div>
            <div class="group-form w3-col m6 l6" style="padding-top: 30px;padding-left: 20px;">
                {!! Form::submit('SET',['class'=>'btn-success','id'=>'set_instagram']) !!}
            </div>
                @else
                <div class=" w3-col m12 l12" style="padding-top: 30px;padding-left: 20px;">
                <h4>The last 12 posts from {{$setting->instagram_accaunt}} Instagram accaunt</h4><hr>
                    </div>
            @endif
    </div>

    <div class="w3-col m12 l12">
        @if(empty($setting->instagram_accaunt))
        <div id="result_instagram" class="w3-xxlarge w3-padding-16 w3-center"></div>
        @else
            <div id="result_instagram" class="w3-xxlarge w3-padding-16 w3-center w3-col m12 l12">
            @if(!empty($response))
                @foreach($response as $post)
                    <div class="w3-col m4 l4" style="height:350px;padding: 5px 5px;">
                    <img style="width: 100%;height: 100%;object-fit:cover;border-radius: 20px;" src='{{$post->DisplayUrl}}' class="w3-hover-opacity">
                    </div>
                @endforeach
             @else
                <h2>Ooops!</h2>
                <h3>Unfortunately, no data was found</h3>
            @endif
            </div>
         @endif
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#set_instagram').on('click', function() {
                var token='{{\Illuminate\Support\Facades\Session::token()}}';
                var url='{{ URL::to('set_instagram') }}';
                var instagram=$('#instagram').val();
                $('#result_instagram').html('');
                $('<span>').html('<img id="load_image"  src="{{$path}}/images/includes/loading.gif"></span>').appendTo('#result_instagram');
                $.ajax({
                    method:'POST',
                    url:url,
                    data:{instagram:instagram,_token:token},
                    success: function(data) {
                        $('#load_image').remove();
                        var response = data['result'];
                        console.log(response);
                   }

                });
            });
        });
    </script>
@endsection
