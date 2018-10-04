<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Admin</title>
  <base href="{{ asset('') }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- Animate -->
  <link rel="stylesheet" href="plugins/animate/animate.css">

  @yield('css')
  <link rel="stylesheet" href="dist/css/skins/skin-blue.css">
  <link rel="stylesheet" href="dist/css/skins/skin-yellow.css">

  <!-- Google Font -->
  <!-- <link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
</head>

<!-- <body class="hold-transition skin-blue sidebar-mini" style="font-size: 1.5em;"> -->
<body class="hold-transition skin-yellow sidebar-mini">
  <div class="wrapper">

    @include('layout.header')
    @include('layout.menuleft')

    @yield('content')

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="pull-right hidden-xs">
        Trần Quang Tân - Lê Kim Long - Nguyễn Thị Bích Ngọc - Nguyễn Vũ Luân
      </div>
      <!-- Default to the left -->
      <!-- <strong>Copyright &copy; 2018</strong> All rights reserved. -->
      Xây dựng phần mềm quản trị cơ sở dữ liệu - Giảng viên hướng dẫn: Lê Phước Nam Hà
    </footer>

    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
    <!-- sweetalert -->
  <script src="bower_components/sweetalert/sweetalert.min.js"></script>

  <!-- script trả về khi xóa thành công -->
    @if (session('thongbaoxoa'))
    <script>
        swal({
            title: "Xóa dữ liệu thành công",
            timer: 3000,
            icon: "success",
        })
    </script>
    @endif

    <!-- script trả về khi sửa thành công -->
    @if (session('thongbaosua')))
    <script>
        swal({
            title: "{{ session('thongbaosua') }}",
            timer: 3000,
            icon: "success",
        })
    </script>
    @endif
    <!-- script trả về khi sửa thành công -->
    @if (session('thongbaothem')))
    <script>
        swal({
            title: "{{ session('thongbaothem') }}",
            timer: 3000,
            icon: "success",
        })
    </script>
    @endif 
     <!-- script trả về khi xóa không thành công -->
    @if (session('thongbaoxoakhongthanhcong')))
    <script>
        swal({
            title: "{{ session('thongbaoxoakhongthanhcong')}}".replace(/(&quot\;)/g, "\""),
            timer: 3000,
            showConfirmButton: false,
            icon: "warning",
        })
    </script>
    @endif

  @yield('script')
</body>
</html>