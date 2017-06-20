@extends('layouts.common')

@section('head')
<link rel="stylesheet" href="css/home.css" type="text/css">
@endsection('head')

@section('content')
  <h1>Welcome {{ $userName }}</h1>
  <h3>
    <small>You have:</small>
    <span class="label label-quinary">{{ $holidayDaysRemaining }}</span>
    <small>holiday days remaining.</small>
  </h3>
@endsection('content')
