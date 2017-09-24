     <footer id="footer">
         <div class="w3-row ">
             <div class="w3-col s6 m6  w3-center"><ul class="w3-ul">
                     <li class="w3-hover-green"><a href="{{URL::to('about_us ')}}">About</a></li>
                     <li class="w3-hover-green">Future updates</li>
                     <li class="w3-hover-green"><a href="{{URL::to('terms ')}}">Terms & Conditions</a></li>
                 </ul></div>
             <div class="w3-col s6 m6  w3-center">
                 <ul class="w3-ul">
                     <li class="w3-hover-green"><a href="{{URL::to('contact_us ')}}">Contact Us</a></li>
                     <li class="w3-hover-green">Support</li>
                     <li class="w3-hover-green"><a href="{{URL::to('privacy ')}}">Privacy policy</a></li>
                 </ul>
             </div>
         </div>
         <div class="w3-row">
             <div class="w3-col s1 m1"><p></p></div>
             <div class="w3-col s10 m10  w3-center"><p>2017 &#169; Developed by <a href="{{URL::to('users/32 ')}}">
                         Maksim Narushevich</a></p>
                 <div class="row " style="font-size: 45px;">
                     <a class="btn btn-social-icon btn-vkontakte  wobble-vertical" href="https://vk.com/maksim_naruschevich"><i class="fa fa-vk "></i></a>
                     <a class="btn btn-social-icon btn-facebook  wobble-vertical" href="https://www.facebook.com/Maksim1990"><i class="fa fa-facebook"></i></a>
                     <a class="btn btn-social-icon btn-linkedin  wobble-vertical" href="https://www.linkedin.com/in/maksim-narushevich-b99783106/"><i class="fa fa-linkedin"></i></a>
                     <a class="btn btn-social-icon btn-twitter  wobble-vertical" href="https://twitter.com/maksklim"><i class="fa fa-twitter"></i></a>
                     <a class="btn btn-social-icon btn-instagram  wobble-vertical" href="https://www.instagram.com/maksim_kl/?hl=en"><i class="fa fa-instagram"></i></a>
                     <a class="btn btn-social-icon  wobble-vertical" href="mailto:narushevich.maksim@gmail.com"><i class="fa fa-envelope-o"></i></a>

                 </div>
             </div>

         </div>
         <div class="w3-col s1 m1"><p></p></div>
    </footer>

     <div id="posts_all" class="hide" style="width:3000px;">
           <p> <a href="{{URL::to('posts ')}}">All Posts</a></p>
         <p> <a href="{{URL::to('posts/create ')}}">Create Post</a></p>
     </div>
     <div id="users" class="hide" style="width:3000px;">
         <p> <a href="{{URL::to('users/'.Auth::user()->id)}}" >My profile</a></p>
         <p>  <a href="{{URL::to('users ')}}" >All Users</a></p>
         @if(Auth::user()->role_id=="1")
         <p>   <a href="{{URL::to('users/create ')}}">Create User</a></p>
          @endif
     </div>
     <div id="categories" class="hide" style="width:3000px;">
         <p>  <a href="{{URL::to('categories ')}}">All Categories</a></p>
     </div>
     <div id="logged_user" class="hide" style="width:3000px;">
         <p><a data-userid="{{Auth::user()->id}}" href="{{ URL::to('users/' . Auth::user()->id ) }}">My profile</a>
         </p>
         <p><a  href="{{ URL::to('wall/' . Auth::user()->id ) }}">My wall</a></p>
         <p><a  href="{{ URL::to('friends/' . Auth::user()->id ) }}">My friends</a></p>
         <p>  <a href="{{ route('logout') }}"onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout</a></p>
</div>
     @if(isset($emojiFlags))
     <div id="emojiFlag" class="hide" style="width:3000px;">
         @foreach($emojiFlags as $dir)
             <img width="30" src="{{$path}}/images/emoji/flag/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/flag/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiSport))
     <div id="emojiSport" class="hide" style="width:3000px;">
         @foreach($emojiSport as $dir)
             <img width="30" src="{{$path}}/images/emoji/sport/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/sport/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiAnimals))
     <div id="emojiAnimals" class="hide" style="width:3000px;">
         @foreach($emojiAnimals as $dir)
             <img width="30" src="{{$path}}/images/emoji/animals/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/animals/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiClassic))
     <div id="emojiClassic" class="hide" style="width:3000px;">
         @foreach($emojiClassic as $dir)
             <img width="30" src="{{$path}}/images/emoji/classic/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/classic/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiClothes))
     <div id="emojiClothes" class="hide" style="width:3000px;">
         @foreach($emojiClothes as $dir)
             <img width="30" src="{{$path}}/images/emoji/clothes/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/clothes/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiEmojis))
     <div id="emojiEmojis" class="hide" style="width:3000px;">
         @foreach($emojiEmojis as $dir)
             <img width="30" src="{{$path}}/images/emoji/emojis/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/emojis/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiFood))
     <div id="emojiFood" class="hide" style="width:3000px;">
         @foreach($emojiFood as $dir)
             <img width="30" src="{{$path}}/images/emoji/food/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/food/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiHolidays))
     <div id="emojiHolidays" class="hide" style="width:3000px;">
         @foreach($emojiHolidays as $dir)
             <img width="30" src="{{$path}}/images/emoji/holidays/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/holidays/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiOther))
     <div id="emojiOther" class="hide" style="width:3000px;">
         @foreach($emojiOther as $dir)
             <img width="30" src="{{$path}}/images/emoji/other/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/other/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiRest))
     <div id="emojiRest" class="hide" style="width:3000px;">
         @foreach($emojiRest as $dir)
             <img width="30" src="{{$path}}/images/emoji/rest/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/rest/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiTravel))
     <div id="emojiTravel" class="hide" style="width:3000px;">
         @foreach($emojiTravel as $dir)
             <img width="30" src="{{$path}}/images/emoji/travel/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/travel/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     @if(isset($emojiWeather))
     <div id="emojiWeather" class="hide" style="width:3000px;">
         @foreach($emojiWeather as $dir)
             <img width="30" src="{{$path}}/images/emoji/weather/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/weather/{{$dir}}')" alt="" />
         @endforeach
     </div>
     @endif
     <script>
         function emojiDir(emoji) {
             var emojiPathImage="<img width='30' src="+emoji+"  alt='' />";
             $('#postInput,#text').val(function(_, val){return val + emojiPathImage; });
         }
     </script>
     <script>
         $(document).ready(function(){
             
             var wrapper = $('#loggedName img'); // cache the wrapper element for speed
            $(document).click(function(e) { // when any click is received
                if (
                (wrapper[0] != e.target) && // the target element is not the wrapper
                 (!wrapper.has(e.target).length) // and the wrapper does not contain the target element
                 ) {
                  wrapper.css('border-color','transparent');
                  statusImageBorder=true;
                }
            });
             
             
             var statusImageBorder=true;
             $('#loggedName img').css('border-width','3px');
             $('#loggedName img').css('border-style','solid');
             $('#loggedName img').css('border-color','transparent');
             $('#loggedName').click(function(){
                 if(statusImageBorder){
                     $('#loggedName img').css('border-color','orange');
                     statusImageBorder=false;

                 }else{
                     $('#loggedName img').css('border-color','transparent');
                     statusImageBorder=true;
                 }


             });
         });
     </script>
     <script>
         //Check current notifications
         $(document).ready(function () {
             var token='{{\Illuminate\Support\Facades\Session::token()}}';
             var url_check='{{ URL::to('check_notices') }}';
             $.ajax({
                 method:'POST',
                 url:url_check,
                 data:{_token:token},
                 success: function(data) {
                     $('#notification_number').text(data['quantity']);
                 }
             });
         });
//Register time about last time online
         $(document).ready(function(){
             var token='{{\Illuminate\Support\Facades\Session::token()}}';
             var user_id='{{Auth::id()}}';
             var url_online='{{ URL::to('register_online') }}';
             $.ajax({
                 method:'POST',
                 url:url_online,
                 data:{user_id:user_id,_token:token},
                 success: function(data) {
//                     console.log('Success');
                 }
             });
         });
     </script>
     <script src="{{asset('js/popover-custom.js')}}"></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57add4a572776064"></script>