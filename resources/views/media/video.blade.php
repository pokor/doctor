<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
<form method="post" enctype="multipart/form-data" action="{{route('videos')}}">
    {{csrf_field()}}
    <ul class="list_btn">
       <input type="file" name="myPicture" multiple="multiple" >
    </ul>
    <button type="submit">上传</button>
</form>
</body>
</html>