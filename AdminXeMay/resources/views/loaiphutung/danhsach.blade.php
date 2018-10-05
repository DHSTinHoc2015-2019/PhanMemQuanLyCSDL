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
        <b>Loại phụ tùng</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="loaiphutung">Loại phụ tùng</a></li>
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
                <a class="btn btn-info" href="loaiphutung/them">
                    <i class="fa fa-plus-square"></i> Thêm
                  </a>
             </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên phụ tùng</th>
                  <th>Đơn vị tính</th>
                  <th>Hình ảnh</th>
                  <th>Chỉnh sửa</th>
                  <th>Xóa</th>
                </tr>
                </thead>
                <tbody>
                @foreach($loaiphutung as $loaiphutung)
                <tr>
                  <td>{{ $loaiphutung->id }}</td>
                  <td>{{ $loaiphutung->tenphutung }}</td>
                  <td>{{ $loaiphutung->donvitinh }}</td>
                  <td>
                    <a href="uploads/phutung/{{ $loaiphutung->imgphutung }}" target="blank">
                      <img src="uploads/phutung/{{ $loaiphutung->imgphutung }}" alt="" height="150" width="300">
                    </a>
                  </td>
                  <td>
                    <a class="btn btn-success" href="loaiphutung/sua/{{ $loaiphutung->id }}">
                      <i class="fa fa-edit"></i> Chỉnh sửa
                    </a>
                  </td>
                  <td>
                    <button class="btn btn-danger" onclick="Delete({{ $loaiphutung->id }});"><i class="fa fa-trash"></i> Xóa</button>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Tên phụ tùng</th>
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
        window.location.href = "loaiphutung/xoa/" + id;
      } else {
        swal("Dữ liệu của bạn không thay đổi!");
      }
    });
  }
  </script>
@endsection