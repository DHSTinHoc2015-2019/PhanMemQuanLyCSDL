@extends('layout.index')

@section('css')
	
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <b><h1>
        Loại phụ tùng
        <small>Thêm</small>
      </h1></b>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Thêm loại phụ tùng</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
         <!-- Form -->
      <form action="loaiphutung/them" method="post" enctype="multipart/form-data">
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
              <label>Tên phụ tùng</label>
              <input type="text" class="form-control" placeholder="Nhập tên loại phụ tùng" name="tenphutung" required="">
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="form-group">
              <label>Đơn vị tính</label>
              <input type="text" class="form-control" placeholder="Nhập đơn vị tính" name="donvitinh" required="" value="Cái">
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
        <a href="loaiphutung"><button type="button" class="btn btn-danger">Hủy bỏ</button></a>
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