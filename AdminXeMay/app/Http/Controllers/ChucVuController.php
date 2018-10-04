<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChucVu; 
class ChucVuController extends Controller
{
    function index(){
    	$chucvu = ChucVu::danhSach();
        return view('chucvu.danhsach', compact('chucvu'));
    }

    function getSua($id){
    	$chucvu = ChucVu::findOrFail($id);
		return view('chucvu.sua', compact('chucvu'));
	}

	function getThem(){
		return view('chucvu.them');
	}

	function postThem(Request $request){
		$chucvu = new ChucVu();
        $chucvu->tenchucvu = $request->tenchucvu;
        $chucvu->hesoluong = $request->hesoluong;
        $chucvu->luongcoban = $request->luongcoban;
        $chucvu->save();
        return redirect('chucvu')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$chucvu = ChucVu::findOrFail($id);
        $chucvu->tenchucvu = $request->tenchucvu;
        $chucvu->hesoluong = $request->hesoluong;
        $chucvu->luongcoban = $request->luongcoban;
        $chucvu->save();
        return redirect('chucvu')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$chucvu = ChucVu::findOrFail($id);
        $chucvu->delete();
        return redirect('chucvu')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}
}
