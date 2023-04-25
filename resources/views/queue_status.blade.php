<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Queue status</title>
</head>
<body>
<a href="{{ \Illuminate\Support\Facades\URL::route('run_job', ['taskId' => 126], false) }}" target="_blank"> Run Job#1 </a>
&nbsp;
<a href="{{ \Illuminate\Support\Facades\URL::route('run_job', ['taskId' => 542], false) }}" target="_blank"> Run Job#2 </a>
&nbsp;
<a href="{{ \Illuminate\Support\Facades\URL::route('run_job', ['taskId' => 777], false) }}" target="_blank"> Run non-existing Job </a>
<br />
Queue status <br/>
@foreach($data as $jobId => $jobStatus)
    Job ID: {{$jobId}} status: {{$jobStatus['status']}} <br/>
@endforeach
</body>
</html>
