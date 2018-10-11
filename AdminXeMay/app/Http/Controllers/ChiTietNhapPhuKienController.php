<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhuKien;
use App\ChiTietNhapPhuKien;

class ChiTietNhapPhuKienController extends Controller
{
    function getThem($id_nhapphutungphukien){
        $phukien = PhuKien::danhSachPhuKien();
		return view('chitietnhapphutungphukien.themphukien', compact('id_nhapphutungphukien', 'phukien'));
	}

    function postThem(Request $request, $id_nhapphutungphukien){
        $chitietnhapphukien = new ChiTietNhapPhuKien();
        $chitietnhapphukien->id_nhapphutungphukien = $id_nhapphutungphukien;
        $chitietnhapphukien->id_phukien = $request->id_phukien;
        $chitietnhapphukien->soluongnhap = $request->soluong;
        $chitietnhapphukien->gianhap = $request->gianhap;
        $chitietnhapphukien->save();
        return redirect('nhapphutungphukien/'. $id_nhapphutungphukien.'/danhsachchitiet')->with('thongbaothem', "Thêm dữ liệu thành công!");
    } 

    function getSua($id_nhapphutungphukien, $id){
         $chitietnhapphukien = ChiTietNhapPhuKien::findOrFail($id);
         $phukien = PhuKien::danhSachPhuKien();
         $phukientheoid = PhuKien::phuKienTheoID($chitietnhapphukien->id_phukien);
		return view('chitietnhapphutungphukien.suaphukien', compact('id_nhapphutungphukien', 'chitietnhapphukien', 'phukien', 'phukientheoid'));
	}

    function postSua(Request $request, $id_nhapphutungphukien, $id){
        $chitietnhapphukien = ChiTietNhapPhuKien::findOrFail($id);
        $chitietnhapphukien->id_nhapphutungphukien = $id_nhapphutungphukien;
        $chitietnhapphukien->id_phukien = $request->id_phukien;
        $chitietnhapphukien->soluongnhap = $request->soluong;
        $chitietnhapphukien->gianhap = $request->gianhap;
        $chitietnhapphukien->save();
        return redirect('nhapphutungphukien/'. $id_nhapphutungphukien.'/danhsachchitiet')->with('thongbaosua', "Sửa dữ liệu thành công!");
    }

    function getXoa($id_nhapphutungphukien, $id){
        $chitietnhapphukien = ChiTietNhapPhuKien::findOrFail($id);
        
        $chitietnhapphukien->delete();
        return redirect('nhapphutungphukien/'. $id_nhapphutungphukien.'/danhsachchitiet')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
    }
}
