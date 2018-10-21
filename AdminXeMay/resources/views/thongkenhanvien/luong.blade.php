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
      <b>Thống kê lương nhân viên</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Thống kê lương nhân viên</li>
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
              <form action="thongke/nhanvien/luong" method="post" enctype="application/x-www-form-urlencoded">
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
                    <div class="col-md-2">
                      <div class="form-group">
                        <div style="font-size: 1.3em; font-weight: bold;">
                          <label>
                            Chọn lương từ
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-2">
                      <div class="form-group">
                        <select class="form-control" name="luongtu">
                          <option value="">Chọn</option>
                          @for ($i = 1; $i < 100; $i++)
                              <option value="{{ $i * 1000000}}">{{ $i }}.000.000</option>
                          @endfor
                        </select>
                      </div>
                    </div>

                    <div class="col-md-1">
                      <div class="form-group">
                        <div style="font-size: 1.3em; font-weight: bold;">
                          <label>
                            Đến
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-2">
                      <div class="form-group">
                        <select class="form-control" name="luongden">
                          <option value="">Chọn</option>
                          @for ($i = 1; $i < 100; $i++)
                              <option value="{{ $i * 1000000}}">{{ $i }}.000.000</option>
                          @endfor
                        </select>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-1">
                       <button type="submit" class="btn btn-primary">THỐNG KÊ</button>
                    </div>
                    <div class="col-md-4">
                      <div class="pull-right">
                         @if(!empty($sum))
                        <a class="btn btn-warning" href="nhanvien/xemThongKeLuongPDF" target="blank">
                          <i class="fa fa-print"></i> In danh sách
                        </a>
                        @endif
                        <a class="btn btn-warning" href="nhanvien/xemThongKeToanBoLuongPDF" target="blank">
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
                <th>Chức vụ</th>
                <th>Phụ cấp</th>
                <th>Lương</th>
                <th>Ảnh</th>
                <th>In</th>
              </tr>
            </thead>
            <tbody>
             @foreach($nhanvien as $nhanvien)
             <tr>
              <td>{{ $nhanvien->id }}</td>
              <td>{{ $nhanvien->hoten }}</td>
              <td>{{ $nhanvien->ngaysinh }}</td>
              <td>{{ $nhanvien->gioitinh }}</td>
              <td>{{ $nhanvien->socmnd }}</td>
              <td>{{ $nhanvien->sodienthoai }}</td>
              <td>{{ $nhanvien->quequan }}</td>
              <td>{{ $nhanvien->tenchucvu }}</td>
              <td>{{ $nhanvien->phucap }}</td>
              <td>{{ number_format($nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap, 0, '', '.') }}</td>
              <td>
                <a href="uploads/user/{{ $nhanvien->img }}" target="blank"><img src="uploads/user/{{ $nhanvien->img }}" width="100" height="60"></a>
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
          <th>Chức vụ</th>
          <th>Phụ cấp</th>
          <th>Lương</th>
          <th>Ảnh</th>
          <th>In</th>
        </tr>
      </tfoot>
    </table>
    <div class="col-md-10">
        @if(!empty($sum))
      <p style="font-size: 1.5em; color: red;">Tổng số lượng nhân viên: {{ $sum }} <br> Chiếm tỉ lệ {{ $tile }}% tổng số nhân viên</p>
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