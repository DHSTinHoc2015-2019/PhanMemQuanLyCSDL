@extends('layout.index')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
 <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <b>THỐNG KÊ HÓA ĐƠN BÁN XE MÁY THEO KHOẢNG THỜI GIAN</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Thống kê hóa đơn bán xe máy theo khoảng thời gian</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <div class="col-xs-12">
              <!-- Form -->
              <form action="thongke/hoadonbanxemay/chonkhoangthoigian" method="post" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="box box-default" style="border: none;">
                  <div class="box-header with-border">
                    <h1 class="box-title"><b>Chọn</b></h1>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body with-border">
                    <div class="row">
                      <div class="col-md-3"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div style="font-size: 1.3em; font-weight: bold; text-align: right;">
                          <label>
                            Chọn ngày
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-3">
                      <div class="form-group">
                          <div class="input-group">
                            <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                              <span style="font-size: 1.2em;">Chọn ngày</span>
                              <i class="fa fa-caret-down"></i>
                            </button>
                          </div>
                        </div>
                    </div>

                    <!-- <div class="col-md-2">
                      <div class="form-group">
                        <div style="font-size: 1.3em; font-weight: bold; text-align: right;">
                          <label>
                            Chọn năm
                          </label>
                        </div>
                      </div>
                    </div> -->
                    <!-- /.col -->
<!-- 
                    <div class="col-md-2">
                      <div class="form-group">
                        <select class="form-control" name="nam" required="">
                          <option value="">Chọn</option>
                          @for ($i = 2017; $i < 2050; $i++)
                              <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                        </select>
                      </div>
                    </div> -->
                    <!-- /.col -->

                    <div class="col-md-1">
                       <button type="button" class="btn btn-primary" id="saveBtn">THỐNG KÊ</button>
                    </div>
                    <div class="col-md-3">
                      
                    </div>
                    <!-- /.col -->

                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.box-body -->

             </form>
           </div>
         </div>

         <!-- /.box-header -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('script')
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- date-range-picker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>

<script>
   
    //Date range picker
    // $('#reservation').daterangepicker()
    //Date range picker with time picker
    // $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    var startDate;
    var endDate;
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Hôm nay'       : [moment(), moment()],
          'Hôm qua'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          '7 ngày trước' : [moment().subtract(6, 'days'), moment()],
          '30 ngày trước': [moment().subtract(29, 'days'), moment()],
          'Tháng này'  : [moment().startOf('month'), moment().endOf('month')],
          'Tháng trước'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        startDate = start;
        endDate = end;  
      }
    )
    $('#saveBtn').click(function(){
      var valtext = document.getElementById('daterange-btn').children[0].textContent;
      if(valtext != 'Chọn ngày'){
        console.log(startDate.format('YYYY-MM-DD') + ' - ' + endDate.format('YYYY-MM-DD'));
        window.location.href = "thongke/hoadonbanxemay/khoangthoigian/" + startDate.format('YYYY-MM-DD') + '/' + endDate.format('YYYY-MM-DD');
      }
    });
</script>
@endsection