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
      <b>Chi tiết nhập phụ tùng - phụ kiện</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li><a href="chitietnhapphutungphukien/{{ $id_nhapphutungphukien }}">Nhập chi tiết nhập phụ tùng - phụ kiện</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Danh sách chi tiết nhập phụ tùng <span style="font-weight: bold; font-size: 14px;">Mã nhập: {{ $id_nhapphutungphukien }}</span></h3>
            <div class="pull-right">
              <a class="btn btn-info" href="nhapphutungphukien/{{ $id_nhapphutungphukien }}/themchitietphutung">
                <i class="fa fa-plus-square"></i> Thêm chi tiết phụ tùng
              </a>
              <a class="btn btn-info" href="nhapphutungphukien/{{ $id_nhapphutungphukien }}/themchitietphukien">
                <i class="fa fa-plus-square"></i> Thêm chi tiết phụ kiện
              </a>
              <a class="btn btn-warning" href="nhapphutungphukien/in/{{ $id_nhapphutungphukien }}">
                <i class="fa fa-print"></i> In phiếu nhập
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
              @foreach($chitietnhapphutung as $chitietnhapphutung)
              <tr>
                <td>{{ $chitietnhapphutung->id }}</td>
                <td>{{ $chitietnhapphutung->tenphutung }}</td>
                <td>{{ $chitietnhapphutung->loaixe }}</td>
                <td>{{ $chitietnhapphutung->soluongnhap }}</td>
                <td>{{ number_format($chitietnhapphutung->gianhap, 0, '', '.') }} đ</td>
                <td>{{ number_format($chitietnhapphutung->gianhap * $chitietnhapphutung->soluongnhap, 0, '', '.') }} đ</td>
                <td>
                  <a href="uploads/phutung/{{ $chitietnhapphutung->imgphutung }}"><img src="uploads/phutung/{{ $chitietnhapphutung->imgphutung }}" width="100" height="60"></a>
                </td>
                <td>
                  <a class="btn btn-success" href="nhapphutungphukien/{{ $id_nhapphutungphukien }}/suachitietphutung/{{ $chitietnhapphutung->id }}">
                    <i class="fa fa-edit"></i> Chỉnh sửa
                  </a>
                </td>
                <td>
                  <button class="btn btn-danger" onclick="DeletePT({{ $id_nhapphutungphukien }},{{ $chitietnhapphutung->id }});"><i class="fa fa-trash"></i> Xóa</button>
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
          <h3 class="box-title">Danh sách chi tiết nhập phụ kiện <span style="font-weight: bold; font-size: 14px;">Mã nhập: {{ $id_nhapphutungphukien }}</span></h3>
          <div class="pull-right">
              <a class="btn btn-info" href="nhapphutungphukien/{{ $id_nhapphutungphukien }}/themchitietphutung">
                <i class="fa fa-plus-square"></i> Thêm chi tiết phụ tùng
              </a>
              <a class="btn btn-info" href="nhapphutungphukien/{{ $id_nhapphutungphukien }}/themchitietphukien">
                <i class="fa fa-plus-square"></i> Thêm chi tiết phụ kiện
              </a>
              <a class="btn btn-warning" href="nhapphutungphukien/in/{{ $id_nhapphutungphukien }}">
                <i class="fa fa-print"></i> In phiếu nhập
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
              <th>Giá nhập</th>
              <th>Thành tiền</th>
              <th>Hình ảnh</th>
              <th>Chỉnh sửa</th>
              <th>Xóa</th>
            </tr>
          </thead>
          <tbody>
            @foreach($chitietnhapphukien as $chitietnhapphukien)
            <tr>
              <td>{{ $chitietnhapphukien->id }}</td>
              <td>{{ $chitietnhapphukien->tenphukien }}</td>
              <td>{{ $chitietnhapphukien->tenxe }}</td>
              <td>{{ $chitietnhapphukien->soluongnhap }}</td>
              <td>{{ number_format($chitietnhapphukien->gianhap, 0, '', '.') }} đ</td>
              <td>{{ number_format($chitietnhapphukien->gianhap * $chitietnhapphukien->soluongnhap, 0, '', '.') }} đ</td>
              <td>
                <a href="uploads/phukien/{{ $chitietnhapphukien->imgphukien }}"><img src="uploads/phukien/{{ $chitietnhapphukien->imgphukien }}" width="100" height="60"></a>
              </td>
              <td>
                  <a class="btn btn-success" href="nhapphutungphukien/{{ $id_nhapphutungphukien }}/suachitietphukien/{{ $chitietnhapphukien->id }}">
                    <i class="fa fa-edit"></i> Chỉnh sửa
                  </a>
                </td>
                <td>
                  <button class="btn btn-danger" onclick="DeletePK({{ $id_nhapphutungphukien }},{{ $chitietnhapphukien->id }});"><i class="fa fa-trash"></i> Xóa</button>
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
  function DeletePT(id_nhapphutungphukien,id) {
    swal({
      title: "Bạn có chắc chắn muốn xóa dữ liệu?",
      text: "Sau khi xóa, bạn sẽ không thể phục hồi dữ liệu này!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((isConfirm) => {
      if (isConfirm) {
        window.location.href = "nhapphutungphukien/" + id_nhapphutungphukien + "/xoachitietphutung/" + id;
      } else {
        swal("Dữ liệu của bạn không thay đổi!");
      }
    });
  }

  function DeletePK(id_nhapphutungphukien,id) {
    swal({
      title: "Bạn có chắc chắn muốn xóa dữ liệu?",
      text: "Sau khi xóa, bạn sẽ không thể phục hồi dữ liệu này!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((isConfirm) => {
      if (isConfirm) {
        window.location.href = "nhapphutungphukien/" + id_nhapphutungphukien + "/xoachitietphukien/" + id;
      } else {
        swal("Dữ liệu của bạn không thay đổi!");
      }
    });
  }
</script>
@endsection