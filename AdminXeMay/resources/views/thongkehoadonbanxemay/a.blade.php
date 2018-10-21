
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
  <div class="row">

    <div class="col-md-6">
       <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><b>XE MÁY BÁN THÁNG NÀY THEO TÊN XE</b></h1>
          
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
            <div class="col-md-12">
                {!! $chartThangNay->container() !!}
            </div>
            {!! $chartThangNay->script() !!}
          </div>
          </div>
        <!-- /.box-body -->
          <div class="box-footer">
            <a href="thongke/hoadonxemay/thanghientai" class="btn btn-success">Chi tiết</a>
            <div class="pull-right">
              <a class="btn btn-warning" href="" target="blank">
                <i class="fa fa-print"></i> In toàn bộ
              </a>
            </div>
          </div>
          <!-- /.box-footer-->
          </div>
      <!-- /.box -->
      </div>
      <!-- /.col-md -->
  
       <div class="col-md-6">
       <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><b>XE MÁY BÁN NĂM NÀY THEO TÊN XE</b></h1>
          
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
            <div class="col-md-12">
                {!! $chartNamNay->container() !!}
            </div>
            {!! $chartNamNay->script() !!}
          </div>
        </div>
        <!-- /.box-body -->
          <div class="box-footer">
           <a href="" class="btn btn-success">Chi tiết</a>
           <div class="pull-right">
              <a class="btn btn-warning" href="" target="blank">
                <i class="fa fa-print"></i> In toàn bộ
              </a>
            </div>
          </div>
          <!-- /.box-footer-->
        </div>
      <!-- /.box -->
      </div>
      <!-- /.col-md -->

      <div class="col-md-12">
       <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><b>XE MÁY BÁN THÁNG NÀY THEO TỪNG NGÀY</b></h1>
          
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
            <div class="col-md-12">
                {!! $chartThangNayTheoNgay->container() !!}
            </div>
            {!! $chartThangNayTheoNgay->script() !!}
          </div>
        </div>
        <!-- /.box-body -->
          <div class="box-footer">
           <a href="" class="btn btn-success">Chi tiết</a>
           <div class="pull-right">
              <a class="btn btn-warning" href="" target="blank">
                <i class="fa fa-print"></i> In toàn bộ
              </a>
            </div>
          </div>
          <!-- /.box-footer-->
        </div>
      <!-- /.box -->
      </div>
      <!-- /.col-md -->

      <div class="col-md-12">
       <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><b>XE MÁY BÁN NĂM NÀY THEO TỪNG THÁNG</b></h1>
          
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
            <div class="col-md-12">
                {!! $chartNamNayTheoThang->container() !!}
            </div>
            {!! $chartNamNayTheoThang->script() !!}
          </div>
        </div>
        <!-- /.box-body -->
          <div class="box-footer">
           <a href="" class="btn btn-success">Chi tiết</a>
           <div class="pull-right">
              <a class="btn btn-warning" href="" target="blank">
                <i class="fa fa-print"></i> In toàn bộ
              </a>
            </div>
          </div>
          <!-- /.box-footer-->
        </div>
      <!-- /.box -->
      </div>
      <!-- /.col-md -->


      <div class="col-md-2"></div>
      <div class="col-md-8">
       <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title"><b>ĐƠN GIÁ BÁN</b></h1>
              
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
                <div class="col-md-12">
                    <ul class="nav nav-pills ranges">
                        <li class="active"><a href="#" data-range='0-20000000'>Dưới 20 triệu</a></li>
                        <li><a href="#" data-range='20000000-30000000'>20 - 30 triệu</a></li>
                        <li><a href="#" data-range='30000000-40000000'>30 - 40 triệu</a></li>
                        <li><a href="#" data-range='40000000-50000000'>40 - 50 triệu</a></li>
                        <li><a href="#" data-range='50000000-500000000'>trên 50 triệu</a></li>
                    </ul> 
                </div>
                <div class="col-xs-12">
                  <!-- <div id="stats-container" style="height: 250px;"></div> -->
                  <div id="stats-container"></div>
                </div>
              </div>
              </div>
            <!-- /.box-body -->
              <div class="box-footer">
                <a href="thongke/xemay/dongia" class="btn btn-success">Chi tiết</a>
                <div class="pull-right">
                  <a class="btn btn-warning" href="" target="blank">
                    <i class="fa fa-print"></i> In toàn bộ
                  </a>
                </div>
              </div>
              <!-- /.box-footer-->
              </div>
          <!-- /.box -->
        </div>
        <div class="col-md-2"></div>
        <!-- /.col-md -->
        --}}
    </div>
  </div>
    
  </section>
  <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('script')
  <script src="bower_components/charts/Chart.bundle.js" charset="utf-8"></script>
  <link rel="stylesheet" href="bower_components/charts/morris/morris.css">
  <script src="bower_components/charts/raphael/raphael-min.js"></script>
   <script src="bower_components/charts/morris/morris.min.js"></script>
 <script>
 $(function() {

  // Create a function that will handle AJAX requests
    function requestData(gia, chart){
      $.ajax({
        type: "GET",
        dataType: 'json',
        url: "ajax/getThongKeXeMayTheoGia/" + gia, // This is the URL to the API
        data: { gia: gia }
      })
      .done(function( data ) {
        // When the response to the AJAX request comes back render the chart with new data
        chart.setData(data);
      })
      .fail(function() {
        // If there is no communication between the server, show an error
        alert( "error occured" );
      });
    }

    var chart = Morris.Bar({
      // ID of the element in which to draw the chart.
      element: 'stats-container',
      data: [0, 0], // Set initial data (ideally you would provide an array of default data)
      xkey: 'ten', // Set the key for X-axis
      ykeys: ['soluong'], // Set the key for Y-axis
      labels: ['Số lượng'], // Set the label when bar is rolled over
      barColors: ['#4da74d'],
      // barColors: ['#4da74d', '#7a92a3', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed'],
    });

    // Request initial data for the past 0-20000000 gia:
    requestData('0-20000000', chart);

    $('ul.ranges a').click(function(e){
      e.preventDefault();

      // Get the number of gia from the data attribute
      var el = $(this);
      gia = el.attr('data-range');
      // console.log(gia);
      // Request the data and render the chart using our handy function
      requestData(gia, chart);
      el.parent().addClass('active');
      el.parent().siblings().removeClass('active');
    })
  });
</script>
@endsection
