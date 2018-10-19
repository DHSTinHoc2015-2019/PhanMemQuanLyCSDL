<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NhanVien;
use App\ChucVu;
use DateTime;
use PDF;
use DB;
use Session;
use Carbon\Carbon;
use Charts;
use App\User;
use App\Charts\NhanVien_Chart;

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
    	$toantu = "";
    	if($request->has("AND")) $toantu .= " AND ";
    	else $toantu .= " OR ";

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
                $where .= ' ' . $toantu . ' ' . "(gioitinh like '%" . $request->gioitinh . "%')";
            }
        }

        if($request->id_chucvu != null){
            if($where == ''){
                $where .= "((id_chucvu = " . $request->id_chucvu . ")";
            } else{
                $where .= ' ' . $toantu . ' ' . "(id_chucvu = " . $request->id_chucvu . ")";
            }
        }

        if($request->quequan != null){
            if($where == ''){
                $where .= "((quequan like '%" . $request->quequan . "%')";
            } else{
                $where .= ' ' . $toantu . ' ' . "(quequan like '%" . $request->quequan . "%')";
            }
        }

        if($request->namsinhtu != null && $request->namsinhden != null){
            if($where == ''){
                $where .= "((YEAR(ngaysinh) BETWEEN " . $request->namsinhtu . " AND " . $request->namsinhden . ")";
            } else{
                $where .= ' ' . $toantu . ' ' . "((YEAR(ngaysinh) BETWEEN " . $request->namsinhtu . " AND " . $request->namsinhden . "))";
            }
        }

         if($request->luongtu != null && $request->luongden != null){
            if($where == ''){
                $where .= "(((luongcoban * hesoluong + phucap) BETWEEN " . $request->luongtu . " AND " . $request->luongden . ")";
            } else{
                $where .= ' ' . $toantu . ' ' . "((luongcoban * hesoluong + phucap) BETWEEN " . $request->luongtu . " AND " . $request->luongden . ")";
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
		$countNhanVien = NhanVien::count();
		
		$chucvu = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->groupBy('tenchucvu')
        ->get([
	      DB::raw('tenchucvu as tenchucvu'),
	      DB::raw('COUNT(*) as soluong')
	    ]);
	    $labelsChucVu = $chucvu->pluck('tenchucvu');
        $valuesChucVu = $chucvu->pluck('soluong');
        $chartChucVu = new NhanVien_Chart();
        $chartChucVu->labels($labelsChucVu);
        $chartChucVu->loaderColor('rgb(255, 99, 132)');
  		
        $chartChucVu->dataset('số lượng', 'bar', $valuesChucVu)->color('rgb(255, 99, 132)')->backgroundColor('rgb(255, 99, 132)');

        /* Giới tính */

        $gioitinh = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->groupBy('gioitinh')
        ->get([
	      DB::raw('gioitinh as gioitinh'),
	      DB::raw('COUNT(*)/'.$countNhanVien.'*100 as soluong')
	    ]);

	    $labelsGioiTinh = $gioitinh->pluck('gioitinh');

        $valuesGioiTinh = $gioitinh->pluck('soluong');

        $chartGioiTinh = new NhanVien_Chart();
        $chartGioiTinh->labels($labelsGioiTinh);
        $chartGioiTinh->loaderColor('rgb(255, 99, 132)');
  		
        $chartGioiTinh->dataset('số lượng', 'pie', $valuesGioiTinh)->backgroundColor(['red', 'blue']);

        /* Tuổi */
        $tuoi20_30 = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->whereYear('ngaysinh', '>=', Carbon::now()->year - 30)
        ->whereYear('ngaysinh', '<=', Carbon::now()->year - 20)
        ->count();
        $tuoi30_40 = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->whereYear('ngaysinh', '>=', Carbon::now()->year - 40)
        ->whereYear('ngaysinh', '<=', Carbon::now()->year - 30)
        ->count();
        $tuoi40_50 = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->whereYear('ngaysinh', '>=', Carbon::now()->year - 50)
        ->whereYear('ngaysinh', '<=', Carbon::now()->year - 40)
        ->count();
		$tuoi50_60 = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->whereYear('ngaysinh', '>=', Carbon::now()->year - 60)
        ->whereYear('ngaysinh', '<=', Carbon::now()->year - 50)
        ->count();

        $arrTuoi = [$tuoi20_30, $tuoi30_40, $tuoi40_50, $tuoi50_60];

        $chartTuoi = new NhanVien_Chart();
        $chartTuoi->labels(['20 - 30 tuổi','30 - 40 tuổi','40 - 50 tuổi','50 - 60 tuổi']);
        $chartTuoi->loaderColor('rgb(255, 99, 132)');
  		
        $chartTuoi->dataset('Số lượng', 'bar', $arrTuoi)->color('black')->backgroundColor('blue');

         /* Lương */
        $luong0_5 = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->whereRaw('luongcoban * hesoluong + phucap >= '. 0)
        ->whereRaw('luongcoban * hesoluong + phucap < '. 5000000)
        ->count();
		$luong5_10 = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->whereRaw('luongcoban * hesoluong + phucap >= '. 5000000)
        ->whereRaw('luongcoban * hesoluong + phucap < '. 10000000)
        ->count();
		$luong10_20 = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->whereRaw('luongcoban * hesoluong + phucap >= '. 10000000)
        ->whereRaw('luongcoban * hesoluong + phucap < '. 20000000)
        ->count();
		$luong20_30 = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->whereRaw('luongcoban * hesoluong + phucap >= '. 20000000)
        ->whereRaw('luongcoban * hesoluong + phucap < '. 30000000)
        ->count();
		$luong30_40 = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->whereRaw('luongcoban * hesoluong + phucap >= '. 30000000)
        ->whereRaw('luongcoban * hesoluong + phucap < '. 40000000)
        ->count();
        $luong40_ = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->whereRaw('luongcoban * hesoluong + phucap >= '. 40000000)
        ->count();


        $arrLuong = [$luong0_5, $luong5_10, $luong10_20, $luong20_30, $luong30_40, $luong40_];

        $chartLuong = new NhanVien_Chart();
        $chartLuong->labels(['< 5 triệu','5 - 10 triệu','10 - 20 triệu','20 - 30 triệu','30 - 40 triệu', '> 40 triệu']);
        $chartLuong->loaderColor('rgb(255, 99, 132)');
  		
        $chartLuong->dataset('Số lượng', 'bar', $arrLuong)->color('black')->backgroundColor('yellow');
		return view('thongkenhanvien.nhanvien', compact('chartChucVu', 'chartGioiTinh', 'chartTuoi', 'chartLuong'));
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
        $tenchucvu = "";
        if($sum > 0){
        	Session::put('queryThongKeChucVu', $nhanvien);
        	$tenchucvu = $nhanvien[0]->tenchucvu;
        } else {
        	 Session::forget('queryThongKeChucVu');
        }
        $count = NhanVien::all()->count();
        $tile = round($sum / $count * 100, 2);
        $chucvu = ChucVu::all();
		return view('thongkenhanvien.chucvu', compact('nhanvien','chucvu', 'sum', 'tile', 'tenchucvu'));
	}

	function getxemThongKeChucVuPDF(){
    	// $query = session('queryThongKeChucVu');
		// $nhanvien = DB::select(DB::raw($query));
		$nhanvien = session('queryThongKeChucVu');
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
				<title>Danh sách thống kê nhân viên</title>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>
			</body>
			</html>';
		return $output;
	}

	function getxemThongKeToanBoChucVuPDF(){
		$pdf = \App::make('dompdf.wrapper');
		// $chucvu = ChucVu::distinct()->select('tenchucvu')->get()[0]->tenchucvu;
		// return $chucvu;
		$pdf->loadHTML($this->data_to_html_thongKeToanBoChucVu());
		return $pdf->stream();
	}

	function data_to_html_thongKeToanBoChucVu(){
		$chucvu = ChucVu::distinct()->select('tenchucvu')->get();
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Danh sách thống kê nhân viên</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
				#hrstyle{
					overflow: visible;
					padding: 0;
					border: none;
					border-top: medium double #333;
					color: #333;
					text-align: center;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold; text-transform: uppercase;">DANH SÁCH NHÂN VIÊN THEO CHỨC VỤ</h1></center>';
				foreach ($chucvu as $chucvu) {
					 $nhanvien = NhanVien::danhSachTheoChucVu($chucvu->tenchucvu);
					 $output .= '<hr id="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$chucvu->tenchucvu.'</h2>';
					 $output .= '<table class="table table-bordered table-hover">
					<thead>
						<tr class="table-success">
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}
					$output .= '
					</tbody>

				</table>
				<h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>';
				}
				
				$output .='
					
			</body>
			</html>';
		return $output;
	}


	function getThongKeGioiTinh(){
		$nhanvien = NhanVien::danhSach();
		$chucvu = ChucVu::all();
		return view('thongkenhanvien.gioitinh', compact('nhanvien','chucvu'));
	}

	function postThongKeGioiTinh(Request $request){
		$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
        ->where('gioitinh','like', "%". $request->gioitinh ."%")
        ->get();
        $sum = $nhanvien->count();
        $gioitinh = "";
        if($sum > 0){
        	Session::put('queryThongKeGioiTinh', $nhanvien);
        	$gioitinh = $request->gioitinh;
        } else {
        	 Session::forget('queryThongKeGioiTinh');
        }
        $count = NhanVien::all()->count();
        $tile = round($sum / $count * 100, 2);
		return view('thongkenhanvien.gioitinh', compact('nhanvien', 'sum', 'tile', 'gioitinh'));
	}

	function getxemThongKeGioiTinhPDF(){
		$nhanvien = session('queryThongKeGioiTinh');;
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->data_to_html_thongKeGioiTinh($nhanvien));
		return $pdf->stream();
	}

	function data_to_html_thongKeGioiTinh($nhanvien){
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Danh sách thống kê nhân viên</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold; text-transform: uppercase;">DANH SÁCH NHÂN VIÊN <br> CÓ GIỚI TÍNH '.  $nhanvien[0]->gioitinh .'</h1></center>
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
					$i = 0; $luong = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
					}

					$output .= '
					</tbody>

				</table>
				<h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ</h6>
			</body>
			</html>';
		return $output;
	}

	function getxemThongKeToanBoGioiTinhPDF(){
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->data_to_html_thongKeToanBoGioiTinh());
		return $pdf->stream();
	}

	function data_to_html_thongKeToanBoGioiTinh(){
		$gioitinh = NhanVien::distinct()->select('gioitinh')->get();
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Danh sách thống kê nhân viên</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
				#hrstyle{
					overflow: visible;
					padding: 0;
					border: none;
					border-top: medium double #333;
					color: #333;
					text-align: center;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold; text-transform: uppercase;">DANH SÁCH NHÂN VIÊN THEO GIỚI TÍNH</h1></center>';
				foreach ($gioitinh as $gioitinh) {
					 $nhanvien = NhanVien::danhSachTheoGioiTinh($gioitinh->gioitinh);
					 $output .= '<hr id="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">'.$gioitinh->gioitinh.'</h2>';
					 $output .= '<table class="table table-bordered table-hover">
					<thead>
						<tr class="table-success">
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
					$i = 0; $luong = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
					}
					$output .= '
					</tbody>

				</table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ</h6>';
				}
				
				$output .='
					
			</body>
			</html>';
		return $output;
	}

	function getThongKeTuoi(){
		$nhanvien = NhanVien::danhSach();
		return view('thongkenhanvien.tuoi', compact('nhanvien'));
	}

	function postThongKeTuoi(Request $request){
		$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
        ->whereYear('ngaysinh', '>=', Carbon::now()->year - $request->tuoiden)
        ->whereYear('ngaysinh', '<=', Carbon::now()->year - $request->tuoitu)
        ->get();
        $sum = $nhanvien->count();
        $tuoi = "";
        if($sum > 0){
        	Session::put('queryThongKeTuoi', $nhanvien);
        	$tuoi = $request->tuoitu . " đến " .$request->tuoiden;
        } else {
        	 Session::forget('queryThongKeTuoi');
        }
        $count = NhanVien::all()->count();
        $tile = round($sum / $count * 100, 2);
		return view('thongkenhanvien.tuoi', compact('nhanvien', 'sum', 'tile', 'tuoi'));
	}

	function getxemThongKeTuoiPDF(){
		$nhanvien = session('queryThongKeTuoi');;
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->data_to_html_thongKeTuoi($nhanvien));
		return $pdf->stream();
	}

	function data_to_html_thongKeTuoi($nhanvien){
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Danh sách thống kê nhân viên</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold; text-transform: uppercase;">DANH SÁCH NHÂN VIÊN</h1></center>
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

	function getThongKeLuong(){
		$nhanvien = NhanVien::danhSach();
		return view('thongkenhanvien.luong', compact('nhanvien'));
	}

	function postThongKeLuong(Request $request){
		$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
        ->whereRaw('luongcoban * hesoluong + phucap >= '. $request->luongtu)
        ->whereRaw('luongcoban * hesoluong + phucap <= '. $request->luongden)
        ->get();
        // return $nhanvien;
        $sum = $nhanvien->count();
        $luong = "";
        if($sum > 0){
        	Session::put('queryThongKeLuong', $nhanvien);
        	$luong = $request->luongtu . " đến " .$request->luongden;
        } else {
        	 Session::forget('queryThongKeLuong');
        }
        $count = NhanVien::all()->count();
        $tile = round($sum / $count * 100, 2);
		return view('thongkenhanvien.luong', compact('nhanvien', 'sum', 'tile', 'luong'));
	}

	function getxemThongKeLuongPDF(){
		$nhanvien = session('queryThongKeLuong');;
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->data_to_html_thongKeLuong($nhanvien));
		return $pdf->stream();
	}

	function data_to_html_thongKeLuong($nhanvien){
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Danh sách thống kê nhân viên</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold; text-transform: uppercase;">DANH SÁCH NHÂN VIÊN</h1></center>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>
			</body>
			</html>';
		return $output;
	}

	function getxemThongKeToanBoLuongPDF(){
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->data_to_html_thongKeToanBoLuong());
		return $pdf->stream();
	}

	function data_to_html_thongKeToanBoLuong(){
		$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
        ->whereRaw('luongcoban * hesoluong + phucap >= 1000000')
        ->whereRaw('luongcoban * hesoluong + phucap <= 10000000')
        ->get();
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Danh sách thống kê nhân viên</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
				.hrstyle{
					overflow: visible;
					padding: 0;
					border: none;
					border-top: medium double #333;
					color: #333;
					text-align: center;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold; text-transform: uppercase;">DANH SÁCH NHÂN VIÊN</h1></center>
				<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Lương từ 1.000.000đ - 10.000.000đ</h2>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>';

				$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
		        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
		        ->whereRaw('luongcoban * hesoluong + phucap >= 10000000')
		        ->whereRaw('luongcoban * hesoluong + phucap <= 20000000')
		        ->get();

		        $output .='<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Lương từ 10.000.000đ - 20.000.000đ</h2>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>';
				$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
		        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
		        ->whereRaw('luongcoban * hesoluong + phucap >= 20000000')
		        ->whereRaw('luongcoban * hesoluong + phucap <= 30000000')
		        ->get();

		        $output .='<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Lương từ 20.000.000đ - 30.000.000đ</h2>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>';
				$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
		        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
		        ->whereRaw('luongcoban * hesoluong + phucap >= 30000000')
		        ->whereRaw('luongcoban * hesoluong + phucap <= 40000000')
		        ->get();

		        $output .='<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Lương từ 30.000.000đ - 40.000.000đ</h2>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table></table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>';
				$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
		        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
		        ->whereRaw('luongcoban * hesoluong + phucap >= 40000000')
		        ->whereRaw('luongcoban * hesoluong + phucap <= 50000000')
		        ->get();

		        $output .='<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Lương từ 40.000.000đ - 50.000.000đ</h2>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>';
				$output .= '
			</body>
			</html>';
		return $output;
	}

	function getxemThongKeToanBoTuoiPDF(){
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->data_to_html_thongKeToanBoTuoi());
		return $pdf->stream();
	}

	function data_to_html_thongKeToanBoTuoi(){
		$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
		->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
        ->whereYear('ngaysinh', '>=', Carbon::now()->year - 30)
        ->whereYear('ngaysinh', '<=', Carbon::now()->year - 20)
        ->get();
		$output = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Danh sách thống kê nhân viên</title>
				 <link rel="stylesheet" href="bower_components/bootstrap4.1/dist/css/bootstrap.css">
				<style>
				*{ 
					font-family: DejaVu Sans !important; 
					font-size: 12px;
				}
				.hrstyle{
					overflow: visible;
					padding: 0;
					border: none;
					border-top: medium double #333;
					color: #333;
					text-align: center;
				}
			</style>
			</head>
			<body>
				<center><h1 style="color: red; font-weight: bold; text-transform: uppercase;">DANH SÁCH NHÂN VIÊN</h1></center>
				<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Từ 20 - 30 tuổi</h2>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>';

				$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
				->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
		        ->whereYear('ngaysinh', '>=', Carbon::now()->year - 40)
		        ->whereYear('ngaysinh', '<=', Carbon::now()->year - 30)
		        ->get();
		        $output .='<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Từ 30 - 40 tuổi</h2>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>';

				$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
				->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
		        ->whereYear('ngaysinh', '>=', Carbon::now()->year - 50)
		        ->whereYear('ngaysinh', '<=', Carbon::now()->year - 40)
		        ->get();

		        $output .='<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Từ 40 - 50 tuổi</h2>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table></table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>';
				
				$nhanvien = NhanVien::join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
				->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
		        ->whereYear('ngaysinh', '<=', Carbon::now()->year - 50)
		        ->get();

		        $output .='<hr class="hrstyle" style="margin-top: 2em;"><h2 style="text-transform: uppercase;">Trên 50 tuổi</h2>
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
					$i = 0; $luong = 0; $nhanviennam = 0; $nhanviennu = 0;
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
						$i++; 
						$luong += $nhanvien->luongcoban * $nhanvien->hesoluong + $nhanvien->phucap;
						if($nhanvien->gioitinh == 'Nam') $nhanviennam++;
						else $nhanviennu++;
					}

					$output .= '
					</tbody>

				</table><h6 style="color:red;">Tổng nhân viên: '.$i."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&nbsp;"."&nbsp;".'Tổng lương: '.number_format($luong, 0, '', '.').'đ<br>Tổng nhân viên nam: '.$nhanviennam."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;"."&emsp;".'Tổng nhân viên nữ: '.$nhanviennu.'</h6>';
				$output .= '
			</body>
			</html>';
		return $output;
	}
}
