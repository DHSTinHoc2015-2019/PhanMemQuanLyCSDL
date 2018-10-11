<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhuKien;
use App\XeMay;

class PhuKienController extends Controller
{
    function index(){
    	$phukien = PhuKien::danhSachPhuKien();
        return view('phukien.danhsach', compact('phukien'));
    }

    function getThem(){
    	$xemay = XeMay::all();
		return view('phukien.them', compact('xemay'));
	}

    function getSua($id){
    	$phukien = PhuKien::phuKienTheoID($id);
    	$xemay = XeMay::all();
		return view('phukien.sua', compact('phukien', 'xemay'));
	}

	function postThem(Request $request){
		$phukien = new PhuKien();
        $phukien->id_xemays = $request->id_xemays;
        $phukien->tenphukien = $request->tenphukien;
        $phukien->soluong = $request->soluong;
        $phukien->dongia = $request->dongia;
        $phukien->donvitinh = $request->donvitinh;
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
			if (!$check) {
				return redirect('phukien/them')->with('loi', 'Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
			}
			$name = time() . $file->getClientOriginalName();
			$file->move('uploads/phukien/', $name);
			$phukien->imgphukien = $name;
		}
        $phukien->save();
        return redirect('phukien')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$phukien = PhuKien::findOrFail($id);
        $phukien->id_xemays = $request->id_xemays;
        $phukien->tenphukien = $request->tenphukien;
        $phukien->soluong = $request->soluong;
        $phukien->dongia = $request->dongia;
        $phukien->donvitinh = $request->donvitinh;
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
			if (!$check) {
				return redirect('phukien/sua')->with('loi', 'Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
			}
			$name = time() . $file->getClientOriginalName();
			$file->move('uploads/phukien/', $name);
			$phukien->imgphukien = $name;
		}
        $phukien->save();
        return redirect('phukien')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$phukien = PhuKien::findOrFail($id);
		if (file_exists('uploads/phukien/' . $phukien->imgphukien)) {
            unlink('uploads/phukien/' . $phukien->imgphukien);
        }
        $phukien->delete();
        return redirect('phukien')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}

	function getViewPDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html());
        return $pdf->stream();
    }

    function data_to_html(){
       $phukien = PhuKien::danhSachPhuKien();
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách phụ kiện</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH PHỤ KIỆN</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
			                  <th>Tên phụ kiện</th>
			                  <th>Loại xe</th>
			                  <th>Số lượng</th>
			                  <th>Đơn giá</th>
			                  <th>Đơn vị tính</th>
			                  <th>Hình ảnh</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($phukien as $phukien) {
                        $output .= '<tr>
                             <td>'. $phukien->id.'</td>
                            <td>'. $phukien->tenphukien.'</td>
                            <td>'. $phukien->tenxe.'</td>
                            <td>'. $phukien->soluong.'</td>
                            <td>'. number_format($phukien->dongia, 0, '', '.').'đ</td>
                            <td>'. $phukien->donvitinh.'</td>
                            <td><img src="uploads/phukien/'.$phukien->imgphukien.'" width="100" height="60"></td>
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
        $pdf->loadHTML($this->data_to_html_thongTinPhuKien($id));
        return $pdf->stream();
    }

    function data_to_html_thongTinPhuKien($id){
        $phukien = PhuKien::phuKienTheoID($id);
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Thông tin phụ kiện</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">THÔNG TIN PHỤ KIỆN</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
			                  <th>Tên phụ kiện</th>
			                  <th>Loại xe</th>
			                  <th>Số lượng</th>
			                  <th>Đơn giá</th>
			                  <th>Đơn vị tính</th>
			                  <th>Hình ảnh</th>
                        </tr>
                    </thead>
                    <tbody>';
                    // foreach ($phukien as $phukien) {
                        $output .= '<tr>
                             <td>'. $phukien->id.'</td>
                            <td>'. $phukien->tenphukien.'</td>
                            <td>'. $phukien->tenxe.'</td>
                            <td>'. $phukien->soluong.'</td>
                            <td>'. number_format($phukien->dongia, 0, '', '.').'đ</td>
                            <td>'. $phukien->donvitinh.'</td>
                            <td><img src="uploads/phukien/'.$phukien->imgphukien.'" width="100" height="60"></td>
                        </tr>';
                    // }

                    $output .= '
                    </tbody>
                </table>
            </body>
            </html>';
        return $output;
    }
}
