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
      <b>Nhân viên</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Nhân viên</li>
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
              <a class="btn btn-warning" href="nhanvien/viewPDF" target="blank">
                <i class="fa fa-print"></i> In danh sách
              </a>
              <a class="btn btn-info" href="nhanvien/them">
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
                  <th>Họ tên</th>
                  <th>Ngày sinh</th>
                  <th>Giới tính</th>
                  <th>Số CMND</th>
                  <th>Số ĐT</th>
                  <th>Quê quán</th>
                  <th>Chuỗi bảo mật</th>
                  <th>Chức vụ</th>
                  <th>Lương</th>
                  <th>Ảnh</th>
                  <th>Sửa</th>
                  <th>Xóa</th>
                  <th>In</th>
                </tr>
              </thead>
              <tbody>
               @foreach($nhanvien as $nhanvien)
               <tr>
                <td>{{ $nhanvien->id }}</td>
                <td>{{ $nhanvien->hoten }}</td>
                <td>{{ date('d-m-Y',strtotime($nhanvien->ngaysinh)) }}</td>
                <td>{{ $nhanvien->gioitinh }}</td>
                <td>{{ $nhanvien->socmnd }}</td>
                <td>{{ $nhanvien->sodienthoai }}</td>
                <td>{{ $nhanvien->quequan }}</td>
                <td>{{ $nhanvien->chuoibaomat }}</td>
                <td>{{ $nhanvien->tenchucvu }}</td>
                <td>{{ number_format($nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap, 0, '', '.') }}</td>
                <td>
                  <a href="uploads/user/{{ $nhanvien->img }}" target="blank"><img src="uploads/user/{{ $nhanvien->img }}" width="60" height="60"></a>
                </td>
                <td>
                 <a class="btn btn-success" href="nhanvien/sua/{{ $nhanvien->id }}">
                  <i class="fa fa-edit"></i>
                </a>
              </td>
              <td>
                <button class="btn btn-danger" onclick="Delete({{ $nhanvien->id }});"><i class="fa fa-trash"></i></button>
            </td>
             <td>
                 <a class="btn btn-warning" href="nhanvien/in/{{ $nhanvien->id }}" target="blank">
                  <i class="fa fa-print"></i>
                </a>
              </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>Số CMND</th>
            <th>Số ĐT</th>
            <th>Quê quán</th>
            <th>Chuỗi bảo mật</th>
            <th>Chức vụ</th>
            <th>Lương</th>
            <th>Ảnh</th>
            <th>Sửa</th>
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
      // 'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      // 'autoWidth'   : true
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