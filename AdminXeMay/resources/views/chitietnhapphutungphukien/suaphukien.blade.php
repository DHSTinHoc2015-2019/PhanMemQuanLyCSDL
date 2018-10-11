@extends('layout.index')

@section('css')

@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Chi tiết nhập phụ kiện
      <small>Sửa</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li class="active">Thêm chi tiết nhập phụ kiện</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Form -->
    <form action="nhapphutungphukien/{{ $id_nhapphutungphukien }}/suachitietphukien/{{ $chitietnhapphukien->id }}" method="post" enctype="application/x-www-form-urlencoded">
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
                <label>Chọn phụ kiện</label>
                <select class="form-control" name="id_phukien" onchange="chonPhuKien(this.value);" required="">
                  <option value="">Chọn</option>
                  @foreach($phukien as $phukien)
                  @if($phukien->id == $chitietnhapphukien->id_phukien)
                  <option value="{{ $phukien->id }}" selected="">{{ $phukien->tenphukien }} - {{ $phukien->tenxe }}</option>
                  @else
                  <option value="{{ $phukien->id }}">{{ $phukien->tenphukien }} - {{ $phukien->tenxe }}</option>
                  @endif
                  @endforeach
                </select>
                <div class="form-group">
                  <label>Số lượng</label>
                  <input type="number" class="form-control" placeholder="Nhập số lượng" name="soluong" value="{{ $chitietnhapphukien->soluongnhap }}">
                </div>
                <div class="form-group">
                  <label>Giá nhập</label>
                  <input type="number" class="form-control" placeholder="Nhập giá" name="gianhap" value="{{ $chitietnhapphukien->gianhap }}">
                </div>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6" id="showImg">
              <div class="form-group">
               <div class="form-group">
                <label>Hình ảnh phụ kiện</label>
                <img src="uploads/phukien/{{ $phukientheoid->imgphukien }}" id="profile-img-tag" style="display: block; margin-left: auto; margin-right: auto;" width="300px">
              </div>                                      
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
   function chonPhuKien(id_phukien){
    console.log(id_phukien);
          if (id_phukien == "") {
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
        xmlhttp.open("GET", "ajax/getImgPhuKienBangPhuKien/" + id_phukien, true);
        xmlhttp.send();
  }
</script>
@endsection