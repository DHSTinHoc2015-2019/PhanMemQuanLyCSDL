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
        <b>Người dùng</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="user">User</a></li>
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
                  <a class="btn btn-info" href="user/them">
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
                  <th>Tên đăng nhập</th>
                  <th>Email</th>
                  <th>Chức vụ</th>
                  <th>Quyền</th>
                  <th>Chỉnh sửa - Xóa - Reset Password</th>
                </tr>
                </thead>
                <tbody>
               @foreach($user as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->tenchucvu }}</td>
                  <td>{{ $user->quyen }}</td>
                  <td>
                     <a class="btn btn-success" href="user/sua/{{ $user->id }}">
                      <i class="fa fa-edit"></i> Chỉnh sửa
                    </a>
                    <a class="btn btn-danger" href="user/xoa/{{ $user->id }}">
                      <i class="fa fa-times"></i> Xóa
                    </a>
                    <a class="btn btn-primary" href="user/resetpassword/{{ $user->id }}">
                      <i class="fa fa-times"></i> Reset Password
                    </a>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Tên đăng nhập</th>
                  <th>Email</th>
                  <th>Chức vụ</th>
                  <th>Quyền</th>
                  <th>Chỉnh sửa - Xóa - Reset Password</th>
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
@endsection