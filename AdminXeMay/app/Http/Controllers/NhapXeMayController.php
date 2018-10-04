<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NhapXeMay;
use App\NhaCungCap;
use Auth;
use DateTime;

class NhapXeMayController extends Controller
{
    function index(){
    	$nhapxe = NhapXeMay::danhsach();
    	return view('nhapxemay.danhsach', compact('nhapxe'));
    }

    function getSua($id){
    	$nhapxe = NhapXeMay::findOrFail($id);
    	$nhacungcap = NhaCungCap::all();
		return view('nhapxemay.sua', compact('nhapxe', 'nhacungcap'));
	}

	function getThem(){
		$nhacungcap = NhaCungCap::all();
		return view('nhapxemay.them', compact('nhacungcap'));
	}

	function postThem(Request $request){
		$nhapxe = new NhapXeMay();
        $nhapxe->id_nhacungcap = $request->id_nhacungcap;
        $nhapxe->id_nhanvien = Auth::User()->id;
        $nhapxe->save();
        return redirect('nhapxemay')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$nhapxe = NhapXeMay::findOrFail($id);
        $nhapxe->id_nhacungcap = $request->id_nhacungcap;
        $nhapxe->id_nhanvien = Auth::User()->id;
        $nhapxe->created_at = DateTime::createFromFormat("m/d/Y" , $request->created_at)->format('Y-m-d');
        $nhapxe->save();
        return redirect('nhapxemay')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$nhapxe = NhapXeMay::findOrFail($id);
        $nhapxe->delete();
        return redirect('nhapxemay')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}
}
