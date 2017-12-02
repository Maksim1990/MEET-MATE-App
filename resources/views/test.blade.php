<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>

@if(isset($emojiFlags))
<div id="emojiFlag" class="hide" style="width:3000px;">
    @foreach($emojiFlags as $dir)
        <img width="30" src="{{$path}}/images/emoji/flag/{{$dir}}" onclick="emojiDir('{{$path}}/images/emoji/flag/{{$dir}}')" alt="" />
    @endforeach
</div>
@endif
</body>
</html>