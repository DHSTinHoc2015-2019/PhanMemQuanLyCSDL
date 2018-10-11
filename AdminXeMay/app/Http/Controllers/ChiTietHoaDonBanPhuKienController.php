<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhuKien;
use App\ChiTietHoaDonBanPhuKien;

class ChiTietHoaDonBanPhuKienController extends Controller
{
    function getThem($id_banphutungphukien){
        $phukien = PhuKien::danhSachPhuKien();
		return view('chitiethoadonbanphutungphukien.themphukien', compact('id_banphutungphukien', 'phukien'));
	}

    function postThem(Request $request, $id_banphutungphukien){
        $chitiethoadonbanphukien = new ChiTietHoaDonBanPhuKien();
        $chitiethoadonbanphukien->id_banphutungphukien = $id_banphutungphukien;
        $chitiethoadonbanphukien->id_phukien = $request->id_phukien;
        $chitiethoadonbanphukien->soluongban = $request->soluongban;
        $chitiethoadonbanphukien->dongiaban = $request->dongiaban;
        $chitiethoadonbanphukien->save();
        return redirect('hoadonbanphutungphukien/'. $id_banphutungphukien.'/danhsachchitiet')->with('thongbaothem', "Thêm dữ liệu thành công!");
    } 

    function getSua($id_banphutungphukien, $id){
         $chitiethoadonbanphukien = ChiTietHoaDonBanPhuKien::findOrFail($id);
         $phukien = PhuKien::danhSachPhuKien();
         $phukientheoid = PhuKien::phuKienTheoID($chitiethoadonbanphukien->id_phukien);
		return view('chitiethoadonbanphutungphukien.suaphukien', compact('id_banphutungphukien', 'chitiethoadonbanphukien', 'phukien', 'phukientheoid'));
	}

    function postSua(Request $request, $id_banphutungphukien, $id){
        $chitiethoadonbanphukien = ChiTietHoaDonBanPhuKien::findOrFail($id);
        $chitiethoadonbanphukien->id_banphutungphukien = $id_banphutungphukien;
        $chitiethoadonbanphukien->id_phukien = $request->id_phukien;
        $chitiethoadonbanphukien->soluongban = $request->soluongban;
        $chitiethoadonbanphukien->dongiaban = $request->dongiaban;
        $chitiethoadonbanphukien->save();
        return redirect('hoadonbanphutungphukien/'. $id_banphutungphukien.'/danhsachchitiet')->with('thongbaosua', "Sửa dữ liệu thành công!");
    }

    function getXoa($id_banphutungphukien, $id){
        $chitiethoadonbanphukien = ChiTietHoaDonBanPhuKien::findOrFail($id);
        
        $chitiethoadonbanphukien->delete();
        return redirect('hoadonbanphutungphukien/'. $id_banphutungphukien.'/danhsachchitiet')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
    }
}
