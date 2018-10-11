@extends('layout.index')

@section('css')
  
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <b>THỐNG KÊ XE MÁY</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
      <li>Thống kê xe máy</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content" style="font-size: 1.2em;">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <center><h1 class="box-title"><b></b></h1></center>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
          title="Collapse">
          <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <div class="panel panel-primary animated fadeInLeft" style="animation-duration: 4s;">
                <div class="panel-heading"><center><b style="font-size: 1.5em;">TIÊU CHÍ THỐNG KÊ</b></center></div>
                <div class="panel-body">
                <a href="thongke/xemay/xetrongcuahang" class="btn btn-success btn-block" style="font-size: 1.3em; margin-bottom: 1em;">XE CÓ TRONG CỬA HÀNG</a>
                <a href="thongke/xemay/tenxe" class="btn btn-success btn-block" style="font-size: 1.3em; margin-bottom: 1em;">THEO TÊN XE</a>
                <a href="thongke/xemay/soluong" class="btn btn-success btn-block" style="font-size: 1.3em; margin-bottom: 1em;">THEO SỐ LƯỢNG</a>
                <a href="thongke/xemay/dongia" class="btn btn-success btn-block" style="font-size: 1.3em; margin-bottom: 1em;">THEO GIÁ BÁN</a>
                </div>
              </div>
            </div>
            <div class="col-md-4"></div>
          </div>
        </div>
        <!-- /.box-body -->
          <!-- <div class="box-footer">
            Footer
          </div> -->
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->


    </div>
    <!-- /.content-wrapper -->
    @endsection
    @section('script')
 
  <script>
  
  </script>
@endsection