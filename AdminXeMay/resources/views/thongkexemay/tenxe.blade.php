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
      <b>Thống kê theo tên xe máy</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Thống kê theo tên xe máy</li>
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
              <form action="thongke/xemay/tenxe" method="post" enctype="application/x-www-form-urlencoded">
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
                    <div class="col-md-3">
                      <div class="form-group">
                        <div style="font-size: 1.3em; font-weight: bold;">
                          <label>
                            Chọn tên xe máy
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-3">
                      <div class="form-group">
                        <select class="form-control" name="tenxe">
                          <option value="">Chọn</option>
                            @foreach($tenxe as $tenxe)
                            <option value="{{ $tenxe->tenxe}}">{{ $tenxe->tenxe }}</option>
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
                        <a class="btn btn-warning" href="xemay/xemThongKeTenXePDF" target="blank">
                          <i class="fa fa-print"></i> In danh sách
                        </a>
                        @endif
                         <a class="btn btn-warning" href="xemay/xemDanhSachTheoTungLoaiXePDF" target="blank">
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
                  <th>Tên xe</th>
                  <th>Màu xe</th>
                  <th>Đơn giá</th>
                  <th>Số lượng</th>
                  <th>Dung tích</th>
                  <th>Đơn vị tính</th>
                  <th>Loại bảo hành</th>
                  <th>Năm sản xuất</th>
                  <th>Nơi sản xuất</th>
                  <th>Hình ảnh</th>
                  <th>In</th>
              </tr>
            </thead>
            <tbody>
             @foreach($xemay as $xemay)
               <tr>
                <td>{{ $xemay->id }}</td>
                <td>{{ $xemay->tenxe }}</td>
                <td>{{ $xemay->mauxe }}</td>
                <td>{{ number_format($xemay->dongia, 0, '', '.') }}đ</td>
                <td>{{ $xemay->soluong }}</td>
                <td>{{ $xemay->dungtichxylanh }}</td>
                <td>{{ $xemay->donvitinh }}</td>
                <td>{{ $xemay->tenloaibaohanh }}</td>
                <td>{{ $xemay->namsanxuat }}</td>
                <td>{{ $xemay->noisanxuat }}</td>
                <td>
                  <a href="uploads/xemay/{{ $xemay->img }}" target="blank"><img src="uploads/xemay/{{ $xemay->img }}" width="100" height="60"></a>
                </td>
             <td>
              <a class="btn btn-warning" href="xemay/in/{{ $xemay->id }}" target="blank">
                <i class="fa fa-print"></i>
              </a>
            </td>
          </tr>
          @endforeach
      </tbody>
      <tfoot>
        <tr>
              <th>ID</th>
              <th>Tên xe</th>
              <th>Màu xe</th>
              <th>Đơn giá</th>
              <th>Số lượng</th>
              <th>Dung tích</th>
              <th>Đơn vị tính</th>
              <th>Loại bảo hành</th>
              <th>Năm sản xuất</th>
              <th>Nơi sản xuất</th>
              <th>Hình ảnh</th>
              <th>In</th>
         </tr>
      </tfoot>
    </table>
    <div class="col-md-10">
          @if(!empty($sum))
        <p style="font-size: 1.5em; color: red;">Tổng số lượng xe: {{ $sum }} <br> Chiếm tỉ lệ {{ $tile }}% tổng số xe máy</p>
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
<script>
  function Delete(id) {
    swal({
      title: "Bạn có chắc chắn muốn xóa dữ liệu?",
      text: "Sau khi xóa, bạn sẽ không thể phục hồi dữ liệu này!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((isConfirm) => {
      if (isConfirm) {
        window.location.href = "nhanvien/xoa/" + id;
      } else {
        swal("Dữ liệu của bạn không thay đổi!");
      }
    });
  }
</script>
@endsection