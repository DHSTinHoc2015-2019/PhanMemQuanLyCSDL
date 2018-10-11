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
        Phụ kiện
        <small>Thêm</small>
      </b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Phụ kiện</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box box-default">
     <!-- Form -->
     <form action="phukien/them" method="post" enctype="multipart/form-data">
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
            <label>Tên phụ kiện</label>
            <input type="text" class="form-control" placeholder="Nhập tên phụ kiện" name="tenphukien" required="">
          </div>
           <div class="form-group">
            <label>Chọn loại xe</label>
            <select class="form-control select2" style="width: 100%;" name="id_xemays" required="" onchange="chonXeMay(this.value)">
              <option value="">Chọn</option>
              @foreach($xemay as $xemay)
              <option value="{{ $xemay->id }}">{{ $xemay->tenxe }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Số lượng</label>
            <input type="number" class="form-control" placeholder="Nhập số lượng" name="soluong" required="">
          </div>
          <div class="form-group">
            <label>Đơn giá</label>
            <input type="number" class="form-control" placeholder="Nhập đơn giá" name="dongia" required="">
          </div>
          <div class="form-group">
              <label>Đơn vị tính</label>
              <input type="text" class="form-control" placeholder="Nhập đơn vị tính" name="donvitinh" value="Cái" required="">
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
        <div class="col-md-12">
            <h4 class="card-inside-title">Chọn ảnh</h4>
            <div class="form-group">
              <input type="file" name="file" id="profile-img" required=""> 
              <img src="" id="profile-img-tag" width="500px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
            </div>
          </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <button type="submit" class="btn btn-primary">Lưu lại</button>
      <a href="phukien"><button type="button" class="btn btn-danger">Hủy bỏ</button></a>
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
  function chonXeMay(id_xemays){
        if (id_xemays == "") {
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
        xmlhttp.open("GET", "ajax/getImgXeMay/" + id_xemays, true);
        xmlhttp.send();
  }
</script>
<script>
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