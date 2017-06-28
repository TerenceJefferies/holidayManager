@extends('layouts.common')

@section('head')
  <link rel="stylesheet" href="{{ URL::asset('css/expenditure.css') }}" type="text/css" />
@endsection('head')

@section('content')
  <form action="" method="POST">
    <div class="row">
      <div class="page-header">
        <h1>Request a new Holiday</h1>
        <span class="sub-header">Allows you to request a holiday by start/end Date, or by amount of days.</span>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label" for="expenditure-startdate">Start Date:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                  <input type="date" name="startDate" class="form-control" id="expenditure-startdate">
                </div>
              </div>
          </div>
          <div class="hidden-xs hidden-sm col-md-2 col-lg-2 expenditure-form-until">Until</div>
          <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
              <div class="form-group">
                <label for="expenditure-ends">End Date:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                  <input type="date" id="expenditure-ends" class="form-control" name="endDate">
                </div>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="form-group">
                <label for="expenditure-days">Days:</label>
                <input type="number" id="expenditure-days" class="form-control" name="days" min="1" step=".5" placeholder="0">
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
              <div class="form-group">
                <input type="submit" class="form-control">
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-md-offset-1">
        <h3 class="">Your Holiday</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
    </div>
  </form>
@endsection('content')
