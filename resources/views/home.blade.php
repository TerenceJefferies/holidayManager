@extends('layouts.common')

@section('head')
<link rel="stylesheet" href="css/home.css" type="text/css">
@endsection('head')

@section('content')
  <h1>Welcome {{ $userName }}</h1>
  <p>You have {{ $daysRemaining }} holiday days remaining</p>
@endsection('content')
