@extends('layout.index')

@section('css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="plugins/iCheck/all.css">
<!-- Select2 -->
<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        <b>Nhân viên</b><small>Sửa</small>
      </h1>
    <ol class="breadcrumb"> 
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Sửa nhân viên</li>
      <li class="active">{{ $nhanvien->id }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box box-default">
      <!-- Form -->
      <form action="nhanvien/sua/{{ $nhanvien->id }}" method="post" enctype="multipart/form-data">
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
              <label>Tên nhân viên</label>
              <input type="text" class="form-control" placeholder="Nhập tên nhân viên" name="hoten" value="{{ $nhanvien->hoten }}" required="">
            </div>
            <div class="form-group">
              <label>Số CMND</label>
              <input type="text" class="form-control" placeholder="Nhập số CMND" name="socmnd" value="{{ $nhanvien->socmnd }}" required="">
            </div>
            <div class="form-group">
              <label>Số điện thoại</label>
              <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="sodienthoai" value="{{ $nhanvien->sodienthoai }}" required="">
            </div>
            <div class="form-group">
              <label>Giới tính</label><br>
              @if($nhanvien->gioitinh == 'Nam')
              <input class="flat-red" type="radio" name="gioitinh" value="Nam" checked="">
              @else
              <input class="flat-red" type="radio" name="gioitinh" value="Nam">
              @endif
              <label class="form-check-label">Nam</label>
              @if($nhanvien->gioitinh == 'Nữ')
              <input class="flat-red" type="radio" name="gioitinh" value="Nữ" checked="">
              @else
              <input class="flat-red" type="radio" name="gioitinh" value="Nữ">
              @endif
              <label class="form-check-label">Nữ</label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="form-group">
              <label>Chức vụ</label>
              <select class="form-control select2" style="width: 100%;" name="id_chucvu" required="">
                @foreach($chucvu as $chucvu)
                @if($chucvu->id == $nhanvien->id_chucvu)
                <option selected="selected" value="{{ $chucvu->id }}">{{ $chucvu->tenchucvu }}</option>
                @else
                <option value="{{ $chucvu->id }}">{{ $chucvu->tenchucvu }}</option>
                @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Ngày sinh</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker" name="ngaysinh" value="{{ date('m/d/Y', strtotime($nhanvien->ngaysinh)) }}" required="">
              </div>
            </div>
            <div class="form-group">
              <label>Quê quán</label>
              <input type="text" class="form-control" placeholder="Nhập quê quán" name="quequan" value="{{ $nhanvien->quequan }}" required="">
            </div>
            <div class="form-group">
              <label>Phụ cấp</label>
              <input type="number" class="form-control" placeholder="Nhập phụ cấp" name="phucap" value="{{ $nhanvien->phucap }}" required="">
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-12">
            <h4 class="card-inside-title">Chọn ảnh</h4>
            <div class="form-group">
              <input type="file" name="file" id="profile-img"> 
              @if ($nhanvien->img == "")
              <img src="" id="profile-img-tag" width="500px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
              @else
              <img src="uploads/user/{{ $nhanvien->img }}" id="profile-img-tag" width="500px" style="display: block; margin-left: auto; margin-right: auto;"
              /> 
              @endif
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Lưu lại</button>
        <a href="nhanvien"><button type="button" class="btn btn-danger">Hủy bỏ</button></a>
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
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

  });
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#profile-img-tag').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#profile-img").change(function () {
    readURL(this);
  });
</script>
@endsection