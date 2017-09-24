
<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>

</head>
<body>
@foreach($gifts as $dir)
    <img width="200" src="{{$path}}/images/gifts/{{$dir}}" onclick="emojiDir('{{$path}}/images/gifts/{{$dir}}')" alt="" />
@endforeach

</body>
</html>