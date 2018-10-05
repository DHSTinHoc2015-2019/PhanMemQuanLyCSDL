<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\XeMay;
use App\LoaiPhuTung;
use App\PhuTung;
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
}
