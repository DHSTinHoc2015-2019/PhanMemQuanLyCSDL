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
        <b>Chi tiết nhập xe máy</b><small>{{ $id_nhapxemay }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Chi tiết nhập xe máy</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Danh sách</h3>
              <div class="pull-right">
                <a class="btn btn-info" href="chitietnhapxemay/{{ $id_nhapxemay }}/them">
                  <i class="fa fa-plus-square"></i> Thêm
                </a>
                <a class="btn btn-warning" href="nhapxemay/in/{{ $id_nhapxemay }}" target="blank">
                  <i class="fa fa-print"></i> Xem phiếu nhập
                </a>
             </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-hover">
                <thead>
                 <tr>
                  <th>ID</th>
                  <th>Mã nhập xe</th>
                  <th>Tên xe</th>
                  <th>Màu xe</th>
                  <th>Dung tích</th>
                  <th>Đơn giá nhập</th>
                  <th>Số lượng</th>
                  <th>Đơn vị tính</th>
                  <th>Hình ảnh</th>
                  <th>Chỉnh sửa</th>
                  <th>Xóa</th>
                </tr>
                </thead>
                <tbody>
                @foreach($chitietnhapxe as $chitietnhapxe)
                <tr>
                  <td>{{ $chitietnhapxe->id }}</td>
                  <td>{{ $chitietnhapxe->id_nhapxemay }}</td>
                  <td>{{ $chitietnhapxe->tenxe }}</td>
                  <td>{{ $chitietnhapxe->mauxe }}</td>
                  <td>{{ $chitietnhapxe->dungtichxylanh }}</td>
                  <td>{{ number_format($chitietnhapxe->dongianhap, 0, '', '.') }}đ</td>
                  <td>{{ $chitietnhapxe->soluong }}</td>
                  <td>{{ $chitietnhapxe->donvitinh }}</td>
                  <td>
                    <a href="uploads/xemay/{{ $chitietnhapxe->img }}"><img src="uploads/xemay/{{ $chitietnhapxe->img }}" width="100" height="60"></a>
                  </td>
                  <td>
                    <a class="btn btn-success" href="chitietnhapxemay/{{ $id_nhapxemay }}/sua/{{ $chitietnhapxe->id }}">
                      <i class="fa fa-edit"></i> Chỉnh sửa
                    </a>
                  </td>
                  <td>
                    <button class="btn btn-danger" onclick="Delete({{ $id_nhapxemay }},{{ $chitietnhapxe->id }});"><i class="fa fa-trash"></i> Xóa</button>
                  </td> 
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Mã nhập xe</th>
                  <th>Tên xe</th>
                  <th>Màu xe</th>
                  <th>Dung tích</th>
                  <th>Đơn giá nhập</th>
                  <th>Số lượng</th>
                  <th>Đơn vị tính</th>
                  <th>Hình ảnh</th>
                  <th>Chỉnh sửa</th>
                  <th>Xóa</th>
                </tr>
                </tfoot>
              </table>
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
    });
    function Delete(id, id_chitiet) {
      swal({
        title: "Bạn có chắc chắn muốn xóa dữ liệu?",
        text: "Sau khi xóa, bạn sẽ không thể phục hồi dữ liệu này!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((isConfirm) => {
        if (isConfirm) {
          window.location.href = "chitietnhapxemay/"+ id +"/xoa/" + id_chitiet;
        } else {
          swal("Dữ liệu của bạn không thay đổi!");
        }
      });
    }
  </script>
@endsection