<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NhaCungCap;

class NhaCungCapController extends Controller
{
    function index(){
    	$nhacungcap = NhaCungCap::DanhSach();
        return view('nhacungcap.danhsach', compact('nhacungcap'));
    }

    function getSua($id){
    	$nhacungcap = NhaCungCap::findOrFail($id);
		return view('nhacungcap.sua', compact('nhacungcap'));
	}

	function getThem(){
		return view('nhacungcap.them');
	}

	function postThem(Request $request){
		$nhacungcap = new NhaCungCap();
        $nhacungcap->tennhacungcap = $request->tennhacungcap;
        $nhacungcap->diachi = $request->diachi;
        $nhacungcap->email = $request->email;
        $nhacungcap->sodienthoai = $request->sodienthoai;
        $nhacungcap->save();
        return redirect('nhacungcap')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$nhacungcap = NhaCungCap::findOrFail($id);
        $nhacungcap->tennhacungcap = $request->tennhacungcap;
        $nhacungcap->diachi = $request->diachi;
        $nhacungcap->email = $request->email;
        $nhacungcap->sodienthoai = $request->sodienthoai;
        $nhacungcap->save();
        return redirect('nhacungcap')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$nhacungcap = NhaCungCap::findOrFail($id);
        $nhacungcap->delete();
        return redirect('nhacungcap')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}

    function getViewPDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html());
        return $pdf->stream();
    }

    function data_to_html(){
        $nhacungcap = NhaCungCap::all();
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Nhà cung cấp</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH NHÀ CUNG CẤP</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Tên nhà cung cấp</th>
                              <th>Địa chỉ</th>
                              <th>Email</th>
                              <th>Số điện thoại</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($nhacungcap as $nhacungcap) {
                        $output .= '<tr>
                             <td>'. $nhacungcap->id.'</td>
                            <td>'. $nhacungcap->tennhacungcap.'</td>
                            <td>'. $nhacungcap->diachi.'</td>
                            <td>'. $nhacungcap->email.'</td>
                            <td>'. $nhacungcap->sodienthoai.'</td>
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
        $pdf->loadHTML($this->data_to_html_thongTinNhaCungCap($id));
        return $pdf->stream();
    }

    function data_to_html_thongTinNhaCungCap($id){
        $nhacungcap = NhaCungCap::findOrFail($id);
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>THÔNG TIN NHÀ CUNG CẤP</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">THÔNG TIN NHÀ CUNG CẤP</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Tên nhà cung cấp</th>
                              <th>Địa chỉ</th>
                              <th>Email</th>
                              <th>Số điện thoại</th>
                        </tr>
                    </thead>
                    <tbody>';

                        $output .= '<tr>
                             <td>'. $nhacungcap->id.'</td>
                            <td>'. $nhacungcap->tennhacungcap.'</td>
                            <td>'. $nhacungcap->diachi.'</td>
                            <td>'. $nhacungcap->email.'</td>
                            <td>'. $nhacungcap->sodienthoai.'</td>
                        </tr>';

                    $output .= '
                    </tbody>
                </table>
            </body>
            </html>';
        return $output;
    }
}
