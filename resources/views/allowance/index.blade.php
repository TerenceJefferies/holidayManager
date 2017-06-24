@extends('layouts.common')

@section('content')
  <h1>Your Allowance</h1>
  <div class="row">
    <div class="col-md-6">Days</div>
    <div class="col-md-6">{{ $allowance -> days }}</div>
  </div>
  <div class="row">
    <div class="col-md-6">Allowance Start Date</div>
    <div class="col-md-6">{{ $allowance -> starts -> format('d/m/Y') }}</div>
  </div>
  <div class="row">
    <div class="col-md-6">Allowance End Date</div>
    <div class="col-md-6">{{ $allowance -> ends -> format('d/m/Y') }}</div>
  </div>
  <div class="row">
    <div class="col-md-6">Days Redeemed</div>
    <div class="col-md-6">{{ $daysUsed }}</div>
  </div>
  <div class="row">
    <div class="col-md-6">Requests Accepted</div>
    <div class="col-md-6">{{ $acceptedRequestsCount }}</div>
  </div>
  <div class="row">
    <div class="col-md-6">Requests Rejected</div>
    <div class="col-md-6">{{ $rejectedRequestsCount }}</div>
  </div>
  <!-- Upcoming Allowance -->
@endsection('content')
