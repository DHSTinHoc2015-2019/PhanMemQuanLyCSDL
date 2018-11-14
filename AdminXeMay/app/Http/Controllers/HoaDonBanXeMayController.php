<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HoaDonBanXeMay;
use App\KhachHang;
use App\XeMay;
use Auth;
use DateTime;
use PDF;
use DB;
use Session;
use Carbon\Carbon;
use Charts;
use App\Charts\HoaDonXeMay_Chart;

class HoaDonBanXeMayController extends Controller
{
    function index(){
    	$hoadonbanxemay = HoaDonBanXeMay::danhSachHoaDonXeMay();
    	return view('hoadonbanxemay.danhsach', compact('hoadonbanxemay'));
    }

	function getThem(){
		$xemay = XeMay::all();
		$khachhang = KhachHang::orderBy('id', 'desc')->get();
		return view('hoadonbanxemay.them', compact('xemay', 'khachhang'));
	}

	function postThem(Request $request){
		$hoadonbanxemay = new HoaDonBanXeMay();
        $hoadonbanxemay->id_khachhang = $request->id_khachhang;
        $hoadonbanxemay->id_nhanvien = Auth::User()->id;
        $hoadonbanxemay->id_xemay = $request->id_xemay;
        $hoadonbanxemay->dongiaban = $request->dongiaban;
        $hoadonbanxemay->soluong = $request->soluong;
        $hoadonbanxemay->thueVAT = $request->thueVAT;
        $hoadonbanxemay->save();
        $xemay = XeMay::findOrFail($request->id_xemay);
        $xemay->soluong = $xemay->soluong - $request->soluong;
        $xemay->save();
        return redirect('hoadonbanxemay')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function getSua($id){
    	$hoadonbanxemay = HoaDonBanXeMay::findOrFail($id);
    	$xemay = XeMay::all();
    	$xemay1 = XeMay::select('mauxe','img', 'dongia')->where('id', $hoadonbanxemay->id_xemay)->first();
		$khachhang = KhachHang::orderBy('id', 'desc')->get();
		return view('hoadonbanxemay.sua', compact('hoadonbanxemay', 'xemay', 'xemay1','khachhang'));
	}

	function postSua(Request $request, $id){
		$hoadonbanxemay = HoaDonBanXeMay::findOrFail($id);
        $hoadonbanxemay->id_khachhang = $request->id_khachhang;
        $hoadonbanxemay->id_nhanvien = Auth::User()->id;
        $hoadonbanxemay->id_xemay = $request->id_xemay;
        $hoadonbanxemay->dongiaban = $request->dongiaban;
        $hoadonbanxemay->soluong = $request->soluong;
        $hoadonbanxemay->thueVAT = $request->thueVAT;
        $hoadonbanxemay->save();
        return redirect('hoadonbanxemay/')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
        $hoadonbanxemay = HoaDonBanXeMay::findOrFail($id);
        $hoadonbanxemay->delete();
        $xemay = XeMay::findOrFail($hoadonbanxemay->id_xemay);
        $xemay->soluong = $xemay->soluong + $hoadonbanxemay->soluong;
        $xemay->save();
        return redirect('hoadonbanxemay/')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
    }

    function getViewPDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html());
        return $pdf->stream();
    }

    function data_to_html(){
        $hoadonbanxemay = HoaDonBanXeMay::danhSachHoaDonXeMay();
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
			                  <th>Tên KH</th>
			                  <th>Địa chỉ</th>
			                  <th>Tên xe</th>
			                  <th>Màu xe</th>
			                  <th>Đơn giá</th>
			                  <th>SL</th>
			                  <th>Thuế VAT</th>
			                  <th>Thành tiền</th>
			                  <th>Hình ảnh</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td><img src="uploads/xemay/'.$hoadonbanxemay->img.'" width="100" height="60"></td>
                        </tr>';
                    }

                    $output .= '
                    </tbody>
                </table>
            </body>
            </html>';
        return $output;
    }

    function getIn($id){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_In($id));
        return $pdf->stream();
    }

    function data_to_html_In($id){
        $hoadon = HoaDonBanXeMay::DanhSachHoaDonXeMayTheoID($id);
        $output = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Hóa đơn bán xe máy</title>
            <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
            <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
        </head>
        <body>
            <img src="uploads/img/logohonda.png" alt="" width="80" height=80" style="position: absolute;">
            <h3 style="margin-left: 150px; color: green; padding-bottom: 0px">HÓA ĐƠN GIÁ TRỊ GIA TĂNG<span style="color: black;">'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Mẫu số: 01GTKT3/002</span></h3>
            <p style="margin-left: 250px;"><i>Liên 1: Lưu</i>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Ký hiệu: BM/15</p>
            <p style="margin-left: 200px;"><i>Ngày .....tháng......năm 20....</i>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Số phiếu: </p>
            <hr>

            <p style="margin-left: 50px;">Đơn vị bán hàng:'."&emsp;".'<b>CÔNG TY TNHH THƯƠNG MẠI TỔNG HỢP HUY TUẤN</b></p>
            <p style="margin-left: 50px;">Mã số thuế:'."&emsp;".'...........................................................................................................................................</p>
            <p style="margin-left: 50px;">Địa chỉ:'."&emsp;".'40-42 An Dương Vương - Phường An Cựu - TP Huế - Tỉnh Thừa Thiên Huế</p>
            <p style="margin-left: 50px;">Số điện thoại:'."&emsp;".'0234.3813380</p>
            <p style="margin-left: 50px;">Số tài khoản:'."&emsp;".'114000096929 Chi nhánh Ngân hàng TMCP Công thương Nam Thừa Thiên Huế</p>
            <hr>
            <p style="margin-left: 50px;">Họ và tên người mua hàng:'."&emsp;".'<i>'.$hoadon->tenkhachhang.'</i></p>
            <p style="margin-left: 50px;">Đơn vị:'."&emsp;".'..................................................................................................................................................</p>
            <p style="margin-left: 50px;">Mã số thuế:'."&emsp;".'...........................................................................................................................................</p>
            <p style="margin-left: 50px;">Địa chỉ:'."&emsp;".'<i>'.$hoadon->diachi.'</i></p>
            <p style="margin-left: 50px;">Hình thức thanh toán:'."&emsp;".'.....................Số tài khoản...................................................................................</p>
            <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>STT</th>
                          <th>Tên hàng hóa - dịch vụ</th>
                          <th>Đơn vị tính</th>
                          <th>Số lượng</th>
                          <th>Đơn giá</th>
                          <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>';
                   
                    $output .= '<tr>
                        <td>'. 1 .'</td>
                        <td>'. $hoadon->tenxe.' - '.$hoadon->mauxe.'</td>
                        <td>'. 'Chiếc'.'</td>
                        <td>'. $hoadon->soluong.'</td>
                        <td>'. number_format($hoadon->dongia, 0, '', '.').'đ</td>                           
                        <td>'. number_format($hoadon->dongia * $hoadon->soluong, 0, '', '.').'đ</td>
                    </tr>';


                    $output .= '
                    <tr>
                        <th colspan="3">Cộng tiền hàng
                        </th>
                        <th>
                        </th>
                        <th>
                        </th>
                        <th>'.number_format($hoadon->dongia * $hoadon->soluong, 0, '', '.').'đ
                        </th>
                    </tr>
                    </tbody>
                </table>
                <p style="margin-left: 50px;">Thuế suất GTGT:'.$hoadon->thueVAT."%&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tiền thuế GTGT: '.number_format($hoadon->dongia * $hoadon->thueVAT / 100, 0, '', '.').'đ </p>
                <p style="margin-left: 50px;">'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng thành tiền thanh toán: '.number_format($hoadon->thanhtien, 0, '', '.').'đ</p>
                <p style="margin-left: 50px;">Số tiền viết bằng chữ: .............................................................................................................................</p>
                <p style="margin-left: 50px;"><b>Người mua hàng</b>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'<b>Người bán hàng</b>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'<b>Thủ trưởng đơn vị</b></p>
                <p style="margin-left: 40px;"><i>(Ký và ghi rõ họ tên)</i>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'<i>(Ký và ghi rõ họ tên)</i>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'<i>(Ký và ghi rõ họ tên)</i></p>
                <br><br><br>
                <p style="margin-left: 270px;"><b>'.$hoadon->hoten.'</b></p>
        </body>
        </html>';
        return $output;
    }

    function getThongKeIndex(){      
        /*Năm này theo tên xe*/
        $namnay = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->get();
        
        $labelsNamNay = $namnay->pluck('tenxe');
        $valuesNamNay = $namnay->pluck('soluong');
        $chartNamNay = new HoaDonXeMay_Chart();
        $chartNamNay->labels($labelsNamNay);
        $chartNamNay->loaderColor('rgb(255, 99, 132)');
        
        $chartNamNay->dataset('Số lượng', 'bar', $valuesNamNay)->color('blue')->backgroundColor('rgb(255, 129, 14)');

        /*Năm này theo tháng*/
        $namnaytheothang = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('MONTH(created_at) as thang'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->groupBy('thang')
        ->orderBy('thang', 'ASC')
        ->get();

        $labelsNamNayTheoThang = $namnaytheothang->pluck('thang');
        $valuesNamNayTheoThang = $namnaytheothang->pluck('soluong');
        $chartNamNayTheoThang = new HoaDonXeMay_Chart();
        $chartNamNayTheoThang->labels($labelsNamNayTheoThang);
        $chartNamNayTheoThang->loaderColor('rgb(255, 99, 132)');
        
        $chartNamNayTheoThang->dataset('Số lượng', 'line', $valuesNamNayTheoThang)->color('blue')->backgroundColor('rgb(255, 99, 132)');

        return view('thongkehoadonbanxemay.hoadonbanxemay', compact('chartThangNay', 'chartThangNayTheoNgay', 'chartNamNay', 'chartNamNayTheoThang'));
    }


    function getThongKeThangHienTai(){
        /* Tháng này */
        $thanghientai = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->get();
        
        $labelsThangHienTai = $thanghientai->pluck('tenxe');
        $valuesThangHienTai = $thanghientai->pluck('soluong');
        $chartThangHienTai = new HoaDonXeMay_Chart();
        $chartThangHienTai->labels($labelsThangHienTai);
        $chartThangHienTai->loaderColor('rgb(255, 99, 132)');
        
        $chartThangHienTai->dataset('Số lượng', 'bar', $valuesThangHienTai)->color('blue')->backgroundColor('rgb(255, 129, 14)');

        /*Tháng này theo ngày*/
        $thanghientaitheongay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->get();

        $labelsThangHienTaiTheoNgay = $thanghientaitheongay->pluck('ngay');
        $valuesThangHienTaiTheoNgay = $thanghientaitheongay->pluck('soluong');
        $chartThangHienTaiTheoNgay = new HoaDonXeMay_Chart();
        $chartThangHienTaiTheoNgay->labels($labelsThangHienTaiTheoNgay);
        $chartThangHienTaiTheoNgay->loaderColor('rgb(255, 99, 132)');
        
        $chartThangHienTaiTheoNgay->dataset('Số lượng', 'line', $valuesThangHienTaiTheoNgay)->color('blue')->backgroundColor('rgb(255, 99, 132)');

        return view('thongkehoadonbanxemay.thanghientai', compact('chartThangHienTai', 'chartThangHienTaiTheoNgay'));
    }

    // Đồ thị thống kê năm hiện tại
    function getThongKeNamHienTai(){      
        /*Năm này theo tên xe*/
        $namhientai = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->get();
        
        $labelsNamHienTai = $namhientai->pluck('tenxe');
        $valuesNamHienTai = $namhientai->pluck('soluong');
        $chartNamHienTai = new HoaDonXeMay_Chart();
        $chartNamHienTai->labels($labelsNamHienTai);
        $chartNamHienTai->loaderColor('rgb(255, 99, 132)');
        
        $chartNamHienTai->dataset('Số lượng', 'bar', $valuesNamHienTai)->color('blue')->backgroundColor('rgb(255, 129, 14)');

        /*Năm này theo tháng*/
        $namhientaitheothang = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('MONTH(created_at) as thang'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->groupBy('thang')
        ->orderBy('thang', 'ASC')
        ->get();

        $labelsNamHienTaiTheoThang = $namhientaitheothang->pluck('thang');
        $valuesNamHienTaiTheoThang = $namhientaitheothang->pluck('soluong');
        $chartNamHienTaiTheoThang = new HoaDonXeMay_Chart();
        $chartNamHienTaiTheoThang->labels($labelsNamHienTaiTheoThang);
        $chartNamHienTaiTheoThang->loaderColor('rgb(255, 99, 132)');
        
        $chartNamHienTaiTheoThang->dataset('Số lượng', 'line', $valuesNamHienTaiTheoThang)->color('blue')->backgroundColor('rgb(255, 99, 132)');

        return view('thongkehoadonbanxemay.namhientai', compact('chartNamHienTai', 'chartNamHienTaiTheoThang'));
    }

    function getxemThangHienTaiDanhSachTenXePDF(){
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThangHienTaiDanhSachTenXePDF());
        return $pdf->stream();
    }

    function data_to_html_ThangHienTaiDanhSachTenXePDF(){
        /* Tháng này */
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->pluck('tenxe');

        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn tháng hiện tại</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN THÁNG HIỆN TẠI</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($tenxe as $tenxe) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->where('tenxe', 'like', '%'.$tenxe.'%')
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$tenxe.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Đơn giá nhập</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getThangHienTaiTheoTenXe(){
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->get();
        return view('thongkehoadonbanxemay.thanghientaitheotenxe', compact('tenxe', 'hoadonbanxemay'));
    }

    function postThangHienTaiTheoTenXe(Request $request){
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->where('tenxe','like', '%'.$request->tenxe.'%')
        ->get();

        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeThangHienTaiTheoTenXe', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeThangHienTaiTheoTenXe');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.thanghientaitheotenxe', compact('tenxe', 'hoadonbanxemay', 'sum','tongthanhtien'));
    }

    function getxemThongKeThangHienTaiTenXePDF(){
        $hoadonbanxemay = session('queryThongKeThangHienTaiTheoTenXe');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeThangHienTaiTenXePDF($hoadonbanxemay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeThangHienTaiTenXePDF($hoadonbanxemay){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Hình ảnh</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td><img src="uploads/xemay/'.$hoadonbanxemay->img.'" width="100" height="60"></td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    // In danh sách tháng hiện tại theo ngày
    function getxemThangHienTaiDanhSachTheoNgayPDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThangHienTaiDanhSachTheoNgayPDF());
        return $pdf->stream();
    }

    function data_to_html_ThangHienTaiDanhSachTheoNgayPDF(){
       /*Tháng này theo ngày*/
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn tháng hiện tại</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN THÁNG HIỆN TẠI</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($ngay as $ngay) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->whereDate('hoa_don_ban_xe_mays.created_at',$ngay)
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$ngay.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getThangHienTaiTheoNgay(){
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->get();
        return view('thongkehoadonbanxemay.thanghientaitheongay', compact('ngay', 'hoadonbanxemay'));
    }

    function postThangHienTaiTheoNgay(Request $request){
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.date('m'))
        ->whereDate('hoa_don_ban_xe_mays.created_at',$request->ngay)
        ->get();
        // return $hoadonbanxemay;
        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeThangHienTaiTheoNgay', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeThangHienTaiTheoNgay');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.thanghientaitheongay', compact('ngay', 'hoadonbanxemay', 'sum','tongthanhtien'));
    }

    // In thống kê hóa đơn theo từng ngày
    function getxemThongKeThangHienTaiTheoNgayPDF(){
        $hoadonbanxemay = session('queryThongKeThangHienTaiTheoNgay');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeThangHienTaiTheoNgayPDF($hoadonbanxemay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeThangHienTaiTheoNgayPDF($hoadonbanxemay){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN</h1></center>
                <table class="table table-bordered table-hover">
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
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    /*In thống kê toàn bộ danh sách năm hiện tại theo tên xe*/
    function getxemNamHienTaiDanhSachTenXePDF(){        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_NamHienTaiDanhSachTenXePDF());
        return $pdf->stream();
    }

    function data_to_html_NamHienTaiDanhSachTenXePDF(){
        /*Năm này theo tên xe*/
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->pluck('tenxe');

        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn năm hiện tại</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN NĂM HIỆN TẠI</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($tenxe as $tenxe) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->where('tenxe', 'like', '%'.$tenxe.'%')
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$tenxe.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                    <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getNamHienTaiTheoTenXe(){
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
         ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
         ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->get();
        return view('thongkehoadonbanxemay.namhientaitheotenxe', compact('tenxe', 'hoadonbanxemay'));
    }

    function postNamHienTaiTheoTenXe(Request $request){
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->where('tenxe','like', '%'.$request->tenxe.'%')
        ->get();

        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeNamHienTaiTheoTenXe', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeNamHienTaiTheoTenXe');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.namhientaitheotenxe', compact('tenxe', 'hoadonbanxemay', 'sum','tongthanhtien'));
    }

    function getxemThongKeNamHienTaiTenXePDF(){
        $hoadonbanxemay = session('queryThongKeNamHienTaiTheoTenXe');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeNamHienTaiTenXePDF($hoadonbanxemay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeNamHienTaiTenXePDF($hoadonbanxemay){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                         $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    /*In danh sách năm hiện tại theo tháng*/
    function getxemNamHienTaiDanhSachTheoThangPDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_NamHienTaiDanhSachTheoThangPDF());
        return $pdf->stream();
    }

    function data_to_html_NamHienTaiDanhSachTheoThangPDF(){
        /*Năm này theo tháng*/
        $thang = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('MONTH(created_at) as thang'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->groupBy('thang')
        ->orderBy('thang', 'ASC')
        ->pluck('thang');
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn năm hiện tại</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN NĂM HIỆN TẠI</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($thang as $thang) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->whereMonth('hoa_don_ban_xe_mays.created_at',$thang)
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Tháng '.$thang.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getNamHienTaiTheoThang(){
       $thang = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('MONTH(created_at) as thang'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->groupBy('thang')
        ->orderBy('thang', 'ASC')
        ->pluck('thang');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->get();
        return view('thongkehoadonbanxemay.namhientaitheothang', compact('thang', 'hoadonbanxemay'));
    }

    function postNamHienTaiTheoThang(Request $request){
        $thang = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('MONTH(created_at) as thang'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->groupBy('thang')
        ->orderBy('thang', 'ASC')
        ->pluck('thang');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
       ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.date('Y'))
        ->whereMonth('hoa_don_ban_xe_mays.created_at',$request->thang)
        ->get();
        // return $hoadonbanxemay;
        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeNamHienTaiTheoThang', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeNamHienTaiTheoThang');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.namhientaitheothang', compact('thang', 'hoadonbanxemay', 'sum','tongthanhtien'));
    }

    /*In thống kê hóa đơn theo từng tháng của năm hiện tại*/
    function getxemThongKeNamHienTaiTheoThangPDF(){
        $hoadonbanxemay = session('queryThongKeNamHienTaiTheoThang');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeNamHienTaiTheoThangPDF($hoadonbanxemay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeNamHienTaiTheoThangPDF($hoadonbanxemay){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN</h1></center>
                <table class="table table-bordered table-hover">
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
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    /* Chọn tháng + chọn năm */
    function getChonThang(){
        return view('thongkehoadonbanxemay.chonthang');
    }

    function postChonThang(Request $request){
        $thang = $request->thang;
        $nam = $request->nam;
        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at',$thang)
        ->get();
        // return $hoadonbanxemay;

       $datathang = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at',$thang)
        ->get();
        
        $labelsThang = $datathang->pluck('tenxe');
        $valuesThang = $datathang->pluck('soluong');
        $chartThang = new HoaDonXeMay_Chart();
        $chartThang->labels($labelsThang);
        $chartThang->loaderColor('rgb(255, 99, 132)');
        
        $chartThang->dataset('Số lượng', 'bar', $valuesThang)->color('blue')->backgroundColor('cyan');

        
        $datathangtheongay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at',$thang)
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->get();
        // return $datathangtheongay;

        $labelsThangTheoNgay = $datathangtheongay->pluck('ngay');
        $valuesThangTheoNgay = $datathangtheongay->pluck('soluong');
        $chartThangTheoNgay = new HoaDonXeMay_Chart();
        $chartThangTheoNgay->labels($labelsThangTheoNgay);
        $chartThangTheoNgay->loaderColor('rgb(255, 99, 132)');
        
        $chartThangTheoNgay->dataset('Số lượng', 'line', $valuesThangTheoNgay)->color('blue')->backgroundColor('khaki');
        return view('thongkehoadonbanxemay.theothang', compact('thang', 'nam', 'chartThang', 'chartThangTheoNgay', 'hoadonbanxemay'));
    }

    /*In danh sách tháng bất kỳ*/
    function getxemTheoThangDanhSachTenXePDF($thang, $nam){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_TheoThangDanhSachTenXePDF($thang,$nam));
        return $pdf->stream();
    }

    function data_to_html_TheoThangDanhSachTenXePDF($thang,$nam){
        /*Tháng bất kỳ*/
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at',$thang)
        ->pluck('tenxe');
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn tháng </title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN THÁNG '.$thang.'/'.$nam.'</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($tenxe as $tenxe) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
                    ->whereMonth('hoa_don_ban_xe_mays.created_at',$thang)
                    ->where('tenxe','like', '%'.$tenxe.'%')
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$tenxe.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getThangBatKyTheoTenXe($thang, $nam){
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.$thang)
        ->whereYear('hoa_don_ban_xe_mays.created_at', $nam)
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.$thang)
        ->whereYear('hoa_don_ban_xe_mays.created_at', $nam)
        ->get();

        return view('thongkehoadonbanxemay.thangbatkytheoten', compact('tenxe', 'hoadonbanxemay', 'thang', 'nam'));
    }

    function postThangBatKyTheoTenXe(Request $request, $thang, $nam){
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.$thang)
        ->whereYear('hoa_don_ban_xe_mays.created_at', $nam)
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.$thang)
        ->whereYear('hoa_don_ban_xe_mays.created_at', $nam)
        ->where('tenxe','like', '%'.$request->tenxe.'%')
        ->get();


        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeThangBatKy', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeThangBatKy');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.thangbatkytheoten', compact('tenxe', 'hoadonbanxemay', 'sum','tongthanhtien', 'thang', 'nam'));
    }

    /*In thống kê hóa đơn theo tên xe của tháng bất kỳ*/
    function getxemThongKeThangBatKyTenXePDF($thang, $nam){
        $hoadonbanxemay = session('queryThongKeThangBatKy');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeThangBatKyTenXePDF($hoadonbanxemay, $thang, $nam));
        return $pdf->stream();
    }

    function data_to_html_ThongKeThangBatKyTenXePDF($hoadonbanxemay, $thang, $nam){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN THÁNG '.$thang.'/'.$nam.'</h1></center>
                <table class="table table-bordered table-hover">
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
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    // In danh sách tháng bất kỳ theo ngày
    function getxemTheoThangDanhSachTheoNgayPDF($thang, $nam){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_TheoThangDanhSachTheoNgayPDF($thang, $nam));
        return $pdf->stream();
    }

    function data_to_html_TheoThangDanhSachTheoNgayPDF($thang, $nam){
       $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngay')
        )
        ->distinct()
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.$thang)
        ->whereYear('hoa_don_ban_xe_mays.created_at', $nam)
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn tháng bất kỳ</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN THÁNG '.$thang.'/'.$nam.'</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($ngay as $ngay) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->whereDate('hoa_don_ban_xe_mays.created_at',$ngay)
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$ngay.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getThangBatKyTheoNgay($thang, $nam){
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.$thang)
        ->whereYear('hoa_don_ban_xe_mays.created_at', $nam)
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.$thang)
        ->whereYear('hoa_don_ban_xe_mays.created_at', $nam)
        ->get();
        return view('thongkehoadonbanxemay.thangbatkytheongay', compact('ngay', 'hoadonbanxemay','thang', 'nam'));
    }

    function postThangBatKyTheoNgay(Request $request, $thang, $nam){
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.$thang)
        ->whereYear('hoa_don_ban_xe_mays.created_at', $nam)
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('MONTH(hoa_don_ban_xe_mays.created_at) = '.$thang)
        ->whereYear('hoa_don_ban_xe_mays.created_at', $nam)
        ->whereDate('hoa_don_ban_xe_mays.created_at',$request->ngay)
        ->get();
        // return $hoadonbanxemay;
        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeBatKyTheoNgay', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeBatKyTheoNgay');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.thangbatkytheongay', compact('ngay', 'hoadonbanxemay', 'sum','tongthanhtien','thang','nam'));
    }

     /*In thống kê hóa đơn theo tháng bất kỳ theo ngày*/
    function getxemThongKeThangBatKyTheoNgayPDF(){
        $hoadonbanxemay = session('queryThongKeBatKyTheoNgay');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeThangBatKyTheoNgayPDF($hoadonbanxemay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeThangBatKyTheoNgayPDF($hoadonbanxemay){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN</h1></center>
                <table class="table table-bordered table-hover">
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
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    /* Chọn tháng + chọn năm */
    function getChonQuy(){
        return view('thongkehoadonbanxemay.chonquy');
    }

    function postChonQuy(Request $request){
        $quy = $request->quy;
        $nam = $request->nam;
        $tuthang = 0; $denthang = 0;
        if($quy == '1'){
            $tuthang = 1; $denthang = 3;
        }
        if($quy == '2'){
            $tuthang = 4; $denthang = 6;
        }
        if($quy == '3'){
            $tuthang = 7; $denthang = 9;
        }
        if($quy == '4'){
            $tuthang = 10; $denthang = 12;
        }
        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->get();

       $dataten = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->get();

        $labelsTen = $dataten->pluck('tenxe');
        $valuesTen = $dataten->pluck('soluong');
        $chartTen = new HoaDonXeMay_Chart();
        $chartTen->labels($labelsTen);
        $chartTen->loaderColor('rgb(255, 99, 132)');
        
        $chartTen->dataset('Số lượng', 'bar', $valuesTen)->color('blue')->backgroundColor('DarkOrchid');

        
        $dataNgay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->get();

        $labelsNgay = $dataNgay->pluck('ngay');
        $valuesNgay = $dataNgay->pluck('soluong');
        $chartNgay = new HoaDonXeMay_Chart();
        $chartNgay->labels($labelsNgay);
        $chartNgay->loaderColor('rgb(255, 99, 132)');
        
        $chartNgay->dataset('Số lượng', 'line', $valuesNgay)->color('blue')->backgroundColor('Grey');
        return view('thongkehoadonbanxemay.theoquy', compact('quy','nam', 'chartTen','chartNgay', 'hoadonbanxemay'));
    }

    /*In danh sách quý*/
    function getxemTheoQuyDanhSachTenXePDF($quy, $nam){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_TheoQuyDanhSachTenXePDF($quy,$nam));
        return $pdf->stream();
    }

    function data_to_html_TheoQuyDanhSachTenXePDF($quy,$nam){
        /*Quý*/
        $tuthang = 0; $denthang = 0;
        if($quy == '1'){
            $tuthang = 1; $denthang = 3;
        }
        if($quy == '2'){
            $tuthang = 4; $denthang = 6;
        }
        if($quy == '3'){
            $tuthang = 7; $denthang = 9;
        }
        if($quy == '4'){
            $tuthang = 10; $denthang = 12;
        }
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->pluck('tenxe');
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn quý </title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN QUÝ '.$quy.'/'.$nam.'</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($tenxe as $tenxe) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
                    ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
                    ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
                    ->where('tenxe','like', '%'.$tenxe.'%')
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$tenxe.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getQuyTheoTenXe($quy, $nam){
        $tuthang = 0; $denthang = 0;
        if($quy == '1'){
            $tuthang = 1; $denthang = 3;
        }
        if($quy == '2'){
            $tuthang = 4; $denthang = 6;
        }
        if($quy == '3'){
            $tuthang = 7; $denthang = 9;
        }
        if($quy == '4'){
            $tuthang = 10; $denthang = 12;
        }
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->get();

        return view('thongkehoadonbanxemay.quytheoten', compact('tenxe', 'hoadonbanxemay', 'quy', 'nam'));
    }

    function postQuyTheoTenXe(Request $request, $quy, $nam){
       $tuthang = 0; $denthang = 0;
        if($quy == '1'){
            $tuthang = 1; $denthang = 3;
        }
        if($quy == '2'){
            $tuthang = 4; $denthang = 6;
        }
        if($quy == '3'){
            $tuthang = 7; $denthang = 9;
        }
        if($quy == '4'){
            $tuthang = 10; $denthang = 12;
        }
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->where('tenxe','like', '%'.$request->tenxe.'%')
        ->get();


        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeQuy', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeQuy');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.quytheoten', compact('tenxe', 'hoadonbanxemay', 'sum','tongthanhtien', 'quy', 'nam'));
    }

    /*In thống kê hóa đơn theo tên xe của quý*/
    function getxemThongKeQuyTenXePDF($quy, $nam){
        $hoadonbanxemay = session('queryThongKeQuy');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeQuyTenXePDF($hoadonbanxemay, $quy, $nam));
        return $pdf->stream();
    }

    function data_to_html_ThongKeQuyTenXePDF($hoadonbanxemay, $quy, $nam){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN QUÝ '.$quy.'/'.$nam.'</h1></center>
                <table class="table table-bordered table-hover">
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
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    // In danh sách quý theo ngày
    function getxemTheoQuyDanhSachTheoNgayPDF($quy, $nam){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_QuyDanhSachTheoNgayPDF($quy, $nam));
        return $pdf->stream();
    }

    function data_to_html_QuyDanhSachTheoNgayPDF($quy, $nam){
        $tuthang = 0; $denthang = 0;
        if($quy == '1'){
            $tuthang = 1; $denthang = 3;
        }
        if($quy == '2'){
            $tuthang = 4; $denthang = 6;
        }
        if($quy == '3'){
            $tuthang = 7; $denthang = 9;
        }
        if($quy == '4'){
            $tuthang = 10; $denthang = 12;
        }
        
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngay')
        )
        ->distinct()
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn quý</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN QUÝ '.$quy.'/'.$nam.'</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($ngay as $ngay) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->whereDate('hoa_don_ban_xe_mays.created_at',$ngay)
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$ngay.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getQuyTheoNgay($quy, $nam){
        $tuthang = 0; $denthang = 0;
        if($quy == '1'){
            $tuthang = 1; $denthang = 3;
        }
        if($quy == '2'){
            $tuthang = 4; $denthang = 6;
        }
        if($quy == '3'){
            $tuthang = 7; $denthang = 9;
        }
        if($quy == '4'){
            $tuthang = 10; $denthang = 12;
        }

        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');


        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->get();
        return view('thongkehoadonbanxemay.quytheongay', compact('ngay', 'hoadonbanxemay','quy', 'nam'));
    }

    function postQuyTheoNgay(Request $request, $quy, $nam){
        $tuthang = 0; $denthang = 0;
        if($quy == '1'){
            $tuthang = 1; $denthang = 3;
        }
        if($quy == '2'){
            $tuthang = 4; $denthang = 6;
        }
        if($quy == '3'){
            $tuthang = 7; $denthang = 9;
        }
        if($quy == '4'){
            $tuthang = 10; $denthang = 12;
        }

        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','>=', $tuthang)
        ->whereMonth('hoa_don_ban_xe_mays.created_at','<=', $denthang)
        ->whereDate('hoa_don_ban_xe_mays.created_at',$request->ngay)
        ->get();
        // return $hoadonbanxemay;
        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeQuyTheoNgay', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeQuyTheoNgay');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.quytheongay', compact('ngay', 'hoadonbanxemay', 'sum','tongthanhtien','quy','nam'));
    }

    /*In thống kê hóa đơn theo quý theo ngày*/
    function getxemThongKeQuyTheoNgayPDF(){
        $hoadonbanxemay = session('queryThongKeQuyTheoNgay');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeQuyTheoNgayPDF($hoadonbanxemay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeQuyTheoNgayPDF($hoadonbanxemay){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN</h1></center>
                <table class="table table-bordered table-hover">
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
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    /* Chọn năm */
    function getChonNam(){
        return view('thongkehoadonbanxemay.chonnam');
    }

    function postChonNam(Request $request){
        $nam = $request->nam;

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->get();

       $dataten = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->get();

        $labelsTen = $dataten->pluck('tenxe');
        $valuesTen = $dataten->pluck('soluong');
        $chartTen = new HoaDonXeMay_Chart();
        $chartTen->labels($labelsTen);
        $chartTen->loaderColor('rgb(255, 99, 132)');
        
        $chartTen->dataset('Số lượng', 'bar', $valuesTen)->color('blue')->backgroundColor('rgb(127, 255, 0)');

        
        $dataNgay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->get();

        $labelsNgay = $dataNgay->pluck('ngay');
        $valuesNgay = $dataNgay->pluck('soluong');
        $chartNgay = new HoaDonXeMay_Chart();
        $chartNgay->labels($labelsNgay);
        $chartNgay->loaderColor('rgb(255, 99, 132)');
        
        $chartNgay->dataset('Số lượng', 'line', $valuesNgay)->color('blue')->backgroundColor('rgb(255, 29, 19)');
        return view('thongkehoadonbanxemay.theonam', compact('nam', 'chartTen', 'chartNgay', 'hoadonbanxemay'));
    }

     /*In danh sách năm*/
    function getxemTheoNamDanhSachTenXePDF($nam){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_TheoNamDanhSachTenXePDF($nam));
        return $pdf->stream();
    }

    function data_to_html_TheoNamDanhSachTenXePDF($nam){
        /*Năm*/
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->pluck('tenxe');
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn năm </title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN NĂM '.$nam.'</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($tenxe as $tenxe) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
                    ->where('tenxe','like', '%'.$tenxe.'%')
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$tenxe.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getNamTheoTenXe($nam){
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->get();

        return view('thongkehoadonbanxemay.namtheoten', compact('tenxe', 'hoadonbanxemay', 'nam'));
    }

    function postNamTheoTenXe(Request $request, $nam){
        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->where('tenxe','like', '%'.$request->tenxe.'%')
        ->get();


        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeNam', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeNam');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.namtheoten', compact('tenxe', 'hoadonbanxemay', 'sum','tongthanhtien', 'nam'));
    }

    /*In thống kê hóa đơn theo tên xe của năm*/
    function getxemThongKeNamTenXePDF($nam){
        $hoadonbanxemay = session('queryThongKeNam');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeNamTenXePDF($hoadonbanxemay, $nam));
        return $pdf->stream();
    }

    function data_to_html_ThongKeNamTenXePDF($hoadonbanxemay, $nam){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN NĂM '.$nam.'</h1></center>
                <table class="table table-bordered table-hover">
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
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    // In danh sách năm theo ngày
    function getxemTheoNamDanhSachTheoNgayPDF($nam){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_NamDanhSachTheoNgayPDF($nam));
        return $pdf->stream();
    }

    function data_to_html_NamDanhSachTheoNgayPDF($nam){        
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngay')
        )
        ->distinct()
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn năm</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN NĂM '.$nam.'</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($ngay as $ngay) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->whereDate('hoa_don_ban_xe_mays.created_at',$ngay)
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$ngay.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getNamTheoNgay($nam){
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');


        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->get();
        return view('thongkehoadonbanxemay.namtheongay', compact('ngay', 'hoadonbanxemay', 'nam'));
    }

    function postNamTheoNgay(Request $request, $nam){
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereRaw('YEAR(hoa_don_ban_xe_mays.created_at) = '.$nam)
        ->whereDate('hoa_don_ban_xe_mays.created_at',$request->ngay)
        ->get();
        // return $hoadonbanxemay;
        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeNamTheoNgay', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeNamTheoNgay');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.namtheongay', compact('ngay', 'hoadonbanxemay', 'sum','tongthanhtien','nam'));
    }

    /*In thống kê hóa đơn theo năm theo ngày*/
    function getxemThongKeNamTheoNgayPDF(){
        $hoadonbanxemay = session('queryThongKeNamTheoNgay');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeNamTheoNgayPDF($hoadonbanxemay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeNamTheoNgayPDF($hoadonbanxemay){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN</h1></center>
                <table class="table table-bordered table-hover">
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
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    /* Chọn khoảng thời gian */
    function getChonKhoangThoiGian(){
        return view('thongkehoadonbanxemay.chonkhoangthoigian');
    }

    function getKhoangThoiGian($tungay, $denngay){
        $tungay = date('Y-m-d',strtotime($tungay));
        $denngay = date('Y-m-d',strtotime($denngay));

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->get();
        // return $hoadonbanxemay;

        $dataten = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->get();
        $labelsTen = $dataten->pluck('tenxe');
        $valuesTen = $dataten->pluck('soluong');
        $chartTen = new HoaDonXeMay_Chart();
        $chartTen->labels($labelsTen);
        $chartTen->loaderColor('rgb(255, 99, 132)');
        
        $chartTen->dataset('Số lượng', 'bar', $valuesTen)->color('blue')->backgroundColor('rgb(255, 29, 19)');

        $dataNgay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->get();

        $labelsNgay = $dataNgay->pluck('ngay');
        $valuesNgay = $dataNgay->pluck('soluong');
        $chartNgay = new HoaDonXeMay_Chart();
        $chartNgay->labels($labelsNgay);
        $chartNgay->loaderColor('rgb(255, 99, 132)');
        
        $chartNgay->dataset('Số lượng', 'line', $valuesNgay)->color('blue')->backgroundColor('rgb(200, 245, 43)');
        return view('thongkehoadonbanxemay.theokhoangthoigian', compact('tungay', 'denngay', 'chartTen', 'hoadonbanxemay', 'chartNgay'));
    }

    /*In danh sách theo khoảng thời gian*/
    function getxemTheoKhoangThoiGianDanhSachTenXePDF($tungay, $denngay){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_TheoKhoangThoiGianDanhSachTenXePDF($tungay, $denngay));
        return $pdf->stream();
    }

    function data_to_html_TheoKhoangThoiGianDanhSachTenXePDF($tungay,$denngay){
        $tungay = date('Y-m-d',strtotime($tungay));
        $denngay = date('Y-m-d',strtotime($denngay));
         $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->pluck('tenxe');
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn khoảng thời gian </title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN<br> TỪ '.$tungay.' ĐẾN '.$denngay.'</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($tenxe as $tenxe) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
                        array($tungay, $denngay))
                    ->where('tenxe','like', '%'.$tenxe.'%')
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$tenxe.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getKhoangThoiGianTheoTenXe($tungay, $denngay){
        $tungay = date('Y-m-d',strtotime($tungay));
        $denngay = date('Y-m-d',strtotime($denngay));

        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->get();

        return view('thongkehoadonbanxemay.khoangthoigiantheoten', compact('tenxe', 'hoadonbanxemay', 'tungay', 'denngay'));
    }

    function postKhoangThoiGianTheoTenXe(Request $request, $tungay, $denngay){
        $tungay = date('Y-m-d',strtotime($tungay));
        $denngay = date('Y-m-d',strtotime($denngay));

        $tenxe = DB::table('hoa_don_ban_xe_mays')
        ->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->select('tenxe',  DB::raw('SUM(hoa_don_ban_xe_mays.soluong) as soluong'))
        ->groupBy('tenxe')
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->pluck('tenxe');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->where('tenxe','like', '%'.$request->tenxe.'%')
        ->get();


        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeKhoangThoiGian', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeKhoangThoiGian');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.khoangthoigiantheoten', compact('tenxe', 'hoadonbanxemay', 'sum','tongthanhtien', 'tungay', 'denngay'));
    }

    /*In thống kê hóa đơn theo tên xe của năm*/
    function getxemThongKeKhoangThoiGianTenXePDF($tungay, $denngay){
        $hoadonbanxemay = session('queryThongKeKhoangThoiGian');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeKhoangThoiGianTenXePDF($hoadonbanxemay, $tungay, $denngay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeKhoangThoiGianTenXePDF($hoadonbanxemay, $tungay, $denngay){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN<br> TỪ '.$tungay.' ĐẾN '.$denngay.'</h1></center>
                <table class="table table-bordered table-hover">
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
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    // In danh sách khoảng thời gian theo ngày
    function getxemTheoKhoangThoiGianDanhSachTheoNgayPDF($tungay, $denngay){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_KhoangThoiGianDanhSachTheoNgayPDF($tungay, $denngay));
        return $pdf->stream();
    }

    function data_to_html_KhoangThoiGianDanhSachTheoNgayPDF($tungay, $denngay){
        $tungay = date('Y-m-d',strtotime($tungay));
        $denngay = date('Y-m-d',strtotime($denngay));     
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngay')
        )
        ->distinct()
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn khoảng thời gian</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                .hrstyle{
                    overflow: visible;
                    padding: 0;
                    border: none;
                    border-top: medium double #333;
                    color: #333;
                    text-align: center;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN <br> TỪ '.$tungay.' ĐẾN '.$denngay.'</h1></center>';
                $soluongchung = 0; $thanhtienchung = 0; $tienlaichung = 0;
                foreach ($ngay as $ngay) {
                    $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
                    ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
                    ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
                    ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
                    ->whereDate('hoa_don_ban_xe_mays.created_at',$ngay)
                    ->get();

                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$ngay.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Ngày bán</th>
                              <th>Tên xe</th>
                              <th>Màu xe</th>
                              <th>Đơn giá nhập</th>
                              <th>Đơn giá bán</th>
                              <th>SL</th>
                              <th>Thuế VAT</th>
                              <th>Thành tiền</th>
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'.number_format($hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong , 0, '', '.').'đ </td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;

                    }
                    $soluongchung += $soluong;
                    $thanhtienchung += $thanhtien;
                    $tienlaichung += $tienlai;
                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>';
                }

               $output .= '<hr class="hrstyle" style="margin-top: 2em;">
                <h6 style="color:red; font-weight: bold;">Tổng số lượng: '.$soluongchung.'<br>Tổng thành tiền: '.number_format($thanhtienchung, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlaichung, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getkhoangthoigiantheongay($tungay, $denngay){
        $tungay = date('Y-m-d',strtotime($tungay));
        $denngay = date('Y-m-d',strtotime($denngay));  
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT', DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap')
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->get();
        return view('thongkehoadonbanxemay.khoangthoigiantheongay', compact('ngay', 'hoadonbanxemay', 'tungay', 'denngay'));
    }

    function postKhoangThoiGianTheoNgay(Request $request, $tungay, $denngay){
        $tungay = date('Y-m-d',strtotime($tungay));
        $denngay = date('Y-m-d',strtotime($denngay));  
        $ngay = DB::table('hoa_don_ban_xe_mays')
        ->select(
            DB::raw('Date(created_at) as ngay'),
            DB::raw('SUM(soluong) as soluong')
        )
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->groupBy('ngay')
        ->orderBy('ngay', 'ASC')
        ->pluck('ngay');

        $hoadonbanxemay = DB::table('hoa_don_ban_xe_mays')->join('xe_mays', 'id_xemay', 'xe_mays.id')
        ->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
        ->join('chi_tiet_nhap_xe_mays', 'chi_tiet_nhap_xe_mays.id_xemay', 'xe_mays.id')
        ->select(
            'hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT',DB::raw('Date(hoa_don_ban_xe_mays.created_at) as ngayban'), 'dongianhap',
                DB::raw('(dongia + dongia * thueVAT / 100) * hoa_don_ban_xe_mays.soluong as thanhtien')
        )
        ->whereBetween(DB::raw('DATE(hoa_don_ban_xe_mays.created_at)'), 
            array($tungay, $denngay))
        ->whereDate('hoa_don_ban_xe_mays.created_at',$request->ngay)
        ->get();
        // return $hoadonbanxemay;
        $sum = $hoadonbanxemay->sum('soluong');

        if($sum > 0){
            Session::put('queryThongKeKhoangThoiGianTheoNgay', $hoadonbanxemay);
        } else {
             Session::forget('queryThongKeKhoangThoiGianTheoNgay');
        }
        $tongthanhtien = $hoadonbanxemay->sum('thanhtien');
        return view('thongkehoadonbanxemay.khoangthoigiantheongay', compact('ngay', 'hoadonbanxemay', 'sum','tongthanhtien','tungay', 'denngay'));
    }

    /*In thống kê hóa đơn theo khoảng thời gian theo ngày*/
    function getxemThongKeKhoangThoiGianTheoNgayPDF(){
        $hoadonbanxemay = session('queryThongKeKhoangThoiGianTheoNgay');
        // return $hoadonbanxemay;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeKhoangThoiGianTheoNgayPDF($hoadonbanxemay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeKhoangThoiGianTheoNgayPDF($hoadonbanxemay){
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách hóa đơn</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH HÓA ĐƠN</h1></center>
                <table class="table table-bordered table-hover">
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
                              <th>Tên KH</th>
                              <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0; $tienlai = 0;
                    foreach ($hoadonbanxemay as $hoadonbanxemay) {
                        $output .= '<tr>
                             <td>'. $hoadonbanxemay->id.'</td>
                             <td>'. $hoadonbanxemay->ngayban.'</td>
                            <td>'. $hoadonbanxemay->tenxe.'</td>
                            <td>'. $hoadonbanxemay->mauxe.'</td>
                            <td>'. number_format($hoadonbanxemay->dongia , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->soluong.'</td>
                            <td>'. $hoadonbanxemay->thueVAT.'</td>
                            <td>'. number_format(($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong , 0, '', '.').'đ</td>
                            <td>'. $hoadonbanxemay->tenkhachhang.'</td>
                            <td>'. $hoadonbanxemay->diachi.'</td>
                        </tr>';
                        $soluong += $hoadonbanxemay->soluong;
                        $thanhtien += $hoadonbanxemay->thanhtien;
                        $tienlai += ($hoadonbanxemay->dongia + $hoadonbanxemay->dongia * $hoadonbanxemay->thueVAT / 100) * $hoadonbanxemay->soluong - $hoadonbanxemay->dongianhap * $hoadonbanxemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ<br>Tổng lãi: '.number_format($tienlai, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }
}
