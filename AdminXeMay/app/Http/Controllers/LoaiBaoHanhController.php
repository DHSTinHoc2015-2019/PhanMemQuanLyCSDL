<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiBaoHanh;

class LoaiBaoHanhController extends Controller
{
    function index(){
    	$loaibaohanh = LoaiBaoHanh::danhsachbaohanh();
        return view('loaibaohanh.danhsach', compact('loaibaohanh'));
    }

    function getSua($id){
    	$loaibaohanh = LoaiBaoHanh::findOrFail($id);
		return view('loaibaohanh.sua', compact('loaibaohanh'));
	}

	function getThem(){
		return view('loaibaohanh.them');
	}

	function postThem(Request $request){
		$loaibaohanh = new LoaiBaoHanh();
		$loaibaohanh->tenloaibaohanh = $request->tenloaibaohanh;
		$loaibaohanh->thoigianbaohanh = $request->thoigianbaohanh;
		if ($request->hasFile('file')) {
			$file = $request->file('file');
			$duoiAnh = $file->getClientOriginalExtension();
			$arrImg = ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'];
			$check = false;
			for ($i = 0; $i < count($arrImg); $i++) {
				if ($duoiAnh == $arrImg[$i]) {
					$check = true;
					break;
				}
			}
			if (!$check) {
				return redirect('loaibaohanh/them')->with('loi', 'Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
			}
			$name = time() . $file->getClientOriginalName();
			$file->move('uploads/loaibaohanh/', $name);
			$loaibaohanh->imgBH = $name;
		}
		$loaibaohanh->save();
		return redirect('loaibaohanh')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$loaibaohanh = LoaiBaoHanh::findOrFail($id);
		$loaibaohanh->tenloaibaohanh = $request->tenloaibaohanh;
		$loaibaohanh->thoigianbaohanh = $request->thoigianbaohanh;
		if ($request->hasFile('file')) {
			$file = $request->file('file');
			$duoiAnh = $file->getClientOriginalExtension();
			$arrImg = ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'];
			$check = false;
			for ($i = 0; $i < count($arrImg); $i++) {
				if ($duoiAnh == $arrImg[$i]) {
					$check = true;
					break;
				}
			}
			if (!$check) {
				return redirect('loaibaohanh/them')->with('loi', 'Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
			}
			$name = time() . $file->getClientOriginalName();
			$file->move('uploads/loaibaohanh/', $name);
			$loaibaohanh->imgBH = $name;
		}
		$loaibaohanh->save();
		return redirect('loaibaohanh')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$loaibaohanh = LoaiBaoHanh::findOrFail($id);
		 if (file_exists('uploads/loaibaohanh/' . $loaibaohanh->imgBH)) {
            unlink('uploads/loaibaohanh/' . $loaibaohanh->imgBH);
        }
		$loaibaohanh->delete();
		return redirect('loaibaohanh')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}
}
