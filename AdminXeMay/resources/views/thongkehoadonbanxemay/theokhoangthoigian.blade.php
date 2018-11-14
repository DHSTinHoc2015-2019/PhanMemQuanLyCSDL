
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
      <b>THỐNG KÊ HÓA ĐƠN BÁN XE MÁY TỪ NGÀY {{ $tungay }} ĐẾN NGÀY {{ $denngay }}</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content" style="font-size: 1.2em;">
    <div class="row">
      <div class="col-md-12">
       <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><b>Chọn</b></h1>
          
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
                <form action="thongke/hoadonbanxemay/chon" method="post" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="row">
                      <div class="col-md-3"></div>
                    <!-- /.col -->
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
                    <!-- /.col -->

                    <div class="col-md-1">
                       <button type="button" class="btn btn-primary" id="saveBtn">THỐNG KÊ</button>
                    </div>
                    <div class="col-md-3">
                      
                    </div>
                    <!-- /.col -->

                  </div>
                  <!-- /.row -->

              </form>
            </div>
          
          </div>
        </div>
        <!-- /.box-body -->
        </div>
      <!-- /.box -->
      </div>
      <!-- /.col-md -->

      <div class="col-md-12">
       <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><b>XE MÁY BÁN TỪ NGÀY {{ $tungay }} ĐẾN NGÀY {{ $denngay }} THEO TÊN XE</b></h1>
          
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
                {!! $chartTen->container() !!}
            </div>
            {!! $chartTen->script() !!}
          </div>
        </div>
        <!-- /.box-body -->
          <div class="box-footer">
           <a href="thongke/hoadonbanxemay/khoangthoigiantheotenxe/{{$tungay}}/{{ $denngay }}" class="btn btn-success">Chi tiết</a>
           <div class="pull-right">
              <a class="btn btn-warning" href="hoadonbanxemay/xemTheoKhoangThoiGianDanhSachTenXePDF/{{$tungay}}/{{ $denngay }}" target="blank">
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
        <h1 class="box-title"><b>XE MÁY BÁN TỪ NGÀY {{ $tungay }} ĐẾN NGÀY {{ $denngay }} THEO TỪNG NGÀY</b></h1>
          
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
                {!! $chartNgay->container() !!}
            </div>
            {!! $chartNgay->script() !!}

          </div>
        </div>
        <!-- /.box-body -->
          <div class="box-footer">
           <a href="thongke/hoadonbanxemay/khoangthoigiantheongay/{{$tungay}}/{{$denngay}}" class="btn btn-success">Chi tiết</a>
           <div class="pull-right">
              <a class="btn btn-warning" href="hoadonbanxemay/xemTheoKhoangThoiGianDanhSachTheoNgayPDF/{{$tungay}}/{{$denngay}}" target="blank">
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
        <h1 class="box-title"><b>DANH SÁCH XE MÁY BÁN TỪ NGÀY {{ $tungay }} ĐẾN NGÀY {{ $denngay }}</b></h1>
          
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
                <table id="example" class="table table-bordered table-hover">
                <thead>
                 <tr>
                  <th>ID</th>
                  <th>Ngày bán</th>
                  <th>Tên xe</th>
                  <th>Màu xe</th>
                  <th>Đơn giá</th>
                  <th>SL</th>
                  <th>Thuế VAT</th>
                  <th>Thành tiền</th>
                  <th>Hình ảnh</th>
                  <th>Tên KH</th>
                  <th>Địa chỉ</th>
                  <th>In</th>
                </tr>
                </thead>
                <tbody>
                @foreach($hoadonbanxemay as $hoadonbanxemay)
                <tr>
                  <td>{{ $hoadonbanxemay->id }}</td>
                  <td>{{ $hoadonbanxemay->ngayban }}</td>
                  <td>{{ $hoadonbanxemay->tenxe }}</td>
                  <td>{{ $hoadonbanxemay->mauxe }}</td>
                  <td>{{ number_format($hoadonbanxemay->dongia , 0, '', '.') }}đ</td>
                  <td>{{ $hoadonbanxemay->soluong }}</td>
                  <td>{{ $hoadonbanxemay->thueVAT }}</td>
                  <td>{{ number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.') }}đ</td>
                  <td>
                    <a href="uploads/xemay/{{ $hoadonbanxemay->img }}"><img src="uploads/xemay/{{ $hoadonbanxemay->img }}" width="100" height="60"></a>
                  </td>
                  <td>{{ $hoadonbanxemay->tenkhachhang }}</td>
                  <td>{{ $hoadonbanxemay->diachi }}</td>
                   <td>
                     <a class="btn btn-warning" href="hoadonbanxemay/in/{{ $hoadonbanxemay->id }}" target="blank">
                      <i class="fa fa-print"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Ngày bán</th>
                  <th>Tên xe</th>
                  <th>Màu xe</th>
                  <th>Đơn giá</th>
                  <th>SL</th>
                  <th>Thuế VAT</th>
                  <th>Thành tiền</th>
                  <th>Hình ảnh</th>
                  <th>Tên KH</th>
                  <th>Địa chỉ</th>
                  <th>In</th>
                </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        </div>
      <!-- /.box -->
      </div>
      <!-- /.col-md -->

    </div>
    
  </section>
  <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('script')
  <script src="bower_components/charts/Chart.bundle.js" charset="utf-8"></script>
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
  $(function () {
    $('#example').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
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