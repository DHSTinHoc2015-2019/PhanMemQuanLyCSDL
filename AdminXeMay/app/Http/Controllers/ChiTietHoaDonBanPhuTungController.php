<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhuTung;
use App\ChiTietHoaDonBanPhuTung;

class ChiTietHoaDonBanPhuTungController extends Controller
{
    function getThem($id_banphutungphukien){
        $phutung = PhuTung::danhSachPhuTung();
		return view('chitiethoadonbanphutungphukien.themphutung', compact('id_banphutungphukien', 'phutung'));
	}

    function postThem(Request $request, $id_banphutungphukien){
        $chitiethoadonbanphutung = new ChiTietHoaDonBanPhuTung();
        $chitiethoadonbanphutung->id_banphutungphukien = $id_banphutungphukien;
        $chitiethoadonbanphutung->id_phutung = $request->id_phutung;
        $chitiethoadonbanphutung->soluongban = $request->soluongban;
        $chitiethoadonbanphutung->dongiaban = $request->dongiaban;
        $chitiethoadonbanphutung->save();
        return redirect('hoadonbanphutungphukien/'. $id_banphutungphukien.'/danhsachchitiet')->with('thongbaothem', "Thêm dữ liệu thành công!");
    } 

    function getSua($id_banphutungphukien, $id){
         $chitiethoadonbanphutung = ChiTietHoaDonBanPhuTung::findOrFail($id);
         $phutung = PhuTung::danhSachPhuTung();
         $phutungtheoid = PhuTung::phuTungTheoID($chitiethoadonbanphutung->id_phutung);
		return view('chitiethoadonbanphutungphukien.suaphutung', compact('id_banphutungphukien', 'chitiethoadonbanphutung', 'phutung', 'phutungtheoid'));
	}

    function postSua(Request $request, $id_banphutungphukien, $id){
        $chitiethoadonbanphutung = ChiTietHoaDonBanPhuTung::findOrFail($id);
        $chitiethoadonbanphutung->id_banphutungphukien = $id_banphutungphukien;
        $chitiethoadonbanphutung->id_phutung = $request->id_phutung;
        $chitiethoadonbanphutung->soluongban = $request->soluongban;
        $chitiethoadonbanphutung->dongiaban = $request->dongiaban;
        $chitiethoadonbanphutung->save();
        return redirect('hoadonbanphutungphukien/'. $id_banphutungphukien.'/danhsachchitiet')->with('thongbaosua', "Sửa dữ liệu thành công!");
    }

    function getXoa($id_banphutungphukien, $id){
         $chitiethoadonbanphutung = ChiTietHoaDonBanPhuTung::findOrFail($id);
        
        $chitiethoadonbanphutung->delete();
        return redirect('hoadonbanphutungphukien/'. $id_banphutungphukien.'/danhsachchitiet')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
    }
}
