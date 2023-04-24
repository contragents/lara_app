<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Queue status</title>
</head>
<body>
Queue status <br />
@foreach($data as $jobId => $jobStatus)
    Job ID: {{$jobId}} status: {{$jobStatus['status']}} <br />
@endforeach
</body>
</html>
