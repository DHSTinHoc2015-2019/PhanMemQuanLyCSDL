
@extends('layout.index')

@section('css')
  
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1>
      <b>THỐNG KÊ HÓA ĐƠN BÁN XE MÁY THÁNG {{ $thang }} NĂM {{ $nam }}</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
      <li>Thống kê hóa đơn bán xe máy tháng {{ $thang }} năm {{ $nam }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content" style="font-size: 1.2em;">
    <div class="row">
      <div class="col-md-12">
       <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><b>Chọn</b></h1>
          
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
          title="Collapse">
          <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
                <form action="thongke/hoadonbanxemay/chonthang" method="post" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="row">
                      <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div style="font-size: 1.3em; font-weight: bold; text-align: right;">
                          <label>
                            Chọn tháng
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-2">
                      <div class="form-group">
                        <select class="form-control" name="thang" required="">
                          <option value="">Chọn</option>
                          @for ($i = 1; $i <= 12; $i++)
                          @if($thang == $i)
                          <option value="{{ $i }}" selected="">{{ $i }}</option>
                          @else
                          <option value="{{ $i }}">{{ $i }}</option>
                          @endif
                          @endfor
                        </select>
                      </div>
                    </div>

                    <div class="col-md-2">
                      <div class="form-group">
                        <div style="font-size: 1.3em; font-weight: bold; text-align: right;">
                          <label>
                            Chọn năm
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-2">
                      <div class="form-group">
                        <select class="form-control" name="nam" required="">
                          <option value="">Chọn</option>
                          @for ($i = 2017; $i < 2050; $i++)
                           @if($nam == $i)
                            <option value="{{ $i }}" selected="">{{ $i }}</option>
                            @else
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                          @endfor
                        </select>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-1">
                       <button type="submit" class="btn btn-primary">THỐNG KÊ</button>
                    </div>
                    <div class="col-md-2">
                      
                    </div>
                    <!-- /.col -->

                  </div>
                  <!-- /.row -->

              </form>
            </div>
          
          </div>
        </div>
        <!-- /.box-body -->
        </div>
      <!-- /.box -->
      </div>
      <!-- /.col-md -->

      <div class="col-md-12">
       <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><b>XE MÁY BÁN THÁNG {{ $thang }} NĂM {{ $nam }} THEO TÊN XE</b></h1>
          
       <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
          title="Collapse">
          <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
          </div>
      </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
                {!! $chartThang->container() !!}
            </div>
            {!! $chartThang->script() !!}
          </div>
        </div>
        <!-- /.box-body -->
          <div class="box-footer">
           <a href="thongke/hoadonbanxemay/thanghientaitheotenxe" class="btn btn-success">Chi tiết</a>
           <div class="pull-right">
              <a class="btn btn-warning" href="hoadonbanxemay/xemThangHienTaiDanhSachTenXePDF" target="blank">
                <i class="fa fa-print"></i> In toàn bộ
              </a>
            </div>
          </div>
          <!-- /.box-footer-->
        </div>
      <!-- /.box -->
      </div>
      <!-- /.col-md -->

      <div class="col-md-12">
       <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><b>XE MÁY BÁN THÁNG {{ $thang }} NĂM {{ $nam }} THEO TỪNG NGÀY</b></h1>
          
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
          title="Collapse">
          <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
                {!! $chartThangTheoNgay->container() !!}
            </div>
            {!! $chartThangTheoNgay->script() !!}

          </div>
        </div>
        <!-- /.box-body -->
          <div class="box-footer">
           <a href="thongke/hoadonbanxemay/thanghientaitheongay" class="btn btn-success">Chi tiết</a>
           <div class="pull-right">
              <a class="btn btn-warning" href="hoadonbanxemay/xemThangHienTaiDanhSachTheoNgayPDF" target="blank">
                <i class="fa fa-print"></i> In toàn bộ
              </a>
            </div>
          </div>
          <!-- /.box-footer-->
        </div>
      <!-- /.box -->
      </div>
      <!-- /.col-md -->
    
      <div class="col-md-12">
       <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><b>DANH SÁCH XE MÁY BÁN THÁNG {{ $thang }} NĂM {{ $nam }}</b></h1>
          
       <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
          title="Collapse">
          <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
          </div>
      </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
                <table id="example" class="table table-bordered table-hover">
                <thead>
                 <tr>
                  <th>ID</th>
                  <th>Ngày bán</th>
                  <th>Tên xe</th>
                  <th>Màu xe</th>
                  <th>Đơn giá</th>
                  <th>SL</th>
                  <th>Thuế VAT</th>
                  <th>Thành tiền</th>
                  <th>Hình ảnh</th>
                  <th>Tên KH</th>
                  <th>Địa chỉ</th>
                  <th>In</th>
                </tr>
                </thead>
                <tbody>
                @foreach($hoadonbanxemay as $hoadonbanxemay)
                <tr>
                  <td>{{ $hoadonbanxemay->id }}</td>
                  <td>{{ $hoadonbanxemay->ngayban }}</td>
                  <td>{{ $hoadonbanxemay->tenxe }}</td>
                  <td>{{ $hoadonbanxemay->mauxe }}</td>
                  <td>{{ number_format($hoadonbanxemay->dongia , 0, '', '.') }}đ</td>
                  <td>{{ $hoadonbanxemay->soluong }}</td>
                  <td>{{ $hoadonbanxemay->thueVAT }}</td>
                  <td>{{ number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.') }}đ</td>
                  <td>
                    <a href="uploads/xemay/{{ $hoadonbanxemay->img }}"><img src="uploads/xemay/{{ $hoadonbanxemay->img }}" width="100" height="60"></a>
                  </td>
                  <td>{{ $hoadonbanxemay->tenkhachhang }}</td>
                  <td>{{ $hoadonbanxemay->diachi }}</td>
                   <td>
                     <a class="btn btn-warning" href="hoadonbanxemay/in/{{ $hoadonbanxemay->id }}" target="blank">
                      <i class="fa fa-print"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Ngày bán</th>
                  <th>Tên xe</th>
                  <th>Màu xe</th>
                  <th>Đơn giá</th>
                  <th>SL</th>
                  <th>Thuế VAT</th>
                  <th>Thành tiền</th>
                  <th>Hình ảnh</th>
                  <th>Tên KH</th>
                  <th>Địa chỉ</th>
                  <th>In</th>
                </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        </div>
      <!-- /.box -->
      </div>
      <!-- /.col-md -->

    </div>
    
  </section>
  <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('script')
  <script src="bower_components/charts/Chart.bundle.js" charset="utf-8"></script>
@endsection