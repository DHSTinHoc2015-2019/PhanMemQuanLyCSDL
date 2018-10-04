@extends('layout.index')

@section('css')
	<!-- bootstrap datepicker -->
<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="plugins/iCheck/all.css">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      <b>Khách hàng</b>
      <small>Sửa</small>
    </h1>
      <ol class="breadcrumb">
        <li><a href="#><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Sửa khách hàng</li>
        <li class="active">{{ $khachhang->id }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <!-- Form -->
      <form action="khachhang/sua/{{ $khachhang->id }}" method="post" enctype="application/x-www-form-urlencoded">
        @csrf
        <div class="box-header with-border">
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
             <div class="form-group">
              <label>Tên khách hàng</label>
              <input type="text" class="form-control" placeholder="Nhập tên khách hàng" name="tenkhachhang" value="{{ $khachhang->tenkhachhang }}">
            </div>
            <div class="form-group">
              <label>Số CMND</label>
              <input type="text" class="form-control" placeholder="Nhập số CMND" name="soCMND" value="{{ $khachhang->soCMND }}">
            </div>
            <div class="form-group">
              <label>Số điện thoại</label>
              <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="sodienthoai" value="{{ $khachhang->sodienthoai }}">
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="form-group">
              <label>Ngày sinh</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker" name="ngaysinh" value="{{ date('m/d/Y', strtotime($khachhang->ngaysinh)) }}">
              </div>
            </div>
            <div class="form-group">
              <label>Địa chỉ</label>
              <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="diachi" value="{{ $khachhang->diachi }}">
            </div>
            <div class="form-group">
              <label>Giới tính</label><br>
              @if($khachhang->gioitinh == 'Nam')
              <input class="flat-red" type="radio" name="gioitinh" value="Nam" checked="">
              @else
              <input class="flat-red" type="radio" name="gioitinh" value="Nam">
              @endif
              <label class="form-check-label">Nam</label>
              @if($khachhang->gioitinh == 'Nữ')
              <input class="flat-red" type="radio" name="gioitinh" value="Nữ" checked="">
              @else
              <input class="flat-red" type="radio" name="gioitinh" value="Nữ">
              @endif
              <label class="form-check-label">Nữ</label>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Lưu lại</button>
        <a href="khachhang"><button type="button" class="btn btn-danger">Hủy bỏ</button></a>
      </div>
    </form>
    <!-- /Form -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('script')
<!-- date-range-picker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

  })
</script>
@endsection