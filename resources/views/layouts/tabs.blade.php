    <div class="mainside col-xs-7 col-sm-11" id="mainside" >
        
        <div class="container-fluid maintabs">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs" role="tablist">

                    @foreach($arrTabs as $title)

    <li role="presentation" class="{{$title=="General" || $title=="Dashboard" ? $active : ""}}" ><a href="#{{$title}}" aria-controls="{{$title}}" role="tab" data-toggle="tab">{{$title}}</a></li>
        @endforeach
                    </ul>
  <div class="tab-content">
      @foreach($arrTabs as $title)

      <div role="tabpanel" class="tab-pane {{$title=="General" || $title=="Dashboard"? $active : ""}}" id="{{$title}}"> @yield($title)</div>
      @endforeach
  </div>        
                </div>
            </div>
        </div>
    </div>
