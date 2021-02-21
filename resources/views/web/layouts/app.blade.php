<!doctype html>
<html lang="en">
  <head>
    @include('web.includes.head')
  </head>
  <body>
    @include('web.includes.header')

    @yield('content')



    @include('web.includes.footer')

    @include('web.includes.footer-script')




  </body>
</html>