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
      <b>Nhà cung cấp</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li><a href="nhacungcap">Nhà cung cấp</a></li>
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
              <a class="btn btn-warning" href="nhacungcap/viewPDF" target="blank">
                <i class="fa fa-print"></i> In danh sách
              </a>
              <a class="btn btn-info" href="nhacungcap/them">
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
                  <th>Tên nhà cung cấp</th>
                  <th>Địa chỉ</th>
                  <th>Email</th>
                  <th>Số điện thoại</th>
                  <th>Chỉnh sửa</th>
                  <th>Xóa</th>
                  <th>In</th>
                </tr>
              </thead>
              <tbody>
                @foreach($nhacungcap as $nhacungcap)
                <tr>
                  <td>{{ $nhacungcap->id }}</td>
                  <td>{{ $nhacungcap->tennhacungcap }}</td>
                  <td>{{ $nhacungcap->diachi }}</td>
                  <td>{{ $nhacungcap->email }}</td>
                  <td>{{ $nhacungcap->sodienthoai }}</td>
                  <td>
                   <a class="btn btn-success" href="nhacungcap/sua/{{ $nhacungcap->id }}">
                    <i class="fa fa-edit"></i> Chỉnh sửa
                  </a>
                </td>
                <td>
                  <button class="btn btn-danger" onclick="Delete({{ $nhacungcap->id }});"><i class="fa fa-trash"></i> Xóa</button>
                </td>
                <td>
                  <a class="btn btn-warning" href="nhacungcap/in/{{ $nhacungcap->id }}" target="blank">
                  <i class="fa fa-print"> In</i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>Tên nhà cung cấp</th>
              <th>Địa chỉ</th>
              <th>Email</th>
              <th>Số điện thoại</th>
              <th>Chỉnh sửa</th>
              <th>Xóa</th>
              <th>In</th>
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
        window.location.href = "nhacungcap/xoa/" + id;
      } else {
        swal("Dữ liệu của bạn không thay đổi!");
      }
    });
  }
</script>
@endsection