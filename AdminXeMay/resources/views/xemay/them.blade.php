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
      <b>Xe máy</b><small>Thêm</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Thêm xe máy</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box box-default">
     <!-- Form -->
     <form action="xemay/them" method="post" enctype="multipart/form-data">
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
              <label>Tên xe máy</label>
              <input type="text" class="form-control" placeholder="Nhập tên xe máy" name="tenxe" required="">
            </div>
            <div class="form-group">
              <label>Màu xe</label>
              <input type="text" class="form-control" placeholder="Nhập màu xe" name="mauxe" required="">
            </div>
            <div class="form-group">
              <label>Đơn giá</label>
              <input type="number" class="form-control" placeholder="Nhập đơn giá bán" name="dongia" required="">
            </div>
             <div class="form-group">
              <label>Đơn vị tính</label>
              <input type="text" class="form-control" placeholder="Nhập đơn vị tính" name="donvitinh" value="Chiếc">
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-6" id="showImg">
          <div class="form-group">
            <label>Loại bảo hành</label>
            <select class="form-control select2" style="width: 100%;" name="id_loaibaohanh" required="">
              <option value="">Chọn</option>
              @foreach($loaibaohanh as $loaibaohanh)
              <option value="{{ $loaibaohanh->id }}">{{ $loaibaohanh->tenloaibaohanh }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
              <label>Dung tích xy-lanh</label>
              <input type="number" class="form-control" placeholder="Nhập dung tích xy-lanh" name="dungtichxylanh">
            </div>
          <div class="form-group">
            <label>Năm sản xuất</label>
            <input type="number" class="form-control" placeholder="Nhập năm sản xuất" name="namsanxuat">
          </div>
             <div class="form-group">
              <label>Nơi sản xuất</label>
              <input type="text" class="form-control" placeholder="Nhập nơi sản xuất" name="noisanxuat">
            </div>
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
      <a href="xemay"><button type="button" class="btn btn-danger">Hủy bỏ</button></a>
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