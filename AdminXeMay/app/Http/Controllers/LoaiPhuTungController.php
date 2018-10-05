<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiPhuTung;

class LoaiPhuTungController extends Controller
{
    function index(){
    	$loaiphutung = LoaiPhuTung::danhSachLoaiPhuTung();
        return view('loaiphutung.danhsach', compact('loaiphutung'));
    }

    function getSua($id){
    	$loaiphutung = LoaiPhuTung::findOrFail($id);
		return view('loaiphutung.sua', compact('loaiphutung'));
	}

	function getThem(){
		return view('loaiphutung.them');
	}

	function postThem(Request $request){
		$loaiphutung = new LoaiPhuTung();
		$loaiphutung->tenphutung = $request->tenphutung;
		$loaiphutung->donvitinh = $request->donvitinh;
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
				return redirect('loaiphutung/them')->with('loi', 'Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
			}
			$name = time() . $file->getClientOriginalName();
			$file->move('uploads/phutung/', $name);
			$loaiphutung->imgphutung = $name;
		}
		$loaiphutung->save();
		return redirect('loaiphutung')->with('thongbaothem', "Thêm dữ liệu thành công!");
	}

	function postSua(Request $request, $id){
		$loaiphutung = LoaiPhuTung::findOrFail($id);
		$loaiphutung->tenphutung = $request->tenphutung;
		$loaiphutung->donvitinh = $request->donvitinh;
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
				return redirect('thongtinchungxe/them')->with('loi', 'Bạn chỉ được chọn file có đuôi jpg, png, jpeg');
			}
			$name = time() . $file->getClientOriginalName();
			$file->move('uploads/phutung/', $name);
			$loaiphutung->imgphutung = $name;
		}
		$loaiphutung->save();
		return redirect('loaiphutung')->with('thongbaosua', "Sửa dữ liệu thành công!");
	}

	function getXoa($id){
		$loaiphutung = LoaiPhuTung::findOrFail($id);
		 if (file_exists('uploads/phutung/' . $loaiphutung->imgphutung)) {
            unlink('uploads/phutung/' . $loaiphutung->imgphutung);
        }
		$loaiphutung->delete();
		return redirect('loaiphutung')->with('thongbaoxoa', "Xóa dữ liệu thành công!");
	}
}
