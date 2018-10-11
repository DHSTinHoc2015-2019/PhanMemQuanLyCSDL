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
      <b>Xe máy</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li><a href="xemay">Xe máy</a></li>
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
               <a class="btn btn-warning" href="xemay/viewPDF" target="blank">
                <i class="fa fa-print"></i> In danh sách
              </a>
              <a class="btn btn-info" href="xemay/them">
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
                  <th>Sửa</th>
                  <th>Xóa</th>
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
                 <a class="btn btn-success" href="xemay/sua/{{ $xemay->id }}">
                  <i class="fa fa-edit"></i> 
                </a>
              </td>
              <td>
               <button class="btn btn-danger" onclick="Delete({{ $xemay->id }});"><i class="fa fa-times"></i></button>
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
        window.location.href = "xemay/xoa/" + id;
      } else {
        swal("Dữ liệu của bạn không thay đổi!");
      }
    });
  }
</script>
@endsection