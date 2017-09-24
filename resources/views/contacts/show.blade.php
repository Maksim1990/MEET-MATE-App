@extends('layouts.admin')
@section ('scripts_header')

@endsection
@section ('General')
    <div class="col-xs-3 col-sm-3 w3-center">
        <img style="border-radius: 20px;" width="220" src="{{$contact->photo ? $path.$contact->photo->path :$path."/images/noimage.png"}}" alt="">
    </div>
    <div class="col-xs-7 col-sm-7">

        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                First name:
            </div>
            <div class="col-xs-10 col-sm-8">
                @if(!empty($contact->name))
                {{$contact->name}}
                @endif
            </div>
        </div>

        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Last name:
            </div>
            <div class="col-xs-10 col-sm-8">
                @if(!empty($contact->lastname))
                    {{$contact->lastname}}
                @endif
            </div>
        </div>

        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Birthday:
            </div>
            <div class="col-xs-10 col-sm-8">
                @if(!empty($contact->birthday))
                    {{$contact->birthday}}
                @endif
            </div>
        </div>

        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Country:
            </div>
            <div class="col-xs-10 col-sm-8">
                @if(!empty($country))
                    {{$country}}
                @endif
            </div>
        </div>

        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                City:
            </div>
            <div class="col-xs-10 col-sm-8">
                @if(!empty($contact->city))
                    {{$contact->city}}
                @endif
            </div>
        </div>

        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Company:
            </div>
            <div class="col-xs-10 col-sm-8">
                @if(!empty($contact->company))
                    {{$contact->company}}
                @endif
            </div>
        </div>

        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Email:
            </div>
            <div class="col-xs-10 col-sm-8">
                @if(!empty($contact->email))
                    {{$contact->email}}
                @endif
            </div>
        </div>

        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Second email:
            </div>
            <div class="col-xs-10 col-sm-8">
                @if(!empty($contact->email2))
                    {{$contact->email2}}
                @endif
            </div>
        </div>

        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Phone:
            </div>
            <div class="col-xs-10 col-sm-8">
                @if(!empty($contact->phone))
                    {{$contact->phone}}
                @endif
            </div>
        </div>

        <div class="w3-raw w3-padding-16">
            <div class="col-xs-10 col-sm-4 w3-large">
                Second phone:
            </div>
            <div class="col-xs-10 col-sm-8">
                @if(!empty($contact->phon2))
                    {{$contact->phone2}}
                @endif
            </div>
        </div>

    </div>
    <div class="col-xs-10 col-sm-2 w3-center">
        @if($contact->user_id==Auth::id())
            <a href="{{ URL::to('contact_list/' . $contact->id . '/edit') }}" class="btn btn-small btn-success">Edit this contact</a>
        @endif
        <a href="{{ URL::to('contact_list/create') }}" class="btn btn-small btn-warning">Create new contact</a>
    </div>

@stop
