@extends('layout.index')

@section('css')
	
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Nhà cung cấp
        <small>Thêm</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Thêm</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <!-- Form -->
      <form action="nhacungcap/them" method="post" enctype="application/x-www-form-urlencoded">
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
              <label>Tên nhà cung cấp</label>
              <input type="text" class="form-control" placeholder="Nhập tên nhà cung cấp" name="tennhacungcap" required="">
            </div>
            <div class="form-group">
              <label>Địa chỉ</label>
              <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="diachi" required="">
            </div>

          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" placeholder="Nhập Email" name="email" required="">
            </div>
            <div class="form-group">
              <label>Số điện thoại</label>
              <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="sodienthoai" required="">
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Lưu lại</button>
        <a href="nhacungcap"><button type="button" class="btn btn-danger">Hủy bỏ</button></a>
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

@endsection