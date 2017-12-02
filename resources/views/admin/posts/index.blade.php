@extends('layouts.admin')
@section('General')
    <h1>All posts</h1>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Owner</th>
                <th>Category</th>
                <th>Photo</th>
                <th>Title</th>
                <th>Body</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if($posts)
                @foreach($posts as $post)
                    <tr>
                        <td>{{$post->id}}</td>
                        <td><a href="{{ URL::to('users/' . $post->user->id . '/edit') }}">{{$post->user ? $post->user->name : "No owner"}}</a></td>
                        <td>{{$post->category ? $post->category->name: "Uncategorized"}}</td>
                        <td><img style="border-radius: 20px;" height="40" src="{{$post->photo ? $path.$post->photo->path :$path."/images/noimage.png"}}" alt=""></td>
                        <td><a href="{{ URL::to('posts/' . $post->id . '/edit') }}">{{$post->title}}</a></td>
                        <td>{!!$post->body!!}</td>
                        <td>{{$post->created_at->diffForHumans()}}</td>
                        <td>{{$post->updated_at->diffForHumans()}}</td>
                        <td>
                           <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div>
                            
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>


@endsection
 @section ('scripts')
     <script>
        @if(Session::has('post_change'))
        new Noty({
    type: 'warning',
    layout: 'topRight',
    text: '{{session('post_change')}}'

}).show();
        @endif
    </script>
@endsection
