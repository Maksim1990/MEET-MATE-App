@extends('layouts.admin')
@section ('scripts_header')
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<style>
    .body_about{
             
                color: black;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                text-align: center;
            }
</style>
@endsection
@section('General')
    
    <div class="body_about">
      <h1 style="font-size: 45px;">CONTACTS</h1><br><br>
               <p style="font-size: 25px;font-weight:300;"><strong>Email : </strong> narushevich.maksim@gmail.com</p>
               <p style="font-size: 25px;font-weight:300;"><strong>Mobile : </strong> +375(33) 627-20-17</p>
               <p style="font-size: 25px;font-weight:300;"><strong>Meet Mate App account : </strong> <a href="{{URL::to('users/32 ')}}">Maksim Narushevich</a></p>
               <p style="font-size: 25px;font-weight:300;"><strong>LinkedIn account : </strong> <a href="{{URL::to('https://www.linkedin.com/in/maksim-narushevich-b99783106/ ')}}">Maksim Narushevich</a></p>
               <p style="font-size: 25px;font-weight:300;"><strong>LINE Messenger ID: </strong>maksimklim</p>
               <p style="font-size: 25px;font-weight:300;"><strong>Skype ID: </strong>maksimn901</p>
               <p style="font-size: 25px;font-weight:300;"><strong>VK account: </strong> <a href="{{URL::to('https://vk.com/maksim_naruschevich ')}}">Maksim Narushevich</a></p>
               <p style="font-size: 25px;font-weight:300;"><strong>Facebook account: </strong> <a href="{{URL::to('https://www.facebook.com/Maksim1990 ')}}">Maksim Narushevich</a></p>
                <p style="font-size: 25px;font-weight:300;"><strong>GitHub account: </strong> <a href="{{URL::to('https://github.com/Maksim1990 ')}}">Maksim1990</a></p>
   </div>
@endsection