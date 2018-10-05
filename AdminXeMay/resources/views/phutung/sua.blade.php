@extends('layout.index')

@section('css')
<!-- Select2 -->
<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <b>
        Phụ tùng
        <small>Chỉnh sửa</small>
      </b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Phụ tùng</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box box-default">
     <!-- Form -->
     <form action="phutung/sua/{{ $phutung->id }}" method="post" enctype="application/x-www-form-urlencoded">
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
            <label>Chọn loại phụ tùng</label>
            <select class="form-control select2" style="width: 100%;" name="id_loaiphutung" required="" onchange="chonLoaiPhuTung(this.value)">
              <option value="">Chọn</option>
              @foreach($loaiphutung as $loaiphutung)
              @if($loaiphutung->id == $phutung->id_loaiphutung)
              <option value="{{ $loaiphutung->id }}" selected="">{{ $loaiphutung->tenphutung }}</option>
              @else
              <option value="{{ $loaiphutung->id }}">{{ $loaiphutung->tenphutung }}</option>
              @endif
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Loại xe</label>
            <input type="text" class="form-control" placeholder="Nhập loại xe" name="loaixe" required="" value="{{ $phutung->loaixe }}">
          </div>
          <div class="form-group">
            <label>Số lượng</label>
            <input type="number" class="form-control" placeholder="Nhập số lượng" name="soluong" required="" value="{{ $phutung->soluong }}">
          </div>
          <div class="form-group">
            <label>Đơn giá</label>
            <input type="number" class="form-control" placeholder="Nhập đơn giá" name="dongia" required="" value="{{ $phutung->dongia }}">
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-6" id="showImg">
            <div class="form-group">
              <label>Hình ảnh phụ tùng</label>
              <img src="uploads/phutung/{{ $phutung->imgphutung }}" id="profile-img-tag" width="300px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
            </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <button type="submit" class="btn btn-primary">Lưu lại</button>
      <a href="hoadonbanxemay/"><button type="button" class="btn btn-danger">Hủy bỏ</button></a>
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
  });
  function chonLoaiPhuTung(id_loaiphutung){
        if (id_loaiphutung == "") {
          document.getElementById("showImg").innerHTML = "";
          return;
        }
        if (window.XMLHttpRequest) {
            // Cho IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // Cho IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showImg").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "ajax/getImgPhuTung/" + id_loaiphutung, true);
        xmlhttp.send();
  }
</script>
@endsection