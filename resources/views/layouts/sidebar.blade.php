<div class="leftside col-xs-10 col-sm-5 w3-sidebar w3-bar-block w3-card-2 w3-animate-left" style="display:inline-block;" id="Sidebar">
    <button class="w3-bar-item w3-button w3-large"
            onclick="w3_close()">Hide sidebar &times;</button>
    <div class="navbar-default sidebar">
        <div class="sidebar-nav">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <i class="fa fa-users"></i> Users<span class="fa arrow"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <ul class="nav nav-second-level">
                                <li>

                                    <a href="{{URL::to('users/'.Auth::user()->id)}}" >My profile</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('users ')}}" >All Users</a>
                                </li>
                                 <li>
                                    <a href="{{URL::to('friends/'.Auth::user()->id)}}" >Friends</a>
                                </li>
                                @if(Auth::user()->role_id=="1")
                                <li>
                                    <a href="{{URL::to('users/create ')}}">Create User</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" >
                                <i class="fa fa-bookmark"></i> Posts<span class="fa arrow"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{URL::to('posts ')}}">All Posts</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('posts/create ')}}">Create Post</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" >
                                <i class="fa fa-list"></i> Categories<span class="fa arrow"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{URL::to('categories ')}}">All Categories</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" >
                        <h4 class="panel-title">
                            <a href="{{URL::to('blog ')}}" >
                                <i class="fa fa-book"></i> Blog</span>
                            </a>
                        </h4>
                    </div>

                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" >
                        <h4 class="panel-title">
                            <a href="{{URL::to('chat ')}}" >
                                <i class="fa fa-comments"></i> Messages</span>
                            </a>
                        </h4>
                    </div>

                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" >
                                <i class="fa fa-picture-o"></i> Media<span class="fa arrow"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{URL::to('media ')}}">All Media</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('media/create ')}}">Create Media</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" >
                        <h4 class="panel-title">
                            <a href="{{URL::to('articles ')}}" >
                                <i class="fa fa-newspaper-o"></i> Articles</span>
                            </a>
                        </h4>
                    </div>

                </div>
                <div class="w3-center " style="position:absolute;bottom:15%;left:5%;">
                    <span >Version 1.1.0</span>
                </div>
                
            </div>
        </div>
    </div>
</div>