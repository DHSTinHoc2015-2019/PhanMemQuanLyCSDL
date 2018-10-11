<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KhachHang;
use App\ChiTietHoaDonBanPhuTung;
use App\ChiTietHoaDonBanPhuKien;
use Auth;
use DateTime;
use App\HoaDonBanPhuTungPhuKien;

class HoaDonBanPhuTungPhuKienController extends Controller
{
     function index(){
    	$hoadonbanphutungphukien = HoaDonBanPhuTungPhuKien::danhSachHoaDonBanPhuTungPhuKien();
        return view('hoadonbanphutungphukien.danhsach', compact('hoadonbanphutungphukien'));
    } 

    function danhsachchitiet($id_banphutungphukien){
        $chitiethoadonbanphutung = ChiTietHoaDonBanPhuTung::danhSachChiTietHoaDonBanPhuTung($id_banphutungphukien);
    	$chitiethoadonbanphukien = ChiTietHoaDonBanPhuKien::danhSachChiTietHoaDonBanPhuKien($id_banphutungphukien);
        return view('chitiethoadonbanphutungphukien.danhsach', compact('chitiethoadonbanphutung', 'id_banphutungphukien', 'chitiethoadonbanphukien'));
    }

    function getThem(){
    	$khachhang = KhachHang::orderBy('id', 'desc')->get();
		return view('hoadonbanphutungphukien.them', compact('khachhang'));
	}

    function getSua($id){
    	$khachhang = KhachHang::orderBy('id', 'desc')->get();
    	$hoadonbanphutungphukien = HoaDonBanPhuTungPhuKien::hoaDonBanPhuTungPhuKienTheoID($id);
		return view('hoadonbanphutungphukien.sua', compact('hoadonbanphutungphukien', 'khachhang'));
	}

	function postThem(Request $request){
		$hoadonbanphutungphukien = new HoaDonBanPhuTungPhuKien();
        $hoadonbanphutungphukien->id_khachhang = $request->id_khachhang;
        $hoadonbanphutungphukien->id_nhanvien = Auth::User()->id;
        $hoadonbanphutungphukien->save();
        return redirect('hoadonbanphutungphukien')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$hoadonbanphutungphukien = HoaDonBanPhuTungPhuKien::findOrFail($id);
        $hoadonbanphutungphukien->id_khachhang = $request->id_khachhang;
        $hoadonbanphutungphukien->id_nhanvien = Auth::User()->id;
        $hoadonbanphutungphukien->created_at = DateTime::createFromFormat("m/d/Y" , $request->created_at)->format('Y-m-d');
        $hoadonbanphutungphukien->save();
        return redirect('hoadonbanphutungphukien')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$hoadonbanphutungphukien = HoaDonBanPhuTungPhuKien::findOrFail($id);
        $hoadonbanphutungphukien->delete();
        return redirect('hoadonbanphutungphukien')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}
}
