<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<h2>Add rate to your reservation!</h2>
@foreach($ratingLinks as $rating => $url)
    <a href="{{$url}}">Rate : {{$rating}}</a>
@endforeach

</body>
</html>
