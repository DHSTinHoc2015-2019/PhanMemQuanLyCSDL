<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NhapPhuTungPhuKien;
use App\NhaCungCap;
use App\ChiTietNhapPhuTung;
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
        return view('chitietnhapphutungphukien.danhsach', compact('chitietnhapphutung', 'id_nhapphutungphukien'));
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
}
