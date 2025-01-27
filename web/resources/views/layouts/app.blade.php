<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Store Management Software</title>
  <link rel="icon" href="{{asset('assets/img/AdminLTELogo.png')}}" type="image/icon type">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  @stack('custom_css')
    <!-- Styles -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/css/adminlte.min.css')}}">

  
  <style type="text/css">
      label:not(.form-check-label):not(.custom-file-label) {
          font-weight: normal !important;
      }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

@include('pages.navbar')
@include('pages.sidebar')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->



  <!-- Main Footer -->
  <footer class="main-footer">
    An open-source program for everyone's use
    <div class="float-right d-none d-sm-inline-block">
      <b>No versioning added</b>
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

{{-- <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script> --}}

<!-- overlayScrollbars -->
<script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('assets/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <script src="{{asset('assets/js/jquery.validate.js')}}"></script>
 --><script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->

<!-- AdminLTE for demo purposes -->
<script src="{{asset('assets/js/demo.js')}}"></script>

<!-- Custom JS -->
<script src="{{asset('assets/js/custom.js')}}"></script>


@stack('scripts')
</body>
</html>
