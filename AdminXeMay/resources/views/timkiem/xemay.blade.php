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
      <b>Tìm kiếm xe máy</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li><a href="xemay">Tìm kiếm xe máy</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <div class="pull-right">
              @if(!Session::has('querySearchXeMay'))
              <a class="btn btn-warning" href="xemay/viewPDF" target="blank">
                <i class="fa fa-print"></i> In danh sách
              </a>
              @else
              <a class="btn btn-warning" href="xemay/viewSearchPDF" target="blank">
                <i class="fa fa-print"></i> In danh sách
              </a>
              @endif
            </div>
            <div class="col-xs-12">
              <!-- Form -->
              <form action="timkiem/xemay" method="post" enctype="application/x-www-form-urlencoded">
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
                      <div class="col-md-12">
                       <!-- <div class="form-group">
                        <button class="btn btn-info" style="font-size: 1.2em;" type="button" onclick="tatCaAnd()">Tất cả <b>AND</b></button>
                        <button class="btn btn-info" style="font-size: 1.2em;" type="button" onclick="tatCaOr()">Tất cả <b>OR</b></button>
                      </div> -->
                    </div>
                    <div class="col-md-3">
                      <!-- <div class="form-group">
                        <div style="font-size: 1.5em; font-weight: bold;">
                          <label>
                            <input type="checkbox" style="transform: scale(1.5);" onclick="theoTenXe()" id="theotenxe">&nbsp; Theo tên xe
                          </label>
                        </div>
                      </div> -->
                      <div class="form-group" id="grouptheotenxe">
                        <label>Theo tên xe</label>
                        <input type="text" class="form-control" placeholder="Nhập tên xe" name="tenxe">
                      </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-1">
                      <!-- <div id="mdMau">
                        <div class="form-check" style="margin-top: 4em;">
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
                        </div>
                      </div> -->
                    </div>
                    <div class="col-md-3">
                      <!-- <div class="form-group">
                        <div style="font-size: 1.5em; font-weight: bold;">
                          <label>
                            <input type="checkbox" style="transform: scale(1.5);" onclick="theoMauXe()" id="theomauxe">&nbsp;&nbsp;Theo màu xe
                          </label>
                        </div>
                      </div> -->
                      <div class="form-group" id="grouptheomauxe">
                        <label>Theo màu xe</label>
                        <input type="text" class="form-control" placeholder="Nhập màu xe" name="mauxe">
                      </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-1">
                     <!--  <div id="mdGia">
                        <div class="form-check" style="margin-top: 4em;">
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
                        </div>
                      </div> -->
                    </div>
                    <div class="col-md-3">
                     <!--  <div class="form-group">
                        <div style="font-size: 1.5em; font-weight: bold;">
                          <label>
                            <input type="checkbox" style="transform: scale(1.5);" onclick="theoDonGiaBan()" id="theodongiaban"> &nbsp;Theo giá
                          </label>
                        </div>
                      </div>  -->
                        <div class="form-group">
                           <label>Theo giá bán từ</label>
                           <select class="form-control" name="dongiaban">
                            <option value="">Chọn</option>
                            @for ($i = 5; $i < 500; $i++)
                              <option value="{{ $i * 1000000 }}">{{ $i }} triệu</option>
                            @endfor
                          </select>
                        </div>
                        <div class="form-group">
                          <label>đến</label>
                          <select class="form-control" name="dongiabanden">
                            <option value="">Chọn</option>
                            @for ($i = 5; $i < 500; $i++)
                              <option value="{{ $i * 1000000 }}">{{ $i }} triệu</option>
                            @endfor
                          </select>
                        </div>
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
           <div class="pull-right">
           </div>
         </div>

         <!-- /.box-header -->
         <div class="box-body">
          <table id="example" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tên xe</th>
                <th>Màu xe</th>
                <th>Đơn giá bán</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Dung tích</th>
                <th>Loại bảo hành</th>
                <th>Năm sản xuất</th>
                <th>Hình ảnh</th>
                <th>In</th>
              </tr>
            </thead>
            <tbody>
             @foreach($xemay as $xemay)
             <tr>
              <td>{{ $xemay->id }}</td>
              <td>{{ $xemay->tenxe }}</td>
              <td>{{ $xemay->mauxe }}</td>
              <td>{{ number_format($xemay->dongia, 0, '', '.') }} đ</td>
              <td>{{ $xemay->soluong }}</td>
              <td>{{ number_format($xemay->dongia * $xemay->soluong, 0, '', '.') }} đ</td>
              <td>{{ $xemay->dungtichxylanh }}</td>
              <td>{{ $xemay->tenloaibaohanh }}</td>
              <td>{{ $xemay->namsanxuat }}</td>
              <td>
                <a href="uploads/xemay/{{ $xemay->img }}" target="blank"><img src="uploads/xemay/{{ $xemay->img }}" width="100" height="60"></a>
              </td>
              <td>
              <a class="btn btn-warning" href="xemay/in/{{ $xemay->id }}" target="blank">
                <i class="fa fa-print"></i>
              </a>
            </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
             <th>ID</th>
                <th>Tên xe</th>
                <th>Màu xe</th>
                <th>Đơn giá bán</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Dung tích</th>
                <th>Loại bảo hành</th>
                <th>Năm sản xuất</th>
                <th>Hình ảnh</th>
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
  });
  function Delete(id) {
    swal({
      title: "Bạn có chắc chắn muốn xóa dữ liệu?",
      text: "Sau khi xóa, bạn sẽ không thể phục hồi dữ liệu này!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((isConfirm) => {
      if (isConfirm) {
        window.location.href = "xemay/xoa/" + id;
      } else {
        swal("Dữ liệu của bạn không thay đổi!");
      }
    });
  };
//   var radio11 = document.getElementById('radio11');
//   var radio12 = document.getElementById('radio12');
//   var radio21 = document.getElementById('radio21');
//   var radio22 = document.getElementById('radio22');
//   function tatCaAnd(){
//     radio11.checked = true;
//     radio21.checked = true;
//   } 

//   function tatCaOr(){
//     radio12.checked = true;
//     radio22.checked = true;
//   }
//   var mdGia = document.getElementById('mdGia');
//   var mdMau = document.getElementById('mdMau');
//   mdGia.style.display = 'none';
//   mdMau.style.display = 'none';
//   var grouptheotenxe = document.getElementById('grouptheotenxe');
//   var grouptheomauxe = document.getElementById('grouptheomauxe');
//   var grouptheodongiaban = document.getElementById('grouptheodongiaban');
//   grouptheotenxe.style.display = 'none';
//   grouptheomauxe.style.display = 'none';
//   grouptheodongiaban.style.display = 'none';
//   function theoTenXe(){
//     var theotenxe = document.getElementById('theotenxe');
//     if(theotenxe.checked){
//       grouptheotenxe.style.display = '';
//       if(theomauxe.checked){
//         mdMau.style.display = '';
//       }else{
//         mdMau.style.display = 'none';
//       }
//       if(theodongiaban.checked){
//         mdGia.style.display = '';
//       }else{
//         mdGia.style.display = 'none';
//       }
//     }else{
//      grouptheotenxe.style.display = 'none';
//      grouptheotenxe.childNodes[3].value = "";
//      mdMau.style.display = 'none';
//      if(theomauxe.checked && theodongiaban.checked){
//       mdGia.style.display = '';
//     }else{
//       mdGia.style.display = 'none';
//     }
//   }
// }
// function theoMauXe(){
//   var theomauxe = document.getElementById('theomauxe');
//   if(theomauxe.checked){
//     grouptheomauxe.style.display = '';
//     if(theotenxe.checked){
//       mdMau.style.display = '';
//     }else{
//       mdMau.style.display = 'none';
//     }
//     if(theodongiaban.checked){
//       mdGia.style.display = '';
//     } else {
//       mdGia.style.display = 'none';
//     }
//   }else{
//    grouptheomauxe.style.display = 'none';
//    grouptheomauxe.childNodes[3].value = "";
//    mdMau.style.display = 'none';
//    if(theotenxe.checked && theodongiaban.checked){
//      mdGia.style.display = '';
//    } else {
//     mdGia.style.display = 'none';
//   }
// }
// }
// function theoDonGiaBan(){
//   var theodongiaban = document.getElementById('theodongiaban');
//   if(theodongiaban.checked){
//     grouptheodongiaban.style.display = '';
//     if(theomauxe.checked || theotenxe.checked){
//       mdGia.style.display = '';
//     }else{
//      mdGia.style.display = 'none';
//    }
//  }else{
//    grouptheodongiaban.style.display = 'none';
//    grouptheodongiaban.childNodes[3].value = "";
//    mdGia.style.display = 'none';
//  }
// }
</script>
@endsection