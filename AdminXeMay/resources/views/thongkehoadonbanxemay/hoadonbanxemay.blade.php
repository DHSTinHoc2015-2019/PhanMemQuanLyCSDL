@extends('layout.index')

@section('css')
  
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <b>THỐNG KÊ HÓA ĐƠN BÁN XE MÁY</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
      <li>Thống kê hóa đơn bán xe máy</li>
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
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <div class="panel panel-primary animated fadeInLeft" style="animation-duration: 4s;">
                <div class="panel-heading"><center><b style="font-size: 1.5em;">TIÊU CHÍ THỐNG KÊ</b></center></div>
                <div class="panel-body">
                <a href="" class="btn btn-success btn-block" style="font-size: 1.3em; margin-bottom: 1em;">XE MÁY BÁN THÁNG NÀY</a>
                <a href="" class="btn btn-success btn-block" style="font-size: 1.3em; margin-bottom: 1em;">XE MÁY BÁN NĂM NÀY</a>
                <a href="" class="btn btn-success btn-block" style="font-size: 1.3em; margin-bottom: 1em;">XE MÁY BÁN THEO THÁNG</a>
                <a href="" class="btn btn-success btn-block" style="font-size: 1.3em; margin-bottom: 1em;">XE MÁY BÁN THEO QUÝ</a>
                <a href="" class="btn btn-success btn-block" style="font-size: 1.3em; margin-bottom: 1em;">XE MÁY BÁN THEO NĂM</a>
                <a href="" class="btn btn-success btn-block" style="font-size: 1.3em; margin-bottom: 1em;">XE MÁY BÁN THEO KHOẢNG THỜI GIAN</a>
                </div>
              </div>
            </div>
            <div class="col-md-3"></div>
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