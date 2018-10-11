<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NhapXeMay;
use App\NhaCungCap;
use App\ChiTietNhapXeMay;
use Auth;
use DateTime;

class NhapXeMayController extends Controller
{
    function index(){
    	$nhapxe = NhapXeMay::danhsach();
    	return view('nhapxemay.danhsach', compact('nhapxe'));
    }

    function getSua($id){
        $nhapxe = NhapXeMay::findOrFail($id);
    	$nhacungcap = NhaCungCap::all();
		return view('nhapxemay.sua', compact('nhapxe', 'nhacungcap'));
	}

	function getThem(){
		$nhacungcap = NhaCungCap::all();
		return view('nhapxemay.them', compact('nhacungcap'));
	}

	function postThem(Request $request){
		$nhapxe = new NhapXeMay();
        $nhapxe->id_nhacungcap = $request->id_nhacungcap;
        $nhapxe->id_nhanvien = Auth::User()->id;
        $nhapxe->save();
        return redirect('nhapxemay')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$nhapxe = NhapXeMay::findOrFail($id);
        $nhapxe->id_nhacungcap = $request->id_nhacungcap;
        $nhapxe->id_nhanvien = Auth::User()->id;
        $nhapxe->created_at = DateTime::createFromFormat("m/d/Y" , $request->created_at)->format('Y-m-d');
        $nhapxe->save();
        return redirect('nhapxemay')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$nhapxe = NhapXeMay::findOrFail($id);
        $nhapxe->delete();
        return redirect('nhapxemay')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}

    function getInPhieuNhap($id){
        // $nhapxe = NhapXeMay::findOrFail($id);
        // $chitietnhapxe = ChiTietNhapXeMay::danhsachtheoid($id);
        // return $chitietnhapxe;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_InPhieuNhap($id));
        return $pdf->stream();
    }

    function data_to_html_InPhieuNhap($id){
        $chitietnhapxe = ChiTietNhapXeMay::danhsachtheoid($id);
        $nhapxe = NhapXeMay::danhSachTheoID($id);
        $output = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Phiếu nhập xe máy</title>
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
            <h3 style="margin-left: 100px; color: green; padding-bottom: 0px">Công ty TNHH TMTH Honda Huy Tuấn<span style="color: black; margin-left: 200px">'."&emsp;"."&emsp;"."&emsp;".'Mẫu số: 01GTKT3/002</span></h3>
            <p style="margin-left: 150px;">Địa chỉ: 40-42 An Dương Vương - TP Huế'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Ký hiệu: BM/15</p>
            <p style="margin-left: 150px;">Số điện thoại: 0543 813 380'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Số phiếu: </p>
            <hr>
            <center><b><h3>PHIẾU NHẬP XE MÁY</h3></b></center>
            <p style="margin-left: 50px;">Tên nhà cung cấp:'."&emsp;".'<i>'.$nhapxe->tennhacungcap.'</i></p>
            <p style="margin-left: 50px;">Địa chỉ::'."&emsp;".'<i>'.$nhapxe->diachi.'</i></p>
            <p style="margin-left: 50px;">Số điện thoại:'."&emsp;".'<i>'.$nhapxe->sodienthoai.'</i>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Email:'."&emsp;".'<i>'.$nhapxe->email.'</i></p>
            <p style="margin-left: 50px;">Ngày nhập hàng:'."&emsp;".'<i>'.$nhapxe->created_at.'</i></p>
            <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>Tên xe</th>
                          <th>Màu xe</th>
                          <th>Đơn giá</th>
                          <th>Số lượng</th>
                          <th>Đơn vị tính</th>
                          <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $soluong = 0;
                    $tongthanhtien = 0;
                    foreach ($chitietnhapxe as $chitietnhapxe) {
                        $output .= '<tr>
                            <td>'. $chitietnhapxe->tenxe.'</td>
                            <td>'. $chitietnhapxe->mauxe.'</td>
                            <td>'. number_format($chitietnhapxe->dongianhap, 0, '', '.').'đ</td>
                            <td>'. $chitietnhapxe->soluong.'</td>
                            <td>'. $chitietnhapxe->donvitinh.'</td>                           
                            <td>'. number_format($chitietnhapxe->dongianhap * $chitietnhapxe->soluong, 0, '', '.').'đ</td>
                        </tr>';
                        $soluong += $chitietnhapxe->soluong;
                        $tongthanhtien += $chitietnhapxe->dongianhap * $chitietnhapxe->soluong;
                    }

                    $output .= '
                    <tr>
                        <th colspan="3">Tổng
                        </th>
                        <th>'.$soluong.'
                        </th>
                        <th>
                        </th>
                        <th>'.number_format($tongthanhtien, 0, '', '.').'đ
                        </th>
                    </tr>
                    </tbody>
                </table>
                <p style="margin-left: 350px;">Ngày lập hóa đơn: <i>'.date("d/m/Y").'</i></p>
                <p style="margin-left: 50px;"><b>Người giao hàng</b>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'<b>Người lập phiếu</b>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'<b>Kế toán trưởng</b></p>
                <p style="margin-left: 40px;"><i>(Ký và ghi rõ họ tên)</i>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'<i>(Ký và ghi rõ họ tên)</i>'."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'<i>(Ký và ghi rõ họ tên)</i></p>
                <br><br><br>
                <p style="margin-left: 270px;"><b>'.$nhapxe->hoten.'</b></p>
        </body>
        </html>';
        return $output;
    }

    function getThongKeIndex(){
        return view('thongkenhapxemay.nhapxemay');
    }
}
