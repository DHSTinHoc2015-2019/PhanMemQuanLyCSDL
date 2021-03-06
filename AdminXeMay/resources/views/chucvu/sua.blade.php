@extends('layout.index')

@section('css')

@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Chức vụ
      <small>Sửa</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Sửa chức vụ</li> 
      <li class="active">{{ $chucvu->id }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box box-default">
      <!-- Form -->
      <form action="chucvu/sua/{{ $chucvu->id }}" method="post" enctype="application/x-www-form-urlencoded">
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
              <label>Tên chức vụ</label>
              <input type="text" class="form-control" placeholder="Nhập tên chức vụ" name="tenchucvu" value="{{ $chucvu->tenchucvu }}" required="">
            </div>
            <div class="form-group">
              <label>Lương cơ bản</label>
              <input type="number" class="form-control" placeholder="Nhập lương cơ bản" name="luongcoban" value="{{ $chucvu->luongcoban }}" required="">
            </div>
           
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="form-group">
              <label>Hệ số lương</label>
              <input type="number" class="form-control" placeholder="Nhập hệ số lương" name="hesoluong" value="{{ $chucvu->hesoluong }}" required="">
            </div>
           
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
       <div class="box-footer">
        <button type="submit" class="btn btn-primary">Lưu lại</button>
        <a href="chucvu"><button type="button" class="btn btn-danger">Hủy bỏ</button></a>
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