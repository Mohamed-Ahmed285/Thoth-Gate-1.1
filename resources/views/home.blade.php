<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
</head>
<body>

@if(\Illuminate\Support\Facades\Auth::guest())
    <h1>this is guest</h1>
@else
    <h1>Welcome {{\Illuminate\Support\Facades\Auth::user()->name}}</h1>
@endif

</body>
</html>
