@extends('layout.index')

@section('css')

@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Chi tiết nhập phụ tùng
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li class="active">Sửa chi tiết nhập phụ tùng</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Form -->
    <form action="nhapphutungphukien/{{ $id_nhapphutungphukien }}/suachitietphutung/{{ $chitietnhapphutung->id }}" method="post" enctype="application/x-www-form-urlencoded">
      @csrf
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Mã nhập phụ tùng - phụ kiện: {{ $id_nhapphutungphukien }}</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <!-- select -->
              <div class="form-group">
                <label>Chọn phụ tùng</label>
                <select class="form-control" name="id_phutung" onchange="chonPhuTung(this.value);">
                  <option value="">Chọn</option>
                  @foreach($phutung as $phutung)
                  @if($phutung->id == $chitietnhapphutung->id_phutung)
                  <option value="{{ $phutung->id }}" selected="">{{ $phutung->tenphutung }} - {{ $phutung->loaixe }}</option>
                  @else
                  <option value="{{ $phutung->id }}">{{ $phutung->tenphutung }} - {{ $phutung->loaixe }}</option>
                  @endif
                  @endforeach
                </select>
                <input type="hidden" value="{{ $chitietnhapphutung->id_thongtinphutung }}" id="inputhidden">
                </div>
                <div class="form-group">
                  <label>Số lượng</label>
                  <input type="number" class="form-control" placeholder="Nhập số lượng" name="soluong" value="{{ $chitietnhapphutung->soluongnhap }}">
                </div>
                <div class="form-group">
                  <label>Giá nhập</label>
                  <input type="number" class="form-control" placeholder="Nhập giá" name="gianhap" value="{{ $chitietnhapphutung->gianhap }}">
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6" id="showImg">
              <div class="form-group">
                <label>Hình ảnh phụ tùng</label>
                <img src="uploads/phutung/{{ $phutungtheoid->imgphutung}}" id="profile-img-tag" style="display: block; margin-left: auto; margin-right: auto;" width="300px">                                        
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Lưu lại</button>
          <a href="chitietnhapphutungphukien/{{ $id_nhapphutungphukien }}"><button type="button" class="btn btn-danger">Hủy bỏ</button></a>
        </div>
      </div>
    </form>
    <!-- /Form -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('script')
<script>
  var inputhidden = document.getElementById('inputhidden');
  chonPhuTung(inputhidden.value);
    </script>
    <script>
   function chonPhuTung(id_phutung){
          if (id_phutung == "") {
          document.getElementById("showImg").innerHTML = "";
          return;
        }
        if (window.XMLHttpRequest) {
            // Cho IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // Cho IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showImg").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "ajax/getImgPhuTungBangPhuTung/" + id_phutung, true);
        xmlhttp.send();
  }
</script>
    @endsection