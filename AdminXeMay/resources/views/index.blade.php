@extends('layout.index')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <center><b>WEBSITE QUẢN LÝ CỬA HÀNG HON DA XE MÁY HUY TUẤN</b></center>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <!-- <div class="box-header with-border">
          <h3 class="box-title">Title</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
            title="Collapse">
            <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
            </div>
          </div> -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-8">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner">
                <div class="item active">
                  <img src="uploads/slide/slide1.jpg" alt="Los Angeles" style="width:100%; height: 430px">
                </div>
                <div class="item">
                  <img src="uploads/slide/slide2.jpg" alt="Chicago" style="width:100%; height: 430px">
                </div>
                <div class="item">
                  <img src="uploads/slide/slide3.jpg" alt="New york" style="width:100%; height: 430px">
                </div>
              </div>

              <!-- Left and right controls -->
              <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
              </div>
              <div class="col-md-2"></div>
            </div>
          </div>
          <!-- /.box-body -->
          <!-- <div class="box-footer">
            Footer
          </div> -->
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->


    </div>
    <!-- /.content-wrapper -->
@endsection