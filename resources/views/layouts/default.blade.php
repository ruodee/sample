<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>** @yield('title') -laravel在线应用</title>
    <link rel="stylesheet" href="/css/app.css"
  </head>
  <body>
    <div class="container">
      <div class="col-md-offset-1 col-md-10">
        @include('shared._messages')
    @yield('content')
  </div>
  </div>
  </body>
</html>
