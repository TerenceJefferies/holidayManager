<!DOCTYPE html>
  <head>
      <title>Holiday Management</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://fonts.googleapis.com/css?family=Muli:200" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="{{ URL::asset('css/common.css') }}">
      <link type="text/css" rel="stylesheet" href="{{ URL::asset('css/global.css')  }}">
      @yield('head')
  </head>
<html>
<body>
  @include('layouts.partials.header')
  <div class="container">
    @yield('content')
  </div>
</body>
</html>
