<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>** @yield('title') -laravel在线应用</title>
    <link rel="stylesheet" href="/css/app.css"
  </head>
  <body>
    @include('layouts._header')
    <div class="container">
      <div class="col-md-offset-1 col-md-10">
        @include('shared._messages')
    @yield('content')
    @include('layouts._footer')
  </div>
  </div>
   <script src="/js/app.js"></script>
  </body>
</html>
