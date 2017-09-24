@extends('layouts.admin')
@section('General')
    <h2>COUNTRY MODULE</h2>
    <div class="w3-col m6 l6">
    <div class="w3-col m12 l12">
        <div class="group-form w3-col m6 l6">
            {!! Form::label('country_name','Find country by name:') !!}
            {!! Form::text('country_name', null, ['class'=>'form-control','placeholder'=>'Example: Belarus,Thailand ...']) !!}
        </div>
        <div class="group-form w3-col m6 l6" style="padding-top: 30px;padding-left: 20px;">
         <input type="submit" class="btn-success" id="find_name" value="FIND" onclick="return getData('country_name','{{ URL::to('country_name') }}');">
    </div>
    </div>

    <div class="w3-col m12 l12">
        <div class="group-form w3-col m6 l6">
            {!! Form::label('country_capital','Find country by capital:') !!}
            {!! Form::text('country_capital', null, ['class'=>'form-control','placeholder'=>'Example: Minsk,Bangkok ...']) !!}
        </div>
        <div class="group-form w3-col m6 l6" style="padding-top: 30px;padding-left: 20px;">
            <input type="submit" class="btn-success" id="find_capital" value="FIND" onclick="return getData('country_capital','{{ URL::to('country_capital') }}');">
        </div>
    </div>

        <div class="w3-col m12 l12">
            <div class="group-form w3-col m6 l6">
                {!! Form::label('country_currency','Find country by currency:') !!}
                {!! Form::text('country_currency', null, ['class'=>'form-control','placeholder'=>'Example: BYR,THB ...']) !!}
            </div>
            <div class="group-form w3-col m6 l6" style="padding-top: 30px;padding-left: 20px;">
                <input type="submit" class="btn-success" id="find_currency" value="FIND" onclick="return getData('country_currency','{{ URL::to('country_currency') }}');">
            </div>
        </div>


        <div class="w3-col m12 l12">
            <div class="group-form w3-col m6 l6">
                {!! Form::label('country_code','Find country by code:') !!}
                {!! Form::text('country_code', null, ['class'=>'form-control','placeholder'=>'Example: BLR,THA ...']) !!}
            </div>
            <div class="group-form w3-col m6 l6" style="padding-top: 30px;padding-left: 20px;">
                <input type="submit" class="btn-success" id="find_code" value="FIND" onclick="return getData('country_code','{{ URL::to('country_code') }}');">
            </div>
        </div>
    </div>

    <div class="w3-col m6 l6">
        <div id="result_country" class="w3-xxlarge w3-padding-16 w3-center"></div>
    </div>
@endsection
@section('scripts')
    <script>
        function getData(item_name,url) {
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';
            var url = url;
            var value = $('#' + item_name).val();
            $('#' + item_name).html('');
            $('#result_country').html('');
            if(value!=''){
            $('<span>').html('<img id="load_image"  src="{{$path}}/images/includes/loading.gif"></span>').appendTo('#result_country');
            $.ajax({
                method: 'POST',
                url: url,
                data: {item_name: value, _token: token},
                success: function (data) {
                    $('#load_image').remove();
//                    var response = data['result'];
//                    console.log(response);
                    if ((data['result']['status'] !== 400) && (data['result']['status'] !== 404)) {
                        var country_name = data['result'][0]['name'];
                        var country_name_native = data['result'][0]['nativeName'];
                        var country_capital = data['result'][0]['capital'];
                        var country_population = data['result'][0]['population'];
                        var country_area = data['result'][0]['area'];
                        var country_region = data['result'][0]['region'];
                        var country_subregion = data['result'][0]['subregion'];
                        var country_currency = data['result'][0]['currencies'][0];
                        var country_phone_code = data['result'][0]['callingCodes'];
                        var country_domain_code = data['result'][0]['topLevelDomain'][0];
                        var country_alpha2 = data['result'][0]['alpha2Code'];
                        var country_alpha3 = data['result'][0]['alpha3Code'];
                        if (data['result'][0]['borders'] != '') {
                            var arrayBorders = data['result'][0]['borders'];
                            for (var i = 0; i < arrayBorders.length; i++) {
                                if (i == 0) {
                                    var strBorders = arrayBorders[i];
                                } else {
                                    strBorders += ",<br>" + arrayBorders[i];
                                }
                            }
                        }
                        else {
                            var strBorders = '<p style="font-size: 18px;margin-top: 20px;">No borders with other countries</p>';
                        }
                        var country_timezone = data['result'][0]['timezones'][0];

                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Name:</h3></div><div class='w3-col m8 l8' ><p>" + country_name + "</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Native name:</h3></div><div class='w3-col m8 l8' ><p>" + country_name_native + "</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Capital:</h3></div><div class='w3-col m8 l8' ><p>" + country_capital + "</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Population:</h3></div><div class='w3-col m8 l8' ><p>" + country_population + " persons</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Area:</h3></div><div class='w3-col m8 l8' ><p>" + country_area + " km2</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Region:</h3></div><div class='w3-col m8 l8' ><p>" + country_region + "</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Subregion:</h3></div><div class='w3-col m8 l8' ><p>" + country_subregion + "</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Currency code:</h3></div><div class='w3-col m8 l8' ><p>" + country_currency + "</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Phone code:</h3></div><div class='w3-col m8 l8' ><p>+" + country_phone_code + "</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Domain zone:</h3></div><div class='w3-col m8 l8' ><p>" + country_domain_code + "</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>ISO Codes:</h3></div><div class='w3-col m8 l8' ><p>ALPHA-2:" + country_alpha2 + "<br>ALPHA-3:" + country_alpha3 + "</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item" >').html("<div class='w3-col m4 l4' ><h3>Timezone:</h3></div><div class='w3-col m8 l8' ><p>" + country_timezone + "</p></div></div>").appendTo('#result_country');
                        $('<div class="w3-col m12 l12 country_item last_country_item" >').html("<div class='w3-col m4 l4' ><h3>Borders:</h3></div><div class='w3-col m8 l8' ><p>" + strBorders + "</p></div></div>").appendTo('#result_country');
                    } else {
                        $('<div class="w3-col m12 l12 country_item" >').html("Ooop! <br><span style='font-size: 18px;margin-top: 20px;'>Unfortunately,no data was found<br> Please try again!</span></div>").appendTo('#result_country');
                    }
                }
            });
        }
        }
    </script>
@endsection
