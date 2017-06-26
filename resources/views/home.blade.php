@extends('layouts.common')

@section('head')
<link rel="stylesheet" href="{{ URL::asset('css/home.css') }}" type="text/css">
@endsection('head')

@section('content')
  <div class="row dashboard-info-node-container">
    <div class="col-sm-12 col-md-3 dashboard-info-node">
      <p class="dashboard-info-node-header">You have...</p>
      <p class="dashboard-info-node-focus"><span class="dashboard-info-node-value">{{ $daysRemaining }}</span></p>
      <p class="dashboard-info-node-footnote">days remaining this {{ $periodName }}</p>
    </div>
    <div class="col-sm-12 col-md-4 col-md-offset-1 dashboard-info-node">
      @if($nextHoliday)
        <p class="dashboard-info-node-header">Your next holiday starts on...</p>
        <p class="dashboard-info-node-focus"><span class="dashboard-info-node-value">{{ $nextHoliday -> starts -> format('d/m/Y') }}</span></p>
        <p class="dashboard-info-node-footnote">for {{ $nextHoliday -> days }} days</p>
      @else
        <p class="dashboard-info-node-footnote">You do not have any approved upcoming holidays</p>
      @endif
    </div>
    <div class="col-sm-12 col-md-3 col-md-offset-1 dashboard-info-node">
      <p class="dashboard-info-node-header">You have used...</p>
      <p class="dashboard-info-node-focus"><span class="dashboard-info-node-value">{{ $daysUsed }}</span></p>
      <p class="dashboard-info-node-footnote">days this {{ $periodName }}</p>
    </div>
  </div>
  <div class="row dashboard-action-button-container">
    <a href="{{ route('allowance') }}"><div class="col-md-3">View my allowance</div></a>
    <a href="#"><div class="col-md-4 col-md-offset-1">Request a new holiday</div></a>
    <a href="{{ route('showAllowance', ['id' => $allowance -> id ]) }}"><div class="col-md-3 col-md-offset-1">My usage</div></a>
  </div>
  @if($expenditures -> count() > 0)
    <div class="dashboard-info-expenditures-container">
      <div class="row dashboard-info-expenditures-headers hidden-sm hidden-xs">
          <div class="col-md-2 col-md-offset-1">Date Requested</div>
          <div class="col-md-2">Start Date</div>
          <div class="col-md-2">End Date</div>
          <div class="col-md-2">Days</div>
          <div class="col-md-2">Status</div>
        </div>
        @foreach($expenditures -> take(5) as $expenditure)
          <div class="row dashboard-info-expenditures-list-container">
            <div class="col-xs-12 col-md-2 col-md-offset-1"><label class="hidden-md hidden-lg">Requested:</label> {{ $expenditure -> created_at -> format('d/m/Y H:i') }}</div>
            <div class="col-xs-12 col-md-2"><label class="hidden-md hidden-lg">Starts:</label> {{ $expenditure -> starts -> format('d/m/Y') }}</div>
            <div class="col-xs-12 col-md-2"><label class="hidden-md hidden-lg">Ends:</label> {{ $expenditure -> ends -> format('d/m/Y') }}</div>
            <div class="col-xs-12 col-md-2"><label class="hidden-md hidden-lg">Days:</label> {{ $expenditure -> days }}</div>
            @if($expenditure -> status == 'approved')
              <div class="col-xs-12 col-md-2 bg-success">
                {{ $expenditure -> getStatusCodeName() }}
              </div>
            @endif
            @if($expenditure -> status == 'pending')
              <div class="col-xs-12 col-md-2 bg-warning">
                {{ $expenditure -> getStatusCodeName() }}
              </div>
            @endif
            @if($expenditure -> status == 'rejected')
              <div class="col-xs-12 col-md-2 bg-danger">
                {{ $expenditure -> getStatusCodeName() }}
              </div>
            @endif
          </div>
      @endforeach
    </div>
  @endif
@endsection('content')
