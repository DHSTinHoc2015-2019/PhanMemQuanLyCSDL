<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChiTietNhapXeMay;
use App\XeMay;
use PDF;

class ChiTietNhapXeMayController extends Controller
{
    function index($id_nhapxemay){
    	$chitietnhapxe = ChiTietNhapXeMay::danhsachtheoid($id_nhapxemay);
    	return view('chitietnhapxemay.danhsach', compact('chitietnhapxe', 'id_nhapxemay'));
    }

	function getThem($id_nhapxemay){
		$xemay = XeMay::all();
		return view('chitietnhapxemay.them', compact('id_nhapxemay', 'xemay'));
	}

	function postThem(Request $request, $id_nhapxemay){
		$chitietnhapxe = new ChiTietNhapXeMay();
        $chitietnhapxe->id_nhapxemay = $id_nhapxemay;
        $chitietnhapxe->id_xemay = $request->id_xemay;
        $chitietnhapxe->dongianhap = $request->dongianhap;
        $chitietnhapxe->soluong = $request->soluong;
        $chitietnhapxe->save();
        return redirect('chitietnhapxemay/'.$id_nhapxemay)->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function getSua($id_nhapxemay, $id_chitiet){
    	$chitietnhapxe = ChiTietNhapXeMay::findOrFail($id_chitiet);
    	$xemay = XeMay::all();
    	$xemay1 = XeMay::all();
		return view('chitietnhapxemay.sua', compact('chitietnhapxe', 'xemay','xemay1', 'id_nhapxemay'));
	}

	function postSua(Request $request, $id_nhapxemay, $id_chitiet){
		$chitietnhapxe = ChiTietNhapXeMay::findOrFail($id_chitiet);
        $chitietnhapxe->id_nhapxemay = $id_nhapxemay;
        $chitietnhapxe->id_xemay = $request->id_xemay;
        $chitietnhapxe->dongianhap = $request->dongianhap;
        $chitietnhapxe->soluong = $request->soluong;
        $chitietnhapxe->save();
        return redirect('chitietnhapxemay/'.$id_nhapxemay)->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id, $id_chitiet){
        $chitietnhapxe = ChiTietNhapXeMay::findOrFail($id_chitiet);
        $chitietnhapxe->delete();
        return redirect('chitietnhapxemay/'.$id)->with('thongbaoxoa', "Xóa dữ liệu thành công!");
    }

    function getView($idnhapxe){
		$pdf = \App::make('dompdf.wrapper');
        // $chitietnhapxe = ChiTietNhapXe::where('id_nhapxe', $idnhapxe);
        // $html = mb_convert_encoding($this->convert_customer_data_to_html($idnhapxe), 'HTML-ENTITIES', 'UTF-8');
        // $pdf->loadHTML($html);
        $pdf->loadHTML($this->convert_customer_data_to_html($idnhapxe));
        return $pdf->stream();
	}

    function convert_customer_data_to_html($idnhapxe){
        $chitietnhapxe = ChiTietNhapXe::where('id_nhapxe', $idnhapxe)->get();
        $output ='<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
    *{ 
        font-family: DejaVu Sans !important; 
        font-size: 10px;
    }
</style>
</head>
<body>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
              <th>ID</th>
              <th>Mã nhập xe</th>
              <th>Tên xe</th>
              <th>Màu xe</th>
              <th>Dung tích</th>
              <th>Đơn giá nhập</th>
              <th>Số lượng</th>
              <th>Đơn vị tính</th>
            </tr>
        </thead>
        <tbody>';
            foreach ($chitietnhapxe as $chitietnhapxe) {
                $output .= '<tr>
                  <td>'.$chitietnhapxe->id.'</td>
                  <td>'.$chitietnhapxe->id_nhapxe.'</td>
                  <td>'.$chitietnhapxe->tenxe.'</td>
                  <td>'.$chitietnhapxe->mauxe.'</td>
                  <td>'.$chitietnhapxe->dungtichxylanh.'</td>
                  <td>'.number_format($chitietnhapxe->dongianhap, 0, '', '.').' đ</td>
                  <td>'.$chitietnhapxe->soluong.'</td>
                  <td>'.$chitietnhapxe->donvitinh.'</td>';
            }
            $output .= '
        </tbody>
    </table>
</body>
</html>';
        return $output;
    }
}
