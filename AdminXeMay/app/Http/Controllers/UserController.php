<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\NhanVien;
use App\User;
use App\Http\Requests\DangNhapRequest;
use App\Http\Requests\DangKy2Request;

class UserController extends Controller
{
    function postDangNhap(DangNhapRequest $request){
		$login = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
		$payload[$login] = $request->login;
		$payload['password'] = $request->password;

		if (Auth::attempt($payload)) {
			return redirect('/');
		} else {
			return redirect()->back()->with('thongbaoloidangnhap', 'Đăng nhập không thành công');
		}
	}

	function getDangXuat(){
		Auth::logout();
		return redirect('dangnhap');
	}

	function postDangKy1(Request $request){
		$check = NhanVien::KiemTraChuoiBaoMat($request->ChuoiBaoMat);
		if($check >= 1){
			return redirect('dangky2/'.$request->ChuoiBaoMat);
		}
		else return redirect('dangky1')->with('thongbao', 'Chuỗi bạn vừa nhập không đúng');
	}
	// 1dca6eb322

	function postDangKy2(DangKy2Request $request, $chuoibaomat){
		$user = new User();
        $user->name = $request->TenDangNhap;
        $user->email = $request->Email;
        $user->password = bcrypt($request->Password);
        $id_nhanvien = NhanVien::TimIDTheoChuoiBaoMat($chuoibaomat)[0];
        $user->id_nhanvien = $id_nhanvien;
        $user->quyen = "user";

        $user->save();

        $nhanvien = NhanVien::find($id_nhanvien);
        $nhanvien->chuoibaomat = substr(md5(rand()), 0, 10);

        $nhanvien->save();

        return redirect('dangnhap')->with('thongbaothanhcongtaikhoan', 'Tài khoản "' . $request->TenDangNhap . '" đã được tạo thành công. Vui lòng đăng nhập để vào hệ thống');
	}

	function resetPassword ($id){
		$useredit = User::findOrFail($id);

		$useredit->password = bcrypt('12345');
		$useredit->save();

		$user = User::all();
		return view('user.danhsach', compact('user'));
	}

	function index(){
		// $user = User::AllUser();
		$user = User::DanhSachUser();
		return view('user.danhsach', compact('user'));
	}

	function getSua($id){
		return view('user.sua');
	}

	function getThem(){
		return view('user.them');
	}
}
