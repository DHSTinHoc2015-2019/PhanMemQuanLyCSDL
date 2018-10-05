<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HoaDonBanXeMay;
use App\KhachHang;
use App\XeMay;
use Auth;

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

}
