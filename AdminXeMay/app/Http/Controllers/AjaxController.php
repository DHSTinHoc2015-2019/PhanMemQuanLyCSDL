<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\XeMay;
use App\LoaiPhuTung;
use App\PhuTung;
use App\PhuKien;
use DB;

class AjaxController extends Controller
{
    function getImgXeMay($id_xemay){
		$xemay = XeMay::findOrFail($id_xemay);
		$str = "";
		$str .= '<div class="form-group">
		<label>Hình ảnh xe máy</label>
		<img src="uploads/xemay/';
		$str .= $xemay->img;
		$str .= '" id="profile-img-tag" width="300px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
		</div>';
		return $str;
	}

	function getImgHoaDonXeMay($id_xemay){
		$xemay = XeMay::findOrFail($id_xemay);
		$str = "";
		$str .= '<div class="form-group">
            <label>Màu xe</label>
            <input type="text" class="form-control" placeholder="" name="mauxe" required="" disabled="" value="'.$xemay->mauxe.'"></div>';
        $str .= '<div class="form-group">
            <label>Đơn giá bán</label>
            <input type="number" class="form-control" placeholder="" name="dongiaban" required="" value="'.$xemay->dongia.'" id="dongia"></div>';
		$str .= '<div class="form-group">
		<label>Hình ảnh xe máy</label>
		<img src="uploads/xemay/';
		$str .= $xemay->img;
		$str .= '" id="profile-img-tag" width="300px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
		</div>';
		$str .= '<script>var dongia = document.getElementById("dongia");</script>';
		return $str;
	}

	function getImgPhuTung($id_loaiphutung){
		$loaiphutung = LoaiPhuTung::findOrFail($id_loaiphutung);
		$str = "";
		$str .= '<div class="form-group">
		<label>Hình ảnh phụ tùng</label>
		<img src="uploads/phutung/';
		$str .= $loaiphutung->imgphutung;
		$str .= '" id="profile-img-tag" width="300px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
		</div>';
		return $str;
	}

	function getImgPhuTungBangPhuTung($id_phutung){
		$phutung = PhuTung::PhuTungTheoID($id_phutung);
		$str = "";
		$str .= '<div class="form-group">
		<label>Hình ảnh phụ tùng</label>
		<img src="uploads/phutung/';
		$str .= $phutung->imgphutung;
		$str .= '" id="profile-img-tag" width="300px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
		</div>';
		return $str;
	}

	function getImgPhuTungBangPhuTungHoaDon($id_phutung){
		$phutung = PhuTung::PhuTungTheoID($id_phutung);
		$str = "";
		$str .= '<div class="form-group">
                  <label>Giá bán</label>
                  <input type="number" class="form-control" placeholder="Nhập giá" name="dongiaban" value="'.$phutung->dongia.'">
                </div>';
		$str .= '<div class="form-group">
		<label>Hình ảnh phụ tùng</label>
		<img src="uploads/phutung/';
		$str .= $phutung->imgphutung;
		$str .= '" id="profile-img-tag" width="300px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
		</div>';
		return $str;
	}

	function getImgPhuKienBangPhuKien($id_phukien){
		$phukien = PhuKien::PhuKienTheoID($id_phukien);
		$str = "";
		$str .= '<div class="form-group">
		<label>Hình ảnh phụ kiện</label>
		<img src="uploads/phukien/';
		$str .= $phukien->imgphukien;
		$str .= '" id="profile-img-tag" width="300px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
		</div>';
		return $str;
	}

	function getImgPhuKienBangPhuKienHoaDon($id_phukien){
		$phukien = PhuKien::PhuKienTheoID($id_phukien);
		$str = "";
		$str .= ' <div class="form-group">
                  <label>Giá bán</label>
                  <input type="number" class="form-control" placeholder="Nhập giá" name="dongiaban" value="'.$phukien->dongia.'">
                </div>';
		$str .= '<div class="form-group">
		<label>Hình ảnh phụ kiện</label>
		<img src="uploads/phukien/';
		$str .= $phukien->imgphukien;
		$str .= '" id="profile-img-tag" width="300px" style="display: block; margin-left: auto; margin-right: auto;" />                                        
		</div>';
		return $str;
	}

	function getThongKeXeMayTheoGia($gia){
		$arrGia = explode('-', $gia);

	    $dongia10_20 = DB::table('xe_mays')
	    ->select(DB::raw('concat(tenxe, \' \', mauxe) as ten'),  DB::raw('SUM(soluong) as soluong'))
	    ->groupBy('tenxe', 'mauxe')
	    ->where('dongia', '>', $arrGia[0])
	    ->where('dongia', '<=', $arrGia[1])
	    ->get()->toJSON();;
	    return $dongia10_20;
	}
}
