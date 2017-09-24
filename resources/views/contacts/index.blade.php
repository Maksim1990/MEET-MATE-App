@extends('layouts.admin')
@section('General')
    <h1>All contacts</h1>
    <div class="table-responsive">

        @if(!empty($contacts))
            @foreach($contacts as $contact)

                <div class="w3-row post_item">

                        <div class="w3-col m12 l12 ">
                            <img style="border-radius: 20px;object-fit: cover;" width="200" height="200"  src="{{$contact->photo ? $path.$contact->photo->path :$path."/images/noimage.png"}}" alt="">
                            <a href="{{ URL::to('contact_list/' . $contact->id ) }}">
                            <span class="w3-xlarge w3-text-red">{{$contact->name}}</span>
                              </a>
                        </div>
                    </div>

                <hr/>
            @endforeach
        @else
            <h2>No contacts have been created! </h2>
        @endif


    </div>


@endsection
@section ('scripts')
    <script>
        @if(Session::has('contact_change'))
                new Noty({
            type: 'success',
            layout: 'bottomLeft',
            text: '{{session('contact_change')}}'
        }).show();
        @endif
    </script>
@endsection