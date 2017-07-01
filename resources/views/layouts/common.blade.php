<!DOCTYPE html>
  <head>
      <title>Holiday Management</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://fonts.googleapis.com/css?family=Muli:200" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link type="text/css" rel="stylesheet" href="{{ URL::asset('css/global.css')  }}">
      @yield('head')
  </head>
<html>
<body>
  @if(Session::get('submission'))
    @include('layouts.partials.flashSubmission')
  @endif
  @include('layouts.partials.header')
  <div class="container">
    @yield('content')
  </div>
</body>
</html>
