<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhuTung;
use App\ChiTietNhapPhuTung;

class ChiTietNhapPhuTungController extends Controller
{
	function getThem($id_nhapphutungphukien){
        $phutung = PhuTung::danhSachPhuTung();
		return view('chitietnhapphutungphukien.themphutung', compact('id_nhapphutungphukien', 'phutung'));
	}

    function postThem(Request $request, $id_nhapphutungphukien){
        $chitietnhapphutung = new ChiTietNhapPhuTung();
        $chitietnhapphutung->id_nhapphutungphukien = $id_nhapphutungphukien;
        $chitietnhapphutung->id_phutung = $request->id_phutung;
        $chitietnhapphutung->soluong = $request->soluong;
        $chitietnhapphutung->gianhap = $request->gianhap;
        $chitietnhapphutung->save();
        return redirect('nhapphutungphukien/'. $id_nhapphutungphukien.'/danhsachchitiet')->with('thongbaothem', "Thêm dữ liệu thành công!");
    } 

    function getSua($id_nhapphutungphukien, $id){
         $chitietnhapphutung = ChiTietNhapPhuTung::findOrFail($id);
         $phutung = PhuTung::danhSachPhuTung();
         $phutungtheoid = PhuTung::phuTungTheoID($chitietnhapphutung->id_phutung);
		return view('chitietnhapphutungphukien.suaphutung', compact('id_nhapphutungphukien', 'chitietnhapphutung', 'phutung', 'phutungtheoid'));
	}

    function postSua(Request $request, $id_nhapphutungphukien, $id){
        $chitietnhapphutung = ChiTietNhapPhuTung::findOrFail($id);
        $chitietnhapphutung->id_nhapphutungphukien = $id_nhapphutungphukien;
        $chitietnhapphutung->id_phutung = $request->id_phutung;
        $chitietnhapphutung->soluong = $request->soluong;
        $chitietnhapphutung->gianhap = $request->gianhap;
        $chitietnhapphutung->save();
        return redirect('nhapphutungphukien/'. $id_nhapphutungphukien.'/danhsachchitiet')->with('thongbaosua', "Sửa dữ liệu thành công!");
    }

    function getXoa($id_nhapphutungphukien, $id){
        $chitietnhapphutung = ChiTietNhapPhuTung::findOrFail($id);
        
        $chitietnhapphutung->delete();
        return redirect('nhapphutungphukien/'. $id_nhapphutungphukien.'/danhsachchitiet')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
    }
}
