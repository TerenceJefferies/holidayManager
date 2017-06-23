@extends('layouts.common')

@section('head')
<link type="text/css" rel="stylesheet" href="css/index.css">
@endsection('head')

@section('content')
  <div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-12">
      <h1>Holiday Manager</h1>
      <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="/login">
          {{ csrf_field() }}
          <input type="text" name="email" placeholder="Email Address" required class="form-control">
          <input type="password" name="password" placeholder="Password" required class="form-control">
          <input type="submit" class="form-control" value="Login">
          <button type="button" class="btn btn-deault login-forgot-btn">Forgot</button>
        </form>
      </div>
    </div>
  </div>
@endsection('content')
