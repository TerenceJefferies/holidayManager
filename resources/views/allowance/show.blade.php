@extends('layouts.common')

@section('head')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/allowance.css')  }}" />
@endsection('head')

@section('content')
<h1>Allowance Usage</h1>
<p>Usage of your holiday allowance in period {{ $allowance -> starts -> format('d/m/Y') }} - {{ $allowance -> ends -> format('d/m/Y') }}</p>

@if($expenditures)
  <div class="usage-table">
    <div class="row usage-table-headers hidden-xs hidden-sm">
      <div class="col-md-2">Date Requested</div>
      <div class="col-md-2">Start Date</div>
      <div class="col-md-2">End Date</div>
      <div class="col-md-2">Days</div>
      <div class="col-md-2">Status</div>
      <div class="col-md-2">Actions</div>
    </div>
    @foreach($expenditures as $expenditure)
      <div class="row usage-table-contentrow">
        <div class="col-md-2 hidden-xs hidden-sm">{{ $expenditure -> created_at -> format('d/m/Y H:i') }}</div>
        <div class="col-md-2"><label class="hidden-lg hidden-md">Holiday starting on:</label> {{ $expenditure -> starts -> format('d/m/Y') }}</div>
        <div class="col-md-2 hidden-xs hidden-sm">{{ $expenditure -> ends -> format('d/m/Y') }}</div>
        <div class="col-md-2"><label class="hidden-lg hidden-md">For: </label>{{ $expenditure -> days }} <span class="hidden-lg hidden-md">Days</span></div>
        @if($expenditure -> status == 'approved')
          <div class="col-md-2 bg-success usage-table-status">{{ $expenditure -> getStatusCodeName() }}</div>
        @elseif($expenditure -> status == 'pending')
          <div class="col-md-2 bg-warning usage-table-status">{{ $expenditure -> getStatusCodeName() }}</div>
        @elseif($expenditure -> status == 'rejected')
          <div class="col-md-2 bg-danger usage-table-status">{{ $expenditure -> getStatusCodeName() }}</div>
        @endif
        <div class="col-md-2 usage-table-actions">
          @if($expenditure -> starts -> isFuture() && $expenditure -> status != 'rejected')
            <button class="btn btn-default">Cancel</button>
          @endif
        </div>
      </div>
      <hr class="hidden-md hidden-lg" />
    @endforeach
  </div>
@endif

@endsection('content')
