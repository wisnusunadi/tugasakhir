<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title', 'Sistem Penerimaan Karyawan')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset('themes/plugins/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('themes/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTable-->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.6.0/dt-1.11.4/rg-1.1.4/datatables.min.css"/>
  <!-- <link rel="stylesheet" href="{{ asset('themes/plugins/datatables/datatables.min.css') }}"> -->
     <!-- Select2 -->
     <link rel="stylesheet" href="{{ asset('themes/plugins/select2/css/select2.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('themes/dist/css/adminlte.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('themes/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
@yield('custom_css')
<style>
  @font-face
  {
    font-family: 'Poppins';
    src: url('assets/font/Poppins/Poppins-Regular.ttf');
  }
  aside{
    background: #8199AE;
  }
  body{
    font-family: 'Poppins';
    background-color: #F0F0F0;
  }
  footer{
    bottom: 0;
    position: fixed;
    width: 100%;
  }
  @media screen and (min-width:992px){
    body{font-size: 14px;}
  }

  @media screen and (max-width:991px){
    body{font-size: 12px;}
  }
</style>
<body class="hold-transition login-page">
 
    @yield('content')
 
<!-- jQuery -->
<script src="{{ asset('themes/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('themes/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('themes/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTable-->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.6.0/dt-1.11.4/rg-1.1.4/datatables.min.js"></script>
<!-- <link rel="stylesheet" href="{{ asset('themes/plugins/datatables/datatables.min.js') }}" type="text/javascript"> -->
<!-- Select2 -->
<script src="{{ asset('themes/plugins/select2/js/select2.min.js') }}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{ asset('themes/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('themes/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('themes/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('themes/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('themes/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('themes/dist/js/pages/dashboard.js') }}"></script>
 <!-- Font Awesome -->
 <script type="text/javascript" src="{{ asset('themes/plugins/fontawesome-free/js/all.min.js') }}"></script>
@yield('script')

</body>
</html>