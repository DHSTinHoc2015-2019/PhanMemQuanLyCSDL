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
      <b>Chi tiết hóa đơn bán phụ tùng - phụ kiện</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Chi tiết hóa đơn bán phụ tùng - phụ kiện</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Danh sách chi tiết nhập phụ tùng <span style="font-weight: bold; font-size: 14px;">Mã hóa đơn bán: {{ $id_banphutungphukien }}</span></h3>
            <div class="pull-right">
              <a class="btn btn-info" href="hoadonbanphutungphukien/{{ $id_banphutungphukien }}/themchitietphutung">
                <i class="fa fa-plus-square"></i> Thêm chi tiết phụ tùng
              </a>
              <a class="btn btn-info" href="hoadonbanphutungphukien/{{ $id_banphutungphukien }}/themchitietphukien">
                <i class="fa fa-plus-square"></i> Thêm chi tiết phụ kiện
              </a>
              <a class="btn btn-warning" href="hoadonbanphutungphukien/in/{{ $id_banphutungphukien }}">
                <i class="fa fa-print"></i> In hóa đơn
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
                <th>Loại xe</th>
                <th>Số lượng</th>
                <th>Giá nhập</th>
                <th>Thành tiền</th>
                <th>Hình ảnh</th>
                <th>Chỉnh sửa</th>
                <th>Xóa</th>
              </tr>
            </thead>
            <tbody>
              @foreach($chitiethoadonbanphutung as $chitiethoadonbanphutung)
              <tr>
                <td>{{ $chitiethoadonbanphutung->id }}</td>
                <td>{{ $chitiethoadonbanphutung->tenphutung }}</td>
                <td>{{ $chitiethoadonbanphutung->loaixe }}</td>
                <td>{{ $chitiethoadonbanphutung->soluongban }}</td>
                <td>{{ number_format($chitiethoadonbanphutung->dongiaban, 0, '', '.') }} đ</td>
                <td>{{ number_format($chitiethoadonbanphutung->dongiaban * $chitiethoadonbanphutung->soluongban, 0, '', '.') }} đ</td>
                <td>
                  <a href="uploads/phutung/{{ $chitiethoadonbanphutung->imgphutung }}"><img src="uploads/phutung/{{ $chitiethoadonbanphutung->imgphutung }}" width="100" height="60"></a>
                </td>
                <td>
                  <a class="btn btn-success" href="hoadonbanphutungphukien/{{ $id_banphutungphukien }}/suachitietphutung/{{ $chitiethoadonbanphutung->id }}">
                    <i class="fa fa-edit"></i> Chỉnh sửa
                  </a>
                </td>
                <td>
                  <button class="btn btn-danger" onclick="DeletePT({{ $id_banphutungphukien }},{{ $chitiethoadonbanphutung->id }});"><i class="fa fa-trash"></i> Xóa</button>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Tên phụ tùng</th>
                <th>Loại xe</th>
                <th>Số lượng</th>
                <th>Giá nhập</th>
                <th>Thành tiền</th>
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

<!-- Main content -->

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Danh sách chi tiết hóa đơn bán phụ kiện <span style="font-weight: bold; font-size: 14px;">Mã hóa đơn bán: {{ $id_banphutungphukien }}</span></h3>
          <div class="pull-right">
              <a class="btn btn-info" href="hoadonbanphutungphukien/{{ $id_banphutungphukien }}/themchitietphutung">
                <i class="fa fa-plus-square"></i> Thêm chi tiết phụ tùng
              </a>
              <a class="btn btn-info" href="hoadonbanphutungphukien/{{ $id_banphutungphukien }}/themchitietphukien">
                <i class="fa fa-plus-square"></i> Thêm chi tiết phụ kiện
              </a>
              <a class="btn btn-warning" href="hoadonbanphutungphukien/in/{{ $id_banphutungphukien }}">
                <i class="fa fa-print"></i> In hóa đơn
              </a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-hover">
            <thead>
             <tr>
              <th>ID</th>
              <th>Tên phụ kiện</th>
              <th>Tên xe</th>
              <th>Số lượng</th>
              <th>Giá bán</th>
              <th>Thành tiền</th>
              <th>Hình ảnh</th>
              <th>Chỉnh sửa</th>
              <th>Xóa</th>
            </tr>
          </thead>
          <tbody>
            @foreach($chitiethoadonbanphukien as $chitiethoadonbanphukien)
            <tr>
              <td>{{ $chitiethoadonbanphukien->id }}</td>
              <td>{{ $chitiethoadonbanphukien->tenphukien }}</td>
              <td>{{ $chitiethoadonbanphukien->tenxe }}</td>
              <td>{{ $chitiethoadonbanphukien->soluongban }}</td>
              <td>{{ number_format($chitiethoadonbanphukien->dongiaban, 0, '', '.') }} đ</td>
              <td>{{ number_format($chitiethoadonbanphukien->dongiaban * $chitiethoadonbanphukien->soluongban, 0, '', '.') }} đ</td>
              <td>
                <a href="uploads/phukien/{{ $chitiethoadonbanphukien->imgphukien }}"><img src="uploads/phukien/{{ $chitiethoadonbanphukien->imgphukien }}" width="100" height="60"></a>
              </td>
              <td>
                  <a class="btn btn-success" href="hoadonbanphutungphukien/{{ $id_banphutungphukien }}/suachitietphukien/{{ $chitiethoadonbanphukien->id }}">
                    <i class="fa fa-edit"></i> Chỉnh sửa
                  </a>
                </td>
                <td>
                  <button class="btn btn-danger" onclick="DeletePK({{ $id_banphutungphukien }},{{ $chitiethoadonbanphukien->id }});"><i class="fa fa-trash"></i> Xóa</button>
                </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>Tên phụ kiện</th>
              <th>Tên xe</th>
              <th>Số lượng</th>
              <th>Giá bán</th>
              <th>Thành tiền</th>
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
    $('#example1').DataTable({
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
  function DeletePT(id_banphutungphukien,id) {
    swal({
      title: "Bạn có chắc chắn muốn xóa dữ liệu?",
      text: "Sau khi xóa, bạn sẽ không thể phục hồi dữ liệu này!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((isConfirm) => {
      if (isConfirm) {
        window.location.href = "hoadonbanphutungphukien/" + id_banphutungphukien + "/xoachitietphutung/" + id;
      } else {
        swal("Dữ liệu của bạn không thay đổi!");
      }
    });
  }

  function DeletePK(id_banphutungphukien,id) {
    swal({
      title: "Bạn có chắc chắn muốn xóa dữ liệu?",
      text: "Sau khi xóa, bạn sẽ không thể phục hồi dữ liệu này!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((isConfirm) => {
      if (isConfirm) {
        window.location.href = "hoadonbanphutungphukien/" + id_banphutungphukien + "/xoachitietphukien/" + id;
      } else {
        swal("Dữ liệu của bạn không thay đổi!");
      }
    });
  }
</script>
@endsection