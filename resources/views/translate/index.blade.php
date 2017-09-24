

@extends('layouts.admin')
@section('General')
    <div class="w3-col m12 l12">
        <p></p>

        {!! Form::open(['method'=>'POST','action'=>'TranslateController@store'])!!}
        <div class="w3-col m6 l6">
        <div class="group-form">
            {!! Form::label('input_lang','Input language:') !!}
            {!! Form::select('input_lang', [""=>"Choose type",'en'=>'English','fr'=>'French','th'=>'Thai'],null, ['class'=>'form-control','id'=>'input_lang']) !!}

        </div>
        <div class="group-form">
          {!! Form::textarea('input_word', null, ['class'=>'form-control','id'=>'input_word']) !!}
        </div>
        </div>
        <div class="w3-col m6 l6">
            <div class="group-form">
                {!! Form::label('output_lang','Output language:') !!}
                {!! Form::select('output_lang', ["no"=>"Choose type",'en'=>'English','fr'=>'French','th'=>'Thai'],null, ['class'=>'form-control','id'=>'output_lang']) !!}

            </div>
            <div class="group-form">
                {!! Form::textarea('output_word', null, ['class'=>'form-control','id'=>'output_word']) !!}
            </div>
        </div>


        {!! Form::close() !!}
        {!! Form::submit('Translate',['class'=>'btn-success','id'=>'translate']) !!}
    </div>
    <div class="w3-col m12 l12">
        <h1>List of your previous translations</h1>
        <div class="table-responsive">

            <table class="table">
                <thead>
                <tr>
                    <th>Input word / Language</th>
                    <th>Output word / Language</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody id="lang_translation">
                @if(!empty($translates))
                    @foreach($translates as $translate)
                        <tr>
                            <td>{{$translate->input_word}} [{{$translate->input_lang}}]</td>
                            <td>{{$translate->output_word}} [{{$translate->output_lang}}]</td>
                            <td>{{$translate->created_at}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#translate').on('click', function() {
                var token='{{\Illuminate\Support\Facades\Session::token()}}';
                var url='{{ URL::to('translate_phrase') }}';
                var input_word=$('#input_word').val();
                var output_lang=$('#output_lang').val();
                var input_lang=$('#input_lang').val();

                $.ajax({
                    method:'POST',
                    url:url,
                    data:{input_word:input_word,output_lang:output_lang,input_lang:input_lang,_token:token},
                    success: function(data) {
                        var today = new Date();
                        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                        var dateTime = date+' '+time;
                        var response = data['result'];
                        $('#output_word').text(response);
                        var text='<td>'+input_word+'['+input_lang+']</td>'+'<td>'+response+'['+output_lang+']</td>'+'<td>'+dateTime+'</td>';
                        $('<tr>').html(text+'</tr>').prependTo('#lang_translation');
                    }

                });
            });
        });
    </script>
@endsection




