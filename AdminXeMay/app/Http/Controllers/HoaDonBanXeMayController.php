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
        // $hoadon = HoaDonBanXeMay::all();
        // return date("m",strtotime($hoadon[0]->created_at));

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

        $labelsThangTheoNgay = $datathangtheongay->pluck('ngay');
        $valuesThangTheoNgay = $datathangtheongay->pluck('soluong');
        $chartThangTheoNgay = new HoaDonXeMay_Chart();
        $chartThangTheoNgay->labels($labelsThangTheoNgay);
        $chartThangTheoNgay->loaderColor('rgb(255, 99, 132)');
        
        $chartThangTheoNgay->dataset('Số lượng', 'line', $valuesThangTheoNgay)->color('blue')->backgroundColor('khaki');
        return view('thongkehoadonbanxemay.theothang', compact('thang', 'nam', 'chartThang', 'chartThangTheoNgay', 'hoadonbanxemay'));
    }
}
