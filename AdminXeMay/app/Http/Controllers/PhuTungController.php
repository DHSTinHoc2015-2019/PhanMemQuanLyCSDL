<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhuTung;
use App\LoaiPhuTung;

class PhuTungController extends Controller
{
    function index(){
    	$phutung = PhuTung::danhSachPhuTung();
        return view('phutung.danhsach', compact('phutung'));
    }

    function getThem(){
    	$loaiphutung = LoaiPhuTung::all();
		return view('phutung.them', compact('loaiphutung'));
	}

    function getSua($id){
    	$phutung = PhuTung::phuTungTheoID($id);
    	$loaiphutung = LoaiPhuTung::all();
		return view('phutung.sua', compact('phutung', 'loaiphutung'));
	}

	function postThem(Request $request){
		$phutung = new PhuTung();
        $phutung->id_loaiphutung = $request->id_loaiphutung;
        $phutung->loaixe = $request->loaixe;
        $phutung->soluong = $request->soluong;
        $phutung->dongia = $request->dongia;
        $phutung->save();
        return redirect('phutung')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$phutung = PhuTung::findOrFail($id);
        $phutung->id_loaiphutung = $request->id_loaiphutung;
        $phutung->loaixe = $request->loaixe;
        $phutung->soluong = $request->soluong;
        $phutung->dongia = $request->dongia;
        $phutung->save();
        return redirect('phutung')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$phutung = PhuTung::findOrFail($id);
        $phutung->delete();
        return redirect('phutung')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}

	function getViewPDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html());
        return $pdf->stream();
    }

    function data_to_html(){
       $phutung = PhuTung::danhSachPhuTung();
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách phụ tùng</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH PHỤ TÙNG</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
			                  <th>Tên PT</th>
			                  <th>Loại xe</th>
			                  <th>Số lượng</th>
			                  <th>Đơn giá</th>
			                  <th>Đơn vị tính</th>
			                  <th>Hình ảnh</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($phutung as $phutung) {
                        $output .= '<tr>
                             <td>'. $phutung->id.'</td>
                            <td>'. $phutung->tenphutung.'</td>
                            <td>'. $phutung->loaixe.'</td>
                            <td>'. $phutung->soluong.'</td>
                            <td>'. number_format($phutung->dongia, 0, '', '.').'đ</td>
                            <td>'. $phutung->donvitinh.'</td>
                            <td><img src="uploads/phutung/'.$phutung->imgphutung.'" width="100" height="60"></td>
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
        $pdf->loadHTML($this->data_to_html_thongTinPhuTung($id));
        return $pdf->stream();
    }

    function data_to_html_thongTinPhuTung($id){
        $phutung = PhuTung::phuTungTheoID($id);
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Thông tin phụ tùng</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">THÔNG TIN PHỤ TÙNG</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
			                  <th>Tên PT</th>
			                  <th>Loại xe</th>
			                  <th>Số lượng</th>
			                  <th>Đơn giá</th>
			                  <th>Đơn vị tính</th>
			                  <th>Hình ảnh</th>
                        </tr>
                    </thead>
                    <tbody>';
                    // foreach ($phutung as $phutung) {
                        $output .= '<tr>
                             <td>'. $phutung->id.'</td>
                            <td>'. $phutung->tenphutung.'</td>
                            <td>'. $phutung->loaixe.'</td>
                            <td>'. $phutung->soluong.'</td>
                            <td>'. number_format($phutung->dongia, 0, '', '.').'đ</td>
                            <td>'. $phutung->donvitinh.'</td>
                            <td><img src="uploads/phutung/'.$phutung->imgphutung.'" width="100" height="60"></td>
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
