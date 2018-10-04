<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NhanVien;
use App\ChucVu;
use DateTime;
use PDF;
use DB;
use Session;

class NhanVienController extends Controller
{
    function index(){
		$nhanvien = NhanVien::DanhSach();
		return view('nhanvien.danhsach', compact('nhanvien'));
	}

	function getSua($id){
		$nhanvien = NhanVien::findOrFail($id);
		$chucvu = ChucVu::danhSach();
		return view('nhanvien.sua', compact('nhanvien', 'chucvu'));
	}

	function getThem(){
		$chucvu = ChucVu::danhSach();
		return view('nhanvien.them',  compact('chucvu'));
	}

	function postThem(Request $request){
		$maxID = NhanVien::maxID();
		$nhanvien = new NhanVien();
		$nhanvien->hoten = $request->hoten;
		$nhanvien->ngaysinh =  DateTime::createFromFormat("m/d/Y" , $request->ngaysinh)->format('Y-m-d');
		$nhanvien->gioitinh = $request->gioitinh;
		$nhanvien->socmnd = $request->socmnd;
		$nhanvien->sodienthoai = $request->sodienthoai;
		$nhanvien->quequan = $request->quequan;
		$nhanvien->phucap = $request->phucap;
		$nhanvien->id_chucvu = $request->id_chucvu;
		$nhanvien->chuoibaomat = substr(md5(rand()), 0, 10).($maxID + 1);
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
				return redirect('nhanvien/them')->with('loi', 'Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
			}
			$name = time() . $file->getClientOriginalName();
			$file->move('uploads/user/', $name);
			$nhanvien->img = $name;
		}
		$nhanvien->save();
		return redirect('nhanvien')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$nhanvien = NhanVien::findOrFail($id);
		$nhanvien->hoten = $request->hoten;
		$nhanvien->ngaysinh =  DateTime::createFromFormat("m/d/Y" , $request->ngaysinh)->format('Y-m-d');
		$nhanvien->gioitinh = $request->gioitinh;
		$nhanvien->socmnd = $request->socmnd;
		$nhanvien->sodienthoai = $request->sodienthoai;
		$nhanvien->quequan = $request->quequan;
		$nhanvien->phucap = $request->phucap;
		$nhanvien->id_chucvu = $request->id_chucvu;
		$nhanvien->chuoibaomat = substr(md5(rand()), 0, 10).$id;
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
				return redirect('nhanvien/sua/' . $id)->with('loi', 'Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
			}
			$name = time() . $file->getClientOriginalName();
			$file->move('uploads/user/', $name);
			$nhanvien->img = $name;
		}
		$nhanvien->save();
		return redirect('nhanvien')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$nhanvien = NhanVien::findOrFail($id);
		 if (file_exists('uploads/user/' . $nhanvien->img)) {
            unlink('uploads/user/' . $nhanvien->img);
        }
		$nhanvien->delete();
		return redirect('nhanvien')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}

	function getViewPDF(){
		$nhanvien = NhanVien::all();
		// return $nhanvien;
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->data_to_html());
		return $pdf->stream();
	}

	function data_to_html(){
		$nhanvien = NhanVien::DanhSach();
		
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Document</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold;">DANH SÁCH NHÂN VIÊN</h1></center>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
						    <th>ID</th>
			                <th>Họ tên</th>
			                <th>Ngày sinh</th>
			                <th>Giới tính</th>
			                <th>Số CMND</th>
			                <th>Số ĐT</th>
			                <th>Quê quán</th>
			                <th>Chức vụ</th>
			               
			                <th>Lương</th>
						</tr>
					</thead>
					<tbody>';
					foreach ($nhanvien as $nhanvien) {
						$output .= '<tr>
							 <td>'. $nhanvien->id.'</td>
			                <td>'. $nhanvien->hoten.'</td>
			                <td>'. $nhanvien->ngaysinh.'</td>
			                <td>'. $nhanvien->gioitinh.'</td>
			                <td>'. $nhanvien->socmnd.'</td>
			                <td>'. $nhanvien->sodienthoai.'</td>
			                <td>'. $nhanvien->quequan.'</td>
			                <td>'. $nhanvien->tenchucvu.'</td>
			               
			                <td>'. number_format($nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap, 0, '', '.').'</td>
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
        $nhanvien = NhanVien::DanhSach();
        $chucvu = ChucVu::danhSach();
        return view('timkiem.nhanvien', compact('nhanvien', 'chucvu'));
    }

    function postTimKiem(Request $request){
    	$query = "
    	SELECT nhan_viens.id, hoten, ngaysinh, gioitinh, socmnd, sodienthoai, quequan, chuoibaomat, img,luongcoban,hesoluong, phucap, tenchucvu, id_chucvu
		FROM nhan_viens, chuc_vus
		WHERE nhan_viens.id_chucvu = chuc_vus.id
    	";

    	$where = "";
    	if($request->hoten != null){
            $where .= "((hoten like '%" . $request->hoten . "%')";
        }

        if($request->gioitinh != null){
            if($where == ''){
                $where .= "((gioitinh like '%" . $request->gioitinh . "%')";
            } else{
                $where .= ' ' . $request->radio1 . ' ' . "(gioitinh like '%" . $request->gioitinh . "%')";
            }
        }

        if($request->id_chucvu != null){
            if($where == ''){
                $where .= "((id_chucvu = " . $request->id_chucvu . ")";
            } else{
                $where .= ' ' . $request->radio2 . ' ' . "(id_chucvu = " . $request->id_chucvu . ")";
            }
        }

        if($request->quequan != null){
            if($where == ''){
                $where .= "((quequan like '%" . $request->quequan . "%')";
            } else{
                $where .= ' ' . $request->radio3 . ' ' . "(quequan like '%" . $request->quequan . "%')";
            }
        }

        if($request->namsinhtu != null && $request->namsinhden != null){
            if($where == ''){
                $where .= "((YEAR(ngaysinh) BETWEEN " . $request->namsinhtu . " AND " . $request->namsinhden . ")";
            } else{
                $where .= ' ' . $request->radio4 . ' ' . "((YEAR(ngaysinh) BETWEEN " . $request->namsinhtu . " AND " . $request->namsinhden . ")";
            }
        }

         if($request->luongtu != null && $request->luongden != null){
            if($where == ''){
                $where .= "(((luongcoban * hesoluong + phucap) BETWEEN " . $request->luongtu . " AND " . $request->luongden . ")";
            } else{
                $where .= ' ' . $request->radio5 . ' ' . "((luongcoban * hesoluong + phucap) BETWEEN " . $request->luongtu . " AND " . $request->luongden . ")";
            }
        }

        if($where != ""){
            $query .= " AND " . $where . ")";
            Session::put('querySearchNhanVien', $query);
        } else {
            Session::forget('querySearchNhanVien');
        }
        // return $query;
    	$nhanvien = DB::select(DB::raw($query));
    	$chucvu = ChucVu::danhSach();
        return view('timkiem.nhanvien', compact('nhanvien', 'chucvu', 'query'));
    }

    function getIn($id){
		$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
        ->where('nhan_viens.id', $id)
        ->get();
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->data_to_html_thongTinNhanVien($nhanvien));
		return $pdf->stream();
	}

	function data_to_html_thongTinNhanVien($nhanvien){
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>THÔNG TIN NHÂN VIÊN</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold;">THÔNG TIN NHÂN VIÊN</h1></center>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
						    <th>ID</th>
			                <th>Họ tên</th>
			                <th>Ngày sinh</th>
			                <th>Giới tính</th>
			                <th>Số CMND</th>
			                <th>Số ĐT</th>
			                <th>Quê quán</th>
			                <th>Chức vụ</th>
			                <th>Lương</th>
						</tr>
					</thead>
					<tbody>';
					foreach ($nhanvien as $nhanvien) {
						$output .= '<tr>
							 <td>'. $nhanvien->id.'</td>
			                <td>'. $nhanvien->hoten.'</td>
			                <td>'. $nhanvien->ngaysinh.'</td>
			                <td>'. $nhanvien->gioitinh.'</td>
			                <td>'. $nhanvien->socmnd.'</td>
			                <td>'. $nhanvien->sodienthoai.'</td>
			                <td>'. $nhanvien->quequan.'</td>
			                <td>'. $nhanvien->tenchucvu.'</td>
			               
			                <td>'. number_format($nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap, 0, '', '.').'</td>
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
    	$query = session('querySearchNhanVien');
		$nhanvien = DB::select(DB::raw($query));
		// return $nhanvien;
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->data_to_html_search($nhanvien));
		return $pdf->stream();
	}

	function data_to_html_search($nhanvien){
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Document</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold;">DANH SÁCH NHÂN VIÊN</h1></center>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
						    <th>ID</th>
			                <th>Họ tên</th>
			                <th>Ngày sinh</th>
			                <th>Giới tính</th>
			                <th>Số CMND</th>
			                <th>Số ĐT</th>
			                <th>Quê quán</th>
			                <th>Chức vụ</th>
			               
			                <th>Lương</th>
						</tr>
					</thead>
					<tbody>';
					foreach ($nhanvien as $nhanvien) {
						$output .= '<tr>
							 <td>'. $nhanvien->id.'</td>
			                <td>'. $nhanvien->hoten.'</td>
			                <td>'. $nhanvien->ngaysinh.'</td>
			                <td>'. $nhanvien->gioitinh.'</td>
			                <td>'. $nhanvien->socmnd.'</td>
			                <td>'. $nhanvien->sodienthoai.'</td>
			                <td>'. $nhanvien->quequan.'</td>
			                <td>'. $nhanvien->tenchucvu.'</td>
			               
			                <td>'. number_format($nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap, 0, '', '.').'</td>
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
		return view('thongkenhanvien.nhanvien');
	}

	function getThongKeChucVu(){
		$nhanvien = NhanVien::danhSach();
		$chucvu = ChucVu::all();
		return view('thongkenhanvien.chucvu', compact('nhanvien','chucvu'));
	}

	function postThongKeChucVu(Request $request){
		$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
        ->where('nhan_viens.id_chucvu', $request->chucvu)
        ->get();
        $sum = $nhanvien->count();
        if($sum > 0){
        	Session::put('queryThongKeChucVu', $nhanvien);
        } else {
        	 Session::forget('queryThongKeChucVu');
        }
        $count = NhanVien::all()->count();
        $tile = round($sum / $count * 100, 2);
       $chucvu = ChucVu::all();
		return view('thongkenhanvien.chucvu', compact('nhanvien','chucvu', 'sum', 'tile'));
	}

	function getxemThongKeChucVuPDF(){
    	// $query = session('queryThongKeChucVu');
		// $nhanvien = DB::select(DB::raw($query));
		$nhanvien = session('queryThongKeChucVu');;
		// return $nhanvien;
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->data_to_html_thongKeChucVu($nhanvien));
		return $pdf->stream();
	}

	function data_to_html_thongKeChucVu($nhanvien){
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Document</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold; text-transform: uppercase;">DANH SÁCH NHÂN VIÊN <br> CÓ CHỨC VỤ '.  $nhanvien[0]->tenchucvu .'</h1></center>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
						    <th>ID</th>
			                <th>Họ tên</th>
			                <th>Ngày sinh</th>
			                <th>Giới tính</th>
			                <th>Số CMND</th>
			                <th>Số ĐT</th>
			                <th>Quê quán</th>
			                <th>Lương</th>
						</tr>
					</thead>
					<tbody>';
					foreach ($nhanvien as $nhanvien) {
						$output .= '<tr>
							 <td>'. $nhanvien->id.'</td>
			                <td>'. $nhanvien->hoten.'</td>
			                <td>'. $nhanvien->ngaysinh.'</td>
			                <td>'. $nhanvien->gioitinh.'</td>
			                <td>'. $nhanvien->socmnd.'</td>
			                <td>'. $nhanvien->sodienthoai.'</td>
			                <td>'. $nhanvien->quequan.'</td>			               
			                <td>'. number_format($nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap, 0, '', '.').'</td>
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
