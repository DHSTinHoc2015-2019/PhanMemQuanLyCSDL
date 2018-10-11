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
        <b>Tìm kiếm khách hàng</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="khachhang">Tìm kiếm khách hàng</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <!-- <button class="btn btn-info" style="font-size: 1.2em;" type="button" onclick="tatCaAnd()">Tất cả <b>AND</b></button>
            <button class="btn btn-info" style="font-size: 1.2em;" type="button" onclick="tatCaOr()">Tất cả <b>OR</b></button> -->
            <div class="pull-right">
              @if(!Session::has('querySearchKhachHang'))
              <a class="btn btn-warning" href="khachhang/viewPDF" target="blank">
                <i class="fa fa-print"></i> In danh sách
              </a>
              @else
              <a class="btn btn-warning" href="khachhang/viewSearchPDF" target="blank">
                <i class="fa fa-print"></i> In danh sách
              </a>
              @endif
            </div>
            <div class="col-xs-12">
              <!-- Form -->
              <form action="timkiem/khachhang" method="post" enctype="application/x-www-form-urlencoded">
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
                          <label>Theo họ tên</label>
                          <input type="text" class="form-control" placeholder="Nhập họ tên" name="tenkhachhang">
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-md-1">
                         <!--  <div class="form-check" style="margin-top: 1em;">
                            <input class="form-check-input" type="radio" name="radio1" id="radio11" value="AND" checked>
                            <label class="form-check-label">
                              AND
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio1" id="radio12" value="OR">
                            <label class="form-check-label">
                              OR
                            </label>
                          </div> -->
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Theo giới tính</label>
                          <select class="form-control" name="gioitinh">
                            <option value="">Chọn</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                          </select>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-md-1">
                        <!-- <div class="form-check" style="margin-top: 1em;">
                          <input class="form-check-input" type="radio" name="radio2" id="radio21" value="AND" checked>
                          <label class="form-check-label">
                            AND
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="radio2" id="radio22" value="OR">
                          <label class="form-check-label">
                            OR
                          </label>
                        </div> -->
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                         <label>Theo địa chỉ</label>
                          <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="diachi">
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-md-1">
                        <!-- <div class="form-check" style="margin-top: 1em;">
                          <input class="form-check-input" type="radio" name="radio3" id="radio31" value="AND" checked>
                          <label class="form-check-label">
                            AND
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="radio3" id="radio32" value="OR">
                          <label class="form-check-label">
                            OR
                          </label>
                        </div> -->
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Theo năm sinh từ</label>
                          <select class="form-control" name="namsinhtu">
                            <option value="">Chọn</option>
                            @for ($i = 1975; $i < 2020; $i++)
                              <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                          </select>
                          <label>đến</label>
                          <select class="form-control" name="namsinhden">
                            <option value="">Chọn</option>
                            @for ($i = 1975; $i < 2020; $i++)
                              <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                      <!-- /.col -->                     
                      <div class="col-md-1"></div>

                    </div>


                    <!-- /.row -->
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer" style="border: none;">
                   <center> 
                    <button type="submit" class="btn btn-primary btn-lg" value="AND" name="AND">AND</button>
                    <button type="submit" class="btn btn-primary btn-lg" value="OR" name="OR">&nbsp;OR&nbsp;</button>
                  </center>
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
                  <th>Địa chỉ</th>
                  <th>Số ĐT</th>
                  <th>In</th>
                </tr>
                </thead>
                <tbody>
               @foreach($khachhang as $khachhang)
                <tr>
                  <td>{{ $khachhang->id }}</td>
                  <td>{{ $khachhang->tenkhachhang }}</td>
                  <td>{{ date('d-m-Y',strtotime($khachhang->ngaysinh)) }}</td>
                  <td>{{ $khachhang->gioitinh }}</td>
                  <td>{{ $khachhang->soCMND }}</td>
                  <td>{{ $khachhang->diachi }}</td>
                  <td>{{ $khachhang->sodienthoai }}</td>
                  <td>
                     <a class="btn btn-warning" href="khachhang/in/{{ $khachhang->id }}">
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
                  <th>Địa chỉ</th>
                  <th>Số ĐT</th>
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
  <!-- <script>
  var radio11 = document.getElementById('radio11');
  var radio12 = document.getElementById('radio12');
  var radio21 = document.getElementById('radio21');
  var radio22 = document.getElementById('radio22');
  var radio31 = document.getElementById('radio31');
  var radio32 = document.getElementById('radio32');
  function tatCaAnd(){
    radio11.checked = true;
    radio21.checked = true;
    radio31.checked = true;
  } 

  function tatCaOr(){
    radio12.checked = true;
    radio22.checked = true;
    radio32.checked = true;
  }
</script> -->
@endsection