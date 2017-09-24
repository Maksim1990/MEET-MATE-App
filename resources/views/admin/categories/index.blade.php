

      @extends('layouts.admin')
      @section('General')
          <div class="w3-col m6 l6">
              <p>Create Post</p>

              {!! Form::open(['method'=>'POST','action'=>'AdminCategoryController@store'])!!}
              <div class="group-form">
                  {!! Form::label('type_id','Category type:') !!}
                  {!! Form::select('type_id', [""=>"Choose category"]+$types? $types :"",null, ['class'=>'form-control']) !!}
              </div>
              <div class="group-form">
                  {!! Form::label('name','Name:') !!}
                  {!! Form::text('name', null, ['class'=>'form-control']) !!}
              </div>

              {!! Form::submit('Create category',['class'=>'btn-success']) !!}

              {!! Form::close() !!}

          </div>
          <div class="w3-col m6 l6">
          <h1>All categories</h1>
          <div class="table-responsive">
              @if(Session::has('category_change'))
                  <p class="alert alert-success">{{session('category_change')}}</p>
              @endif
              <table class="table">
                  <thead>
                  <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if($categories)
                      @foreach($categories as $category)
                          <tr>
                              <td>{{$category->id}}</td>
                              <td><a href="{{ URL::to('admin/categories/' . $category->id . '/edit') }}">{{$category->name}}</a></td>
                              <td>{{$category->created_at ? $category->created_at->diffForHumans():"No date"}}</td>
                              <td>{{$category->updated_at ? $category->updated_at->diffForHumans():"No date"}}</td>
                          </tr>
                      @endforeach
                  @endif
                  </tbody>
              </table>
          </div>
          </div>
@endsection




