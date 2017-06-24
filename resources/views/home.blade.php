@extends('layouts.common')

@section('head')
<link rel="stylesheet" href="css/home.css" type="text/css">
@endsection('head')

@section('content')
  <div class="row dashboard-info-node-container">
    <div class="col-sm-12 col-md-3 dashboard-info-node">
      <p class="dashboard-info-node-header">You have...</p>
      <p class="dashboard-info-node-focus"><span class="dashboard-info-node-value">{{ $daysRemaining }}</span></p>
      <p class="dashboard-info-node-footnote">days holiday remaining this {{ $periodName }}</p>
    </div>
    <div class="col-sm-12 col-md-3 dashboard-info-node">
      <p class="dashboard-info-node-header">You have used...</p>
      <p class="dashboard-info-node-focus"><span class="dashboard-info-node-value">{{ $daysUsed }}</span></p>
      <p class="dashboard-info-node-footnote">days this {{ $periodName }}</p>
    </div>
    <div class="col-sm-12 col-md-3 dashboard-info-node">
      @if($nextHoliday)
        <p class="dashboard-info-node-header">Your next holiday starts on...</p>
        <p class="dashboard-info-node-focus"><span class="dashboard-info-node-value">{{ $nextHoliday -> starts -> format('d/m/Y') }}</span></p>
        <p class="dashboard-info-node-footnote">for {{ $nextHoliday -> days }} days</p>
      @else
        <p class="dashboard-info-node-footnote">You do not have any approved upcoming holidays</p>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">Date Requested</div>
    <div class="col-md-2">Start Date</div>
    <div class="col-md-2">End Date</div>
    <div class="col-md-2">Days</div>
    <div class="col-md-2">Status</div>
  </div>
  @foreach($expenditures as $expenditure)
    <div class="row">
      <div class="col-md-2">{{ $expenditure -> created_at -> format('d/m/Y H:i') }}</div>
      <div class="col-md-2">{{ $expenditure -> starts -> format('d/m/Y') }}</div>
      <div class="col-md-2">{{ $expenditure -> ends -> format('d/m/Y') }}</div>
      <div class="col-md-2">{{ $expenditure -> days }}</div>
      <div class="col-md-2">{{ $expenditure -> getStatusCodeName() }}</div>
    </div>
  @endforeach
@endsection('content')
