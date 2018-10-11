<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NhapPhuTungPhuKien;
use App\NhaCungCap;
use App\NhanVien;
use App\ChiTietNhapPhuTung;
use App\ChiTietNhapPhuKien;
use Auth;
use DateTime;

class NhapPhuTungPhuKienController extends Controller
{
     function index(){
    	$nhapphutungphukien = NhapPhuTungPhuKien::danhSachPhuTungPhuKien();
        return view('nhapphutungphukien.danhsach', compact('nhapphutungphukien'));
    } 

    function danhsachchitiet($id_nhapphutungphukien){
        $chitietnhapphutung = ChiTietNhapPhuTung::danhSachChiTietNhapPhuTung($id_nhapphutungphukien);
    	$chitietnhapphukien = ChiTietNhapPhuKien::danhSachChiTietNhapPhuKien($id_nhapphutungphukien);
        return view('chitietnhapphutungphukien.danhsach', compact('chitietnhapphutung', 'id_nhapphutungphukien', 'chitietnhapphukien'));
    }

    function getThem(){
    	$nhacungcap = NhaCungCap::all();
		return view('nhapphutungphukien.them', compact('nhacungcap'));
	}

    function getSua($id){
    	$nhapphutungphukien = NhapPhuTungPhuKien::findOrFail($id);
    	$nhacungcap = NhaCungCap::all();
		return view('nhapphutungphukien.sua', compact('nhapphutungphukien', 'nhacungcap'));
	}

	function postThem(Request $request){
		$nhapphutungphukien = new NhapPhuTungPhuKien();
        $nhapphutungphukien->id_nhacungcap = $request->id_nhacungcap;
        $nhapphutungphukien->id_nhanvien = Auth::User()->id;
        $nhapphutungphukien->save();
        return redirect('nhapphutungphukien')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$nhapphutungphukien = NhapPhuTungPhuKien::findOrFail($id);
        $nhapphutungphukien->id_nhacungcap = $request->id_nhacungcap;
        $nhapphutungphukien->id_nhanvien = Auth::User()->id;
        $nhapphutungphukien->created_at = DateTime::createFromFormat("m/d/Y" , $request->created_at)->format('Y-m-d');
        $nhapphutungphukien->save();
        return redirect('nhapphutungphukien')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$nhapphutungphukien = NhapPhuTungPhuKien::findOrFail($id);
        $nhapphutungphukien->delete();
        return redirect('nhapphutungphukien')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}

    function getViewPDF(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html());
        return $pdf->stream();
    }

    function data_to_html(){
        $nhapphutungphukien = NhapPhuTungPhuKien::all();

        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Danh sách nhập phụ tùng phụ kiện</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
                span{
                    font-weight: bold;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold; margin-bottom: 1em;">DANH SÁCH NHẬP PHỤ TÙNG PHỤ KIỆN</h1></center>';
                
                // return $output;
                foreach ($nhapphutungphukien as $nhapphutungphukien) {
                    $output .= '<div>';

                    $output .= '<p style="font-style: italic;"><span>ID: </span>'.$nhapphutungphukien->id.'<span>&emsp;&emsp;&emsp;Nhân viên: </span>';
                    $nhanvientheoid = NhanVien::findOrFail($nhapphutungphukien->id_nhanvien);
                    $output .= $nhanvientheoid->hoten;

                    $output .= '<span>&emsp;&emsp;&emsp;Ngày nhập: </span>'.date('d-m-Y',strtotime($nhapphutungphukien->created_at));

                    $nhacungcaptheoid = NhaCungCap::findOrFail($nhapphutungphukien->id_nhacungcap);
                    $output .= '<span>&emsp;&emsp;&emsp;Nhà cung cấp: </span>'.$nhacungcaptheoid->tennhacungcap;
                    $output .= '</p>';
                    $output .= '<table width=100%><tr>
                    <td width="50%" valign="top">';
                    $output .= '<table class="table table-bordered table-hover">
                        <thead>
                            <tr class="table-warning">
                                <th colspan="4"><center>PHỤ TÙNG</center></th>
                            </tr>
                            <tr class="table-danger">
                                <th>Tên</th>
                                <th>Loại xe</th>
                                <th>SL</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $chitietnhapphutung = ChiTietNhapPhuTung::danhSachchitietnhapphutung($nhapphutungphukien->id);
                            foreach ($chitietnhapphutung as $chitietnhapphutung) {
                                $output .= '<tr class="table-secondary">';
                                $output .= '<td>'. $chitietnhapphutung->tenloaiphutung.'</td>';
                                $output .='<td>'. $chitietnhapphutung->loaixe.'</td>';
                                $output .='<td>'. $chitietnhapphutung->soluong.'</td>';
                                $output .='<td>'. number_format($chitietnhapphutung->gianhap, 0, '', '.').'đ</td>';
                                $output .= '</tr>';
                            }
                        $output .= '
                        </tbody>
                    </table>';
                    $output .= '</td>
                    <td width="50%" valign="top">';
                    $output .= '<table class="table table-bordered table-hover">
                        <thead>
                            <tr class="table-warning">
                                <th colspan="4"><center>PHỤ KIỆN</center></th>
                            </tr>
                            <tr class="table-danger">
                                <th>Tên</th>
                                <th>Tên xe</th>
                                <th>SL</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $chitietnhapphukien = ChiTietNhapPhuKien::danhSachChiTietNhapPhuKien($nhapphutungphukien->id);
                            foreach ($chitietnhapphukien as $chitietnhapphukien) {
                                $output .= '<tr class="table-secondary">';
                                $output .= '<td>'. $chitietnhapphukien->tenphukien.'</td>';
                                $output .='<td>'. $chitietnhapphukien->tenxe.'</td>';
                                $output .='<td>'. $chitietnhapphukien->soluong.'</td>';
                                $output .='<td>'. number_format($chitietnhapphukien->gianhap, 0, '', '.').'đ</td>';
                                $output .= '</tr>';
                            }
                        $output .= '
                        </tbody>
                    </table>';
                    $output .= '</td></tr></table>';

                    $output .= '<img src="uploads/img/separator.png" style="margin-left:3em; margin-top: 0"></div>';
                }
                 $output .= '
            </body>
            </html>';
        return $output;
    }
}
