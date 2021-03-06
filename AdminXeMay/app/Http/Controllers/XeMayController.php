<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\XeMay;
use App\LoaiBaoHanh;
use DB;
use Session;
use Carbon\Carbon;
use Charts;
use App\Charts\XeMay_Chart;

class XeMayController extends Controller
{
    function index(){
    	$xemay = XeMay::danhSachXeMay();
    	return view('xemay.danhsach', compact('xemay'));
    }

	function getThem(){
		$loaibaohanh = LoaiBaoHanh::all();
		return view('xemay.them', compact('loaibaohanh'));
	}

	function postThem(Request $request){
		$xemay = new XeMay();
		$xemay->tenxe = $request->tenxe;
        $xemay->mauxe = $request->mauxe;
        $xemay->dongia = $request->dongia;
        $xemay->soluong = 0;
        $xemay->namsanxuat = $request->namsanxuat;
        $xemay->dungtichxylanh = $request->dungtichxylanh;
        $xemay->noisanxuat = $request->noisanxuat;
        $xemay->donvitinh = $request->donvitinh;
        $xemay->id_loaibaohanh = $request->id_loaibaohanh;
        if ($request->hasFile('file')) {
			$file = $request->file('file');
			$duoiAnh = $file->getClientOriginalExtension();
			$arrImg = ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'];
			$check = false;
			for ($i = 0; $i < count($arrImg); $i++) {
				if ($duoiAnh == $arrImg[$i]) {
					$check = true;
					break;
				}
			}
			// if (!$check) {
			// 	return redirect('loaibaohanh/them')->with('loi', 'Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
			// }
			$name = time() . $file->getClientOriginalName();
			$file->move('uploads/xemay/', $name);
			$xemay->img = $name;
		}
        $xemay->save();
        return redirect('xemay')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function getSua($id){
    	$xemay = XeMay::findOrFail($id);
		$loaibaohanh = LoaiBaoHanh::all();
		return view('xemay.sua', compact('xemay', 'loaibaohanh'));
	}

	function postSua(Request $request, $id){
		$xemay = XeMay::findOrFail($id);
		$xemay->tenxe = $request->tenxe;
        $xemay->mauxe = $request->mauxe;
        $xemay->dongia = $request->dongia;
        $xemay->soluong = 0;
        $xemay->namsanxuat = $request->namsanxuat;
        $xemay->dungtichxylanh = $request->dungtichxylanh;
        $xemay->noisanxuat = $request->noisanxuat;
        $xemay->donvitinh = $request->donvitinh;
        $xemay->id_loaibaohanh = $request->id_loaibaohanh;
        if ($request->hasFile('file')) {
			$file = $request->file('file');
			$duoiAnh = $file->getClientOriginalExtension();
			$arrImg = ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'];
			$check = false;
			for ($i = 0; $i < count($arrImg); $i++) {
				if ($duoiAnh == $arrImg[$i]) {
					$check = true;
					break;
				}
			}
			// if (!$check) {
			// 	return redirect('loaibaohanh/them')->with('loi', 'Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
			// }
			$name = time() . $file->getClientOriginalName();
			$file->move('uploads/xemay/', $name);
			$xemay->img = $name;
		}
        $xemay->save();
        return redirect('xemay')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$xemay = XeMay::findOrFail($id);
		 if (file_exists('uploads/xemay/' . $xemay->img)) {
            unlink('uploads/xemay/' . $xemay->img);
        }
        $xemay->delete();
        return redirect('xemay')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}

    function getViewPDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html());
        return $pdf->stream();
    }

    function data_to_html(){
        $xemay = XeMay::danhSachXeMay();
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>DANH SÁCH XE MÁY</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH XE MÁY</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
			                  <th>Tên xe</th>
			                  <th>Màu xe</th>
			                  <th>Đơn giá</th>
			                  <th>Số lượng</th>
			                  <th>Dung tích</th>
			                  <th>Đơn vị tính</th>
			                  <th>Loại bảo hành</th>
			                  <th>Năm sản xuất</th>
			                  <th>Nơi sản xuất</th>
			                  <th>Hình ảnh</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.') .'đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->donvitinh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td>'. $xemay->noisanxuat.'</td>
                            <td><img src="uploads/xemay/'. $xemay->img.'" width="100" height="60"></td>
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
        $pdf->loadHTML($this->data_to_html_thongTinXeMay($id));
        return $pdf->stream();
    }

    function data_to_html_thongTinXeMay($id){
       $xemay = XeMay::danhSachXeMayTheoID($id);
        
       $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>THÔNG TIN XE MÁY</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">THÔNG TIN XE MÁY</h1></center>
               <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
			                  <th>Tên xe</th>
			                  <th>Màu xe</th>
			                  <th>Đơn giá</th>
			                  <th>Số lượng</th>
			                  <th>Dung tích</th>
			                  <th>Đơn vị tính</th>
			                  <th>Loại bảo hành</th>
			                  <th>Năm sản xuất</th>
			                  <th>Nơi sản xuất</th>
			                  <th>Hình ảnh</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.') .'đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->donvitinh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td>'. $xemay->noisanxuat.'</td>
                            <td><img src="uploads/xemay/'. $xemay->img.'" width="100" height="60"></td>
                        </tr>';
                    }

                    $output .= '
                    </tbody>
                </table>
            </body>
            </html>';
        return $output;
    }

    function getTimKiem(){
        $xemay = XeMay::danhSachXeMay();
        return view('timkiem.xemay', compact('xemay'));
    }

     function postTimKiem(Request $request){
        $toantu = "";
        if($request->has("AND")) $toantu .= " AND ";
        else $toantu .= " OR ";

        $query = "SELECT DISTINCT xe_mays.id, tenxe, mauxe, dongia, soluong, namsanxuat, noisanxuat, dungtichxylanh, donvitinh, loai_bao_hanhs.tenloaibaohanh, img
            FROM xe_mays, loai_bao_hanhs 
            WHERE (xe_mays.id_loaibaohanh = loai_bao_hanhs.id)";

        $where = "";
        if($request->tenxe != null){
            $where .= "((tenxe like '%" . $request->tenxe . "%')";
        }
        if($request->mauxe != null){
            if($where == ''){
                $where .= "((mauxe like '%" . $request->mauxe . "%')";
            } else{
                $where .= ' ' . $toantu . ' ' . "(mauxe like '%" . $request->mauxe . "%')";
            }
        }
        if($request->dongiaban != null && $request->dongiabanden != null){
            if($where == ''){
                $where .= "((dongia BETWEEN " . $request->dongiaban . " AND " . $request->dongiabanden . ")";
            } else{
                $where .= ' ' . $toantu . ' ' . "(dongia BETWEEN " . $request->dongiaban . " AND " . $request->dongiabanden . ")";
            }
        }

        if($where != ""){
           $query .= " AND " . $where . ")";
            Session::put('querySearchXeMay', $query);
        } else {
            Session::forget('querySearchXeMay');
        }
        $xemay = DB::select(DB::raw($query));
        
        return view('timkiem.xemay', compact('xemay'));
    }

     function getViewSearchPDF(){
        if(!empty(session('querySearchXeMay'))) $xemay = DB::select(DB::raw(session('querySearchXeMay')));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_search($xemay));
        return $pdf->stream();
    }

    function data_to_html_search($xemay){
       $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách tìm kiếm xe máy</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH TÌM KIẾM XE MÁY</h1></center>
                <table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').' đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
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
        /* Tên xe máy */
        $countXeMay = XeMay::where('soluong', '>', 0)
        ->get([
          DB::raw('SUM(soluong) as tong')
        ])
        ->first()
        ->tong;

        $tenxe = DB::table('xe_mays')
        ->select('tenxe',  DB::raw('SUM(soluong) as soluong'))
        ->groupBy('tenxe')
        ->where('soluong', '>', 0)
        ->get();

        $labelsTenXe = $tenxe->pluck('tenxe');
        $valuesTenXe = $tenxe->pluck('soluong');
        $chartTenXe = new XeMay_Chart();
        $chartTenXe->labels($labelsTenXe);
        $chartTenXe->loaderColor('rgb(255, 99, 132)');
        
        $chartTenXe->dataset('Số lượng', 'bar', $valuesTenXe)->color('blue')->backgroundColor('rgb(255, 129, 14)');

        /* Màu xe */
        $mauxe = DB::table('xe_mays')
        ->select('mauxe',  DB::raw('SUM(soluong) as soluong'))
        ->groupBy('mauxe')
        ->get();

        $labelsMauXe = $mauxe->pluck('mauxe');
        $valuesMauXe = $mauxe->pluck('soluong');
        $chartMauXe = new XeMay_Chart();
        $chartMauXe->labels($labelsMauXe);
        $chartMauXe->loaderColor('rgb(255, 99, 132)');

        
        $chartMauXe->dataset('Số lượng', 'bar', $valuesMauXe)->color('black')->backgroundColor('rgb(128, 12, 232)');

         /* Giá bán */
        $dongia10_20 = DB::table('xe_mays')
        ->select('tenxe','mauxe',  DB::raw('SUM(soluong) as soluong'))
        ->groupBy('tenxe', 'mauxe')
        ->where('dongia', '>', 10000000)
        ->where('dongia', '<=', 50000000)
        ->get();
        // return $dongia10_20;
        return view('thongkexemay.xemay', compact('chartTenXe', 'chartMauXe'));
    }

    function getThongKeXeTrongCuaHang(){
        $xemay = XeMay::danhSachXeMayTrongCuaHang();
        $sumsoluong = $xemay->sum('soluong');
        return view('thongkexemay.xetrongcuahang', compact('xemay', 'sumsoluong'));
    }

    function getThongKeTenXe(){
        $xemay = XeMay::danhSachXeMayTrongCuaHang();
        $tenxe = XeMay::select('tenxe')->distinct()->get();
        return view('thongkexemay.tenxe', compact('xemay', 'tenxe'));
    }

    function postThongKeTenXe(Request $request){
        $xemay = XeMay::join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
        ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
        ->where('tenxe', $request->tenxe)
        ->get();
        $sum = $xemay->sum('soluong');
        $tenxemay = "";
        if($sum > 0){
            Session::put('queryThongKeTenXe', $xemay);
            $tenxemay = $xemay[0]->tenxe;
        } else {
             Session::forget('queryThongKeTenXe');
        }
        $count = XeMay::all()->sum('soluong');
        $tile = round($sum / $count * 100, 2);
        $tenxe = XeMay::select('tenxe')->distinct()->get();
        return view('thongkexemay.tenxe', compact('xemay','tenxe', 'sum', 'tile', 'tenxemay'));
    }

    function getThongKeTenXePDF(){
        $xemay = session('queryThongKeTenXe');
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeTenXe($xemay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeTenXe($xemay){
       $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Thống kê xe máy</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH XE MÁY</h1></center>
                <table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').' đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
                        </tr>';
                         $soluong += $xemay->soluong;
                        $thanhtien += $xemay->dongia * $xemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getxemDanhSachTheoTungLoaiXePDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_DanhSachTheoTungLoaiXePDF());
        return $pdf->stream();
    }

    function data_to_html_DanhSachTheoTungLoaiXePDF(){
        $tenxe = XeMay::distinct()->select('tenxe')->get();
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Thống kê xe máy</title>
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
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH XE MÁY</h1></center>';
                foreach ($tenxe as $tenxe) {
                     $xemay = XeMay::join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
                    ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
                    ->where('tenxe', 'like', '%'.$tenxe->tenxe.'%')
                    ->get();
                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$tenxe->tenxe.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').'đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
                        </tr>';
                        $soluong += $xemay->soluong;
                        $thanhtien += $xemay->dongia * $xemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>';
                }

                $output .= '
            </body>
            </html>';
        return $output;
    }

    function getThongKeMauXe(){
        $xemay = XeMay::danhSachXeMayTrongCuaHang();
        $mauxe = XeMay::select('mauxe')->distinct()->get();
        return view('thongkexemay.mauxe', compact('xemay', 'mauxe'));
    }

    function postThongKeMauXe(Request $request){
        $xemay = XeMay::join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
        ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
        ->where('mauxe', $request->mauxe)
        ->get();
        $sum = $xemay->sum('soluong');
        if($sum > 0){
            Session::put('queryThongKeMauXe', $xemay);
        } else {
             Session::forget('queryThongKeMauXe');
        }
        $count = XeMay::all()->sum('soluong');
        $tile = round($sum / $count * 100, 2);
        $mauxe = XeMay::select('mauxe')->distinct()->get();
        return view('thongkexemay.mauxe', compact('xemay','mauxe', 'sum', 'tile'));
    }

    function getxemThongKeMauXePDF(){
        $xemay = session('queryThongKeMauXe');
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_ThongKeMauXe($xemay));
        return $pdf->stream();
    }

    function data_to_html_ThongKeMauXe($xemay){
       $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Thống kê xe máy</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH XE MÁY</h1></center>
                <table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').' đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
                        </tr>';
                         $soluong += $xemay->soluong;
                        $thanhtien += $xemay->dongia * $xemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }

    function getxemDanhSachTheoMauXePDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_DanhSachTheoMauXePDF());
        return $pdf->stream();
    }

    function data_to_html_DanhSachTheoMauXePDF(){
        $mauxe = XeMay::distinct()->select('mauxe')->get();
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Thống kê xe máy</title>
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
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH XE MÁY THEO MÀU XE</h1></center>';
                foreach ($mauxe as $mauxe) {
                     $xemay = XeMay::join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
                    ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
                    ->where('mauxe', 'like', '%'.$mauxe->mauxe.'%')
                    ->get();
                    $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$mauxe->mauxe.'</h2>';
                    $output .= '<table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').'đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
                        </tr>';
                        $soluong += $xemay->soluong;
                        $thanhtien += $xemay->dongia * $xemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>';
                }

                $output .= '
            </body>
            </html>';
        return $output;
    }

    function getThongKeDonGia(){
        $xemay = XeMay::danhSachXeMayTrongCuaHang();
        return view('thongkexemay.dongia', compact('xemay'));
    }

    function postThongKeDonGia(Request $request){
        $xemay = XeMay::join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
        ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
        ->where('dongia', '>=', $request->dongiatu)
        ->where('dongia', '<=', $request->dongiaden)
        ->get();
        $sum = $xemay->sum('soluong');
        if($sum > 0){
            Session::put('queryThongKeDonGia', $xemay);
        } else {
             Session::forget('queryThongKeDonGia');
        }
        $count = XeMay::all()->sum('soluong');
        $tile = round($sum / $count * 100, 2);
        return view('thongkexemay.dongia', compact('xemay', 'sum', 'tile'));
    }

    function getxemThongKeDonGiaPDF(){
        $xemay = session('queryThongKeDonGia');
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_DonGiaPDF($xemay));
        return $pdf->stream();
    }

    function data_to_html_DonGiaPDF($xemay){
       $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Thống kê xe máy</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH XE MÁY</h1></center>
                <table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').' đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
                        </tr>';
                         $soluong += $xemay->soluong;
                        $thanhtien += $xemay->dongia * $xemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>
            </body>
            </html>';
        return $output;
    }



























































































    function getxemDanhSachTheoDonGiaPDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_DanhSachTheoDonGiaPDF());
        return $pdf->stream();
    }

    function data_to_html_DanhSachTheoDonGiaPDF(){
        $xemay = XeMay::join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
        ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
        ->where('dongia', '<',  20000000)
        ->get();
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Thống kê xe máy</title>
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
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH XE MÁY THEO ĐƠN GIÁ</h1></center>
                <hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Giá dưới 20.000.000đ</h2>';
               
                    $output .= '<table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').'đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
                        </tr>';
                        $soluong += $xemay->soluong;
                        $thanhtien += $xemay->dongia * $xemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>';
                
                $xemay = XeMay::join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
                ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
                ->where('dongia', '>=',  20000000)
                ->where('dongia', '<',  30000000)
                ->get();
                $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Giá từ 20.000.000đ - 30.000.000đ</h2>';

                $output .= '<table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').'đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
                        </tr>';
                        $soluong += $xemay->soluong;
                        $thanhtien += $xemay->dongia * $xemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>';

                 $xemay = XeMay::join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
                ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
                ->where('dongia', '>=',  30000000)
                ->where('dongia', '<',  40000000)
                ->get();
                $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Giá từ 30.000.000đ - 40.000.000đ</h2>';

                $output .= '<table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').'đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
                        </tr>';
                        $soluong += $xemay->soluong;
                        $thanhtien += $xemay->dongia * $xemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>';

                 $xemay = XeMay::join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
                ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
                ->where('dongia', '>=',  40000000)
                ->where('dongia', '<',  50000000)
                ->get();
                $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Giá từ 40.000.000đ - 50.000.000đ</h2>';

                $output .= '<table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').'đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
                        </tr>';
                        $soluong += $xemay->soluong;
                        $thanhtien += $xemay->dongia * $xemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>';

                 $xemay = XeMay::join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
                ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
                ->where('dongia', '>=',  50000000)
                ->get();
                $output .= '<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Giá trên 50.000.000đ</h2>';

                $output .= '<table class="table table-bordered table-hover">
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
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0; $thanhtien = 0;
                    foreach ($xemay as $xemay) {
                        $output .= '<tr>
                             <td>'. $xemay->id.'</td>
                            <td>'. $xemay->tenxe.'</td>
                            <td>'. $xemay->mauxe.'</td>
                            <td>'. number_format($xemay->dongia, 0, '', '.').' đ</td>
                            <td>'. $xemay->soluong.'</td>
                            <td>'. number_format($xemay->dongia * $xemay->soluong, 0, '', '.').'đ</td>
                            <td>'. $xemay->dungtichxylanh.'</td>
                            <td>'. $xemay->tenloaibaohanh.'</td>
                            <td>'. $xemay->namsanxuat.'</td>
                            <td><img src="uploads/xemay/'.$xemay->img.'" width="100" height="60"></td>
                        </tr>';
                        $soluong += $xemay->soluong;
                        $thanhtien += $xemay->dongia * $xemay->soluong;
                    }

                    $output .= '
                    </tbody>
                </table><h6 style="color:red;">Tổng số lượng: '.$soluong.'<br>Tổng thành tiền: '.number_format($thanhtien, 0, '', '.').'đ</h6>';

                $output .= '
            </body>
            </html>';
        return $output;
    }
}
