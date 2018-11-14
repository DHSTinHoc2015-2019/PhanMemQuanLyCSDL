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
      <b>THỐNG KÊ HÓA ĐƠN BÁN XE MÁY THEO QUÝ</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li>Thống kê hóa đơn bán xe máy theo quý</li>
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
              <form action="thongke/hoadonbanxemay/chonquy" method="post" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="box box-default" style="border: none;">
                  <div class="box-header with-border">
                    <h1 class="box-title"><b>Chọn</b></h1>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body with-border">
                    <div class="row">
                      <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div style="font-size: 1.3em; font-weight: bold; text-align: right;">
                          <label>
                            Chọn quý
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-2">
                      <div class="form-group">
                        <select class="form-control" name="quy" required="">
                          <option value="">Chọn</option>
                          @for ($i = 1; $i <= 4; $i++)
                              <option value="{{ $i }}">{{ $i }}</option>
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
                              <option value="{{ $i }}">{{ $i }}</option>
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
                </div>
                <!-- /.box-body -->

             </form>
           </div>
         </div>

         <!-- /.box-header -->
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
@endsection