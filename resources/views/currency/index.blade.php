

@extends('layouts.admin')
@section('General')
    <h2>CURRENCY CONVERTER</h2>
    <div class="w3-col m6 l6">

        {!! Form::open(['method'=>'POST','action'=>'TranslateController@store'])!!}

            <div class="group-form">
                {!! Form::label('input_currency','Input currency:') !!}
                {!! Form::select('input_currency', [""=>"Choose currency",
             'USD'=>'USA Dollar $',
            'HKD'=>'HKD Hong Kong, dollar',
            'HUF'=>'HUF Hungary, forint',
            'IDR'=>'IDR Indonesia, rupiah',
            'IEP'=>'IEP Ireland, pund',
            'INR'=>'INR India, rupee',
            'ISK'=>'ISK Iceland, kronor',
            'JPY'=>'JPY Japan, yen',
            'KWN'=>'KRW South Korea, won',
            'KWD'=>'KWD Kuwait, dinar',
            'MAD'=>'MAD Morocco, dirham',
            'MXN'=>'MXN Mexico, nuevo peso',
            'MYR'=>'MYR Malaysia, ringgit',
            'NZD'=>'NZD New Zealand, dollar',
            'PLN'=>'PLN Poland, zloty',
            'RUB'=>'RUB Russia, rouble',
            'SAR'=>'SAR Saudi Arabia, riyal',
            'SGD'=>'SGD Singapore, dollar',
            'THB'=>'THB Thailand, baht',
            'ZAR'=>'ZAR South Africa, rand',
                ],null, ['class'=>'form-control','id'=>'input_currency','data-icon'=>"glyphicon glyphicon-eye-open"]) !!}

            </div>
            <div class="group-form">
                {!! Form::label('input_value','Value:') !!}
                {!! Form::text('input_value', null, ['class'=>'form-control','id'=>'input_value']) !!}
            </div>
        <div class="group-form">
            {!! Form::label('output_currency','To what currency convert:') !!}
            {!! Form::select('output_currency', [""=>"Choose currency",
            'USD'=>'USA Dollar $',
            'HKD'=>'HKD Hong Kong, dollar',
            'HUF'=>'HUF Hungary, forint',
            'IDR'=>'IDR Indonesia, rupiah',
            'IEP'=>'IEP Ireland, pund',
            'INR'=>'INR India, rupee',
            'ISK'=>'ISK Iceland, kronor',
            'JPY'=>'JPY Japan, yen',
            'KWN'=>'KRW South Korea, won',
            'KWD'=>'KWD Kuwait, dinar',
            'MAD'=>'MAD Morocco, dirham',
            'MXN'=>'MXN Mexico, nuevo peso',
            'MYR'=>'MYR Malaysia, ringgit',
            'NZD'=>'NZD New Zealand, dollar',
            'PLN'=>'PLN Poland, zloty',
            'RUB'=>'RUB Russia, rouble',
            'SAR'=>'SAR Saudi Arabia, riyal',
            'SGD'=>'SGD Singapore, dollar',
            'THB'=>'THB Thailand, baht',
            'ZAR'=>'ZAR South Africa, rand',
            ],null, ['class'=>'form-control','id'=>'output_currency']) !!}

        </div>



        {!! Form::close() !!}<br>
        {!! Form::submit('Convert',['class'=>'btn-success','id'=>'convert']) !!}
    </div>
    <div class="w3-col m6 l6">
    <p id="result_currency" class="w3-xxlarge w3-padding-16 w3-center"></p>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#convert').on('click', function() {
                var token='{{\Illuminate\Support\Facades\Session::token()}}';
                var url='{{ URL::to('convert_currency') }}';
                var input_currency=$('#input_currency').val();
                var input_value=$('#input_value').val();
                var output_currency=$('#output_currency').val();
                function currencyIcon(value) {
                    var icon;
                    switch (value) {
                        case 'USD':
                            icon = '@emojione(':flag_us:')';
                            return icon;
                            break;
                        case 'THB':
                            icon = '@emojione(':flag_th:')';
                            return icon;
                            break;
                        case 'HUF':
                            icon = '@emojione(':flag_hu:')';
                            return icon;
                            break;
                        case 'HKD':
                            icon = '@emojione(':flag_hk:')';
                            return icon;
                            break;
                        case 'IDR':
                            icon = '@emojione(':flag_id:')';
                            return icon;
                            break;
                        case 'IEP':
                            icon = '@emojione(':flag_ie:')';
                            return icon;
                            break;
                        case 'INR':
                            icon = '@emojione(':flag_in:')';
                            return icon;
                            break;
                        case 'ISK':
                            icon = '@emojione(':flag_is:')';
                            return icon;
                            break;
                        case 'JPY':
                            icon = '@emojione(':flag_jp:')';
                            return icon;
                            break;
                        case 'KRW':
                            icon = '@emojione(':flag_kr:')';
                            return icon;
                            break;
                        case 'KWD':
                            icon = '@emojione(':flag_kw:')';
                            return icon;
                            break;
                        case 'MAD':
                            icon = '@emojione(':flag_ma:')';
                            return icon;
                            break;
                        case 'MXN':
                            icon = '@emojione(':flag_mx:')';
                            return icon;
                            break;
                        case 'MYR':
                            icon = '@emojione(':flag_my:')';
                            return icon;
                            break;
                        case 'NZD':
                            icon = '@emojione(':flag_nz:')';
                            return icon;
                            break;
                        case 'PLN':
                            icon = '@emojione(':flag_pl:')';
                            return icon;
                            break;
                        case 'RUB':
                            icon = '@emojione(':flag_ru:')';
                            return icon;
                            break;
                        case 'SAR':
                            icon = '@emojione(':flag_sa:')';
                            return icon;
                            break;
                        case 'SGD':
                            icon = '@emojione(':flag_sg:')';
                            return icon;
                            break;
                        case 'ZAR':
                            icon = '@emojione(':flag_za:')';
                            return icon;
                            break;
                        default:
                            icon = '@emojione(':flag_white:')';
                            return icon;
                    }
                }
                var iconInputCurrency= currencyIcon(input_currency);
                var iconOutputCurrency= currencyIcon(output_currency);
                $('#result_currency').html('');
                $('<span>').html('<img id="load_image"  src="{{$path}}/images/includes/loading.gif"></span>').appendTo('#result_currency');
                $.ajax({
                    method:'POST',
                    url:url,
                    data:{output_currency:output_currency,input_currency:input_currency,input_value:input_value,_token:token},
                    success: function(data) {
                        $('#load_image').remove();
                            var response = data['result'];
                        $('#result_currency').html(iconInputCurrency+' '+input_value+' '+input_currency+'<br>=<br>'+iconOutputCurrency+' '+response+' '+output_currency);
                    }

                });
            });
        });
    </script>
@endsection

