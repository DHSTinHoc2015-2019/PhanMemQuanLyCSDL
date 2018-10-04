<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\XeMay;
use App\LoaiBaoHanh;
use DB;

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

    // function getTimKiem(){
    //     $xemay = XeMay::danhSachXeMay();
    //     return view('timkiem.xemay', compact('xemay'));
    // }

    //  function postTimKiem(Request $request){
    //     $query = "SELECT DISTINCT xe_mays.id, thong_tin_chung_xes.tenxe, thong_tin_chung_xes.mauxe, thong_tin_chung_xes.dungtichxylanh, loai_bao_hanhs.tenloaibaohanh, sokhung, somay, dongiaban, namsanxuat, thong_tin_chung_xes.img 
    //         FROM xe_mays, chi_tiet_nhap_xes, thong_tin_chung_xes, loai_bao_hanhs 
    //         WHERE (xe_mays.id_chitietnhapxe = chi_tiet_nhap_xes.id) 
    //         AND (chi_tiet_nhap_xes.id_thongtinchungxe = thong_tin_chung_xes.id) 
    //         AND (xe_mays.id_loaibaohanh = loai_bao_hanhs.id)";
    //     $where = "";
    //     if($request->tenxe != null){
    //         $where .= "((tenxe like '%" . $request->tenxe . "%')";
    //     }
    //     if($request->mauxe != null){
    //         if($where == ''){
    //             $where .= "((thong_tin_chung_xes.mauxe like '%" . $request->mauxe . "%')";
    //         } else{
    //             $where .= ' ' . $request->radio1 . ' ' . "(thong_tin_chung_xes.mauxe like '%" . $request->mauxe . "%')";
    //         }
    //     }
    //     if($request->dongiaban != null && $request->dongiabanden != null){
    //         if($where == ''){
    //             $where .= "((dongiaban BETWEEN " . $request->dongiaban . " AND " . $request->dongiabanden . ")";
    //         } else{
    //             $where .= ' ' . $request->radio2 . ' ' . "(dongiaban BETWEEN " . $request->dongiaban . " AND " . $request->dongiabanden . ")";
    //         }
    //     }
    //     if($where != ""){
    //         $query .= " AND " . $where . ")";
    //     }
    //     $xemay = DB::select(DB::raw($query));
        
    //     return view('timkiem.xemay', compact('xemay'));
    // }
}
