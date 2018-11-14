@extends('layout.index')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <b>Thống kê xe máy bán từ {{$tungay}} đến {{$denngay}} theo từng ngày</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
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
              <form action="thongke/hoadonbanxemay/khoangthoigiantheongay/{{$tungay}}/{{$denngay}}" method="post" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="box box-default" style="border: none;">
                  <div class="box-header with-border" style="border: none;">
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body with-border">
                    <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div style="font-size: 1.3em; font-weight: bold;">
                          <label>
                            Chọn ngày
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-3">
                      <div class="form-group">
                        <select class="form-control" name="ngay">
                          <option value="">Chọn</option>
                            @foreach($ngay as $ngay)
                            <option value="{{ $ngay}}">{{ $ngay }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-2">
                       <button type="submit" class="btn btn-primary">THỐNG KÊ</button>
                    </div>
                    <div class="col-md-4">
                      <div class="pull-right">
                         @if(!empty($sum))
                        <a class="btn btn-warning" href="hoadonbanxemay/xemThongKeKhoangThoiGianTheoNgayPDF" target="blank">
                          <i class="fa fa-print"></i> In danh sách
                        </a>
                        @endif
                         <a class="btn btn-warning" href="hoadonbanxemay/xemTheoKhoangThoiGianDanhSachTheoNgayPDF/{{$tungay}}/{{$denngay}}" target="blank">
                          <i class="fa fa-print"></i> In toàn bộ
                        </a>
                      </div>
                    </div>
                    <!-- /.col -->

                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer" style="border: none;">

               </div>

             </form>
             <hr>
           </div>
         </div>

         <!-- /.box-header -->
         <div class="box-body">
           <!-- /.box-header -->
         <div class="box-body">
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
    <div class="col-md-10">
        @if(!empty($sum))
        <p style="font-size: 1.5em; color: red;">Tổng số lượng xe: {{ $sum }}</p>
        <p style="font-size: 1.5em; color: red;">Tổng thành tiền: {{ number_format($tongthanhtien, 0,'', '.') }}đ</p>
        @endif
    </div>
  </div>
  <!-- /.box-body -->
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
@endsection