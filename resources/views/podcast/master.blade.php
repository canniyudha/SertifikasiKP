<!DOCTYPE html>
<html lang="en">
<head>
  <title>KP &mdash; Sertifikasi KP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="{{asset('podcast/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('podcast/css/magnific-popup.css')}}">
  <link rel="stylesheet" href="{{asset('podcast/css/jquery-ui.css')}}">
  <link rel="stylesheet" href="{{asset('podcast/css/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('podcast/css/owl.theme.default.min.css')}}">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">


  <link rel="stylesheet" href="{{asset('podcast/css/aos.css')}}">

  <link rel="stylesheet" href="{{asset('podcast/css/style.css')}}">
  @stack('scripts-head')
</head>
<body>

  <div class="site-wrap">
    <!-- HEADER -->
    @include('podcast.components.header')

    <!-- CONTENT -->
    @yield('content')

    <!-- FOOTER -->
    @include('podcast.components.footer')
  </div>

  <!-- SCRIPT -->
  @include('podcast.components.scripts')
  @stack('scripts')
</body>
</html>
