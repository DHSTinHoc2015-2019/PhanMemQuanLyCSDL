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
        Hóa đơn bán xe máy
        <small>Thêm</small>
      </b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Hóa đơn bán xe máy</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box box-default">
     <!-- Form -->
     <form action="hoadonbanxemay/them" method="post" enctype="application/x-www-form-urlencoded">
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
            <label>Chọn xe máy</label>
            <select class="form-control select2" style="width: 100%;" name="id_xemay" required="" onchange="chonXeMay(this.value)">
              <option value="">Chọn</option>
              @foreach($xemay as $xemay)
              <option value="{{ $xemay->id }}">{{ $xemay->tenxe }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Chọn khách hàng</label>
            <select class="form-control select2" style="width: 100%;" name="id_khachhang" required="">
              <option value="">Chọn</option>
              @foreach($khachhang as $khachhang)
              <option value="{{ $khachhang->id }}">{{ $khachhang->id }} - {{ $khachhang->tenkhachhang }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Số lượng</label>
            <input type="number" class="form-control" placeholder="Nhập số lượng" name="soluong" required="" value="1" id="soluong" oninput="soluongthaydoi(this.value);">
          </div>
          <div class="form-group">
            <label>Thuế VAT</label>
            <input type="number" class="form-control" placeholder="Nhập thuế VAT" name="thueVAT" required="" value="1" oninput="thuethaydoi(this.value);" id="thue">
          </div>
          <div class="form-group">
            <label>Thành tiền</label>
            <input type="text" class="form-control" value="" disabled="" id="thanhtien">
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-6" id="showImg">
            <!-- <div class="form-group">
              <label>Hình ảnh xe máy</label>
              <img src="uploads/xemay/1.jpg" id="profile-img-tag" width="300px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
            </div> -->
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
  function chonXeMay(id_xemay){
        if (id_xemay == "") {
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
        xmlhttp.open("GET", "ajax/getImgHoaDonXeMay/" + id_xemay, true);
        xmlhttp.send();
  }

  var thanhtien = document.getElementById('thanhtien');
  var thue = document.getElementById('thue');
  var soluong = document.getElementById('soluong');
  // var dongia = document.getElementById('dongia');
  function thuethaydoi(a) {
    thanhtien.value = "";
    thanhtien.value = parseInt(dongia.value) + parseInt(dongia.value * soluong.value * a / 100);
  }

  function soluongthaydoi(a) {
    thanhtien.value = "";
    thanhtien.value = parseInt(dongia.value) + parseInt(dongia.value * a * thue.value / 100);
  }
</script>
@endsection