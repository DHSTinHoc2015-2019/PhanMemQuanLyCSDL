<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KhachHang;
use DateTime;
use Session;
use PDF;
use DB;

class KhachHangController extends Controller
{
    function index(){
    	$khachhang = KhachHang::all();
        return view('khachhang.danhsach', compact('khachhang'));
    }

    function getSua($id){
    	$khachhang = KhachHang::findOrFail($id);
		return view('khachhang.sua', compact('khachhang'));
	}

	function getThem(){
		return view('khachhang.them');
	}

	function postThem(Request $request){
		$khachhang = new KhachHang();
        $khachhang->tenkhachhang = $request->tenkhachhang;
        $khachhang->ngaysinh = DateTime::createFromFormat("m/d/Y" , $request->ngaysinh)->format('Y-m-d');;
        $khachhang->sodienthoai = $request->sodienthoai;
        $khachhang->gioitinh = $request->gioitinh;
        $khachhang->diachi = $request->diachi;
        $khachhang->soCMND = $request->soCMND;
        $khachhang->save();
        return redirect('khachhang')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$khachhang = KhachHang::findOrFail($id);
        $khachhang->tenkhachhang = $request->tenkhachhang;
        $khachhang->ngaysinh = DateTime::createFromFormat("m/d/Y" , $request->ngaysinh)->format('Y-m-d');
        $khachhang->sodienthoai = $request->sodienthoai;
        $khachhang->gioitinh = $request->gioitinh;
        $khachhang->diachi = $request->diachi;
        $khachhang->soCMND = $request->soCMND;
        $khachhang->save();
        return redirect('khachhang')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$khachhang = KhachHang::findOrFail($id);
        $khachhang->delete();
        return redirect('khachhang')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}


    function getTimKiem(){
        $khachhang = KhachHang::all();
        return view('timkiem.khachhang', compact('khachhang'));
    }

     function postTimKiem(Request $request){
        $toantu = "";
        if($request->has("AND")) $toantu .= " AND ";
        else $toantu .= " OR ";

        $query = "
        SELECT *
        FROM khach_hangs
        ";

        $where = "";
        if($request->tenkhachhang != null){
            $where .= "(tenkhachhang like '%" . $request->tenkhachhang . "%')";
        }

        if($request->gioitinh != null){
            if($where == ''){
                $where .= "(gioitinh like '%" . $request->gioitinh . "%')";
            } else{
                $where .= ' ' . $toantu . ' ' . "(gioitinh like '%" . $request->gioitinh . "%')";
            }
        }

        if($request->diachi != null){
            if($where == ''){
                $where .= "(diachi like '%" . $request->diachi . "%')";
            } else{
                $where .= ' ' . $toantu . ' ' . "(diachi like '%" . $request->diachi . "%')";
            }
        }

        if($request->namsinhtu != null && $request->namsinhden != null){
            if($where == ''){
                $where .= "(YEAR(ngaysinh) BETWEEN " . $request->namsinhtu . " AND " . $request->namsinhden . ")";
            } else{
                $where .= ' ' . $toantu . ' ' . "(YEAR(ngaysinh) BETWEEN " . $request->namsinhtu . " AND " . $request->namsinhden . ")";
            }
        }

        if($where != ""){
            $query .= " WHERE " . $where;
            Session::put('querySearchKhachHang', $query);
        } else {
            Session::forget('querySearchKhachHang');
        }
        // return $query;
        $khachhang = DB::select(DB::raw($query));
        return view('timkiem.khachhang', compact('khachhang', 'query'));
    }

    function getViewPDF(){
        $khachhang = khachhang::all();
        // return $khachhang;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html());
        return $pdf->stream();
    }

    function data_to_html(){
        $khachhang = khachhang::all();
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Khách hàng</title>
                <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH KHÁCH HÀNG</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Họ tên</th>
                              <th>Ngày sinh</th>
                              <th>Giới tính</th>
                              <th>Số CMND</th>
                              <th>Địa chỉ</th>
                              <th>Số ĐT</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($khachhang as $khachhang) {
                        $output .= '<tr>
                             <td>'. $khachhang->id.'</td>
                            <td>'. $khachhang->tenkhachhang.'</td>
                            <td>'. $khachhang->ngaysinh.'</td>
                            <td>'. $khachhang->gioitinh.'</td>
                            <td>'. $khachhang->soCMND.'</td>
                            <td>'. $khachhang->diachi.'</td>
                            <td>'. $khachhang->sodienthoai.'</td>
                        </tr>';
                    }

                    $output .= '
                    </tbody>
                </table>
            </body>
            </html>';
        return $output;
    }

    function getViewSearchPDF(){
        if(!empty(session('querySearchKhachHang'))) $khachhang = DB::select(DB::raw(session('querySearchKhachHang')));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->data_to_html_search($khachhang));
        return $pdf->stream();
    }

    function data_to_html_search($khachhang){
       $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Khách hàng</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">DANH SÁCH KHÁCH HÀNG</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Họ tên</th>
                              <th>Ngày sinh</th>
                              <th>Giới tính</th>
                              <th>Số CMND</th>
                              <th>Địa chỉ</th>
                              <th>Số ĐT</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($khachhang as $khachhang) {
                        $output .= '<tr>
                             <td>'. $khachhang->id.'</td>
                            <td>'. $khachhang->tenkhachhang.'</td>
                            <td>'. $khachhang->ngaysinh.'</td>
                            <td>'. $khachhang->gioitinh.'</td>
                            <td>'. $khachhang->soCMND.'</td>
                            <td>'. $khachhang->diachi.'</td>
                            <td>'. $khachhang->sodienthoai.'</td>
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
        $pdf->loadHTML($this->data_to_html_thongTinKhachHang($id));
        return $pdf->stream();
    }

    function data_to_html_thongTinKhachHang($id){
        $khachhang = KhachHang::findOrFail($id);
        
        $output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>THÔNG TIN KHÁCH HÀNG</title>
                 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
                <style>
                *{ 
                    font-family: DejaVu Sans !important; 
                    font-size: 12px;
                }
            </style>
            </head>
            <body>
                <center><h1 style="color: red; font-weight: bold;">THÔNG TIN KHÁCH HÀNG</h1></center>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>ID</th>
                              <th>Họ tên</th>
                              <th>Ngày sinh</th>
                              <th>Giới tính</th>
                              <th>Số CMND</th>
                              <th>Địa chỉ</th>
                              <th>Số ĐT</th>
                        </tr>
                    </thead>
                    <tbody>';
                        $output .= '<tr>
                             <td>'. $khachhang->id.'</td>
                            <td>'. $khachhang->tenkhachhang.'</td>
                            <td>'. $khachhang->ngaysinh.'</td>
                            <td>'. $khachhang->gioitinh.'</td>
                            <td>'. $khachhang->soCMND.'</td>
                            <td>'. $khachhang->diachi.'</td>
                            <td>'. $khachhang->sodienthoai.'</td>
                        </tr>';

                    $output .= '
                    </tbody>
                </table>
            </body>
            </html>';
        return $output;
    }
}
