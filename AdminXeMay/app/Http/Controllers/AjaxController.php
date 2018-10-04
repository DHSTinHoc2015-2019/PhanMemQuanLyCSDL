<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\XeMay;
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
}
