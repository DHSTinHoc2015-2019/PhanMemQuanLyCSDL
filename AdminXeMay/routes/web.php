<?php

Route::get('/', function () {
    return view('index');
})->middleware('AccountMiddleware');

Route::group(['prefix'=>'/', 'middleware' => 'AccountMiddleware'], function(){
	Route::get('user', 'UserController@index'); 
	Route::get('user/sua/{id}', 'UserController@getSua');
    Route::get('user/them', 'UserController@getThem');
    Route::get('user/resetpassword/{id}', 'UserController@resetPassword');

    Route::get('nhacungcap', 'NhaCungCapController@index');
    Route::get('nhacungcap/sua/{id}', 'NhaCungCapController@getSua');
    Route::post('nhacungcap/sua/{id}', 'NhaCungCapController@postSua');
    Route::get('nhacungcap/them', 'NhaCungCapController@getThem');
    Route::post('nhacungcap/them', 'NhaCungCapController@postThem');
    Route::get('nhacungcap/xoa/{id}', 'NhaCungCapController@getXoa');
    Route::get('nhacungcap/viewPDF', 'NhaCungCapController@getViewPDF');
    Route::get('nhacungcap/in/{id}', 'NhaCungCapController@getIn');
    
    Route::get('nhanvien', 'NhanVienController@index');
    Route::get('nhanvien/sua/{id}', 'NhanVienController@getSua');
    Route::post('nhanvien/sua/{id}', 'NhanVienController@postSua');
    Route::get('nhanvien/them', 'NhanVienController@getThem');
    Route::post('nhanvien/them', 'NhanVienController@postThem');
    Route::get('nhanvien/xoa/{id}', 'NhanVienController@getXoa');
    Route::get('nhanvien/in/{id}', 'NhanVienController@getIn');
    Route::get('nhanvien/viewPDF', 'NhanVienController@getViewPDF');
    Route::get('nhanvien/viewSearchPDF', 'NhanVienController@getViewSearchPDF');
    Route::get('nhanvien/xemThongKeChucVuPDF', 'NhanVienController@getxemThongKeChucVuPDF');

    Route::get('chucvu', 'ChucVuController@index');
    Route::get('chucvu/sua/{id}', 'ChucVuController@getSua');
    Route::post('chucvu/sua/{id}', 'ChucVuController@postSua');
    Route::get('chucvu/them', 'ChucVuController@getThem');
    Route::post('chucvu/them', 'ChucVuController@postThem');
    Route::get('chucvu/xoa/{id}', 'ChucVuController@getXoa');

    Route::get('nhapxemay', 'NhapXeMayController@index');
    Route::get('nhapxemay/sua/{id}', 'NhapXeMayController@getSua');
    Route::post('nhapxemay/sua/{id}', 'NhapXeMayController@postSua');
    Route::get('nhapxemay/them', 'NhapXeMayController@getThem');
    Route::post('nhapxemay/them', 'NhapXeMayController@postThem');
    Route::get('nhapxemay/xoa/{id}', 'NhapXeMayController@getXoa');

    Route::get('chitietnhapxemay/{idnhapxemay}', 'ChiTietNhapXeMayController@index');
    Route::get('chitietnhapxemay/{idnhapxemay}/sua/{idchitiet}', 'ChiTietNhapXeMayController@getSua');
    Route::post('chitietnhapxemay/{idnhapxemay}/sua/{idchitiet}', 'ChiTietNhapXeMayController@postSua');
    Route::get('chitietnhapxemay/{idnhapxemay}/them', 'ChiTietNhapXeMayController@getThem');
    Route::post('chitietnhapxemay/{idnhapxemay}/them', 'ChiTietNhapXeMayController@postThem');
    Route::get('chitietnhapxemay/{idnhapxemay}/xoa/{idchitiet}', 'ChiTietNhapXeMayController@getXoa');
    Route::get('chitietnhapxemay/{idnhapxemay}/view', 'ChiTietNhapXeMayController@getView');

    Route::get('khachhang', 'KhachHangController@index');
    Route::get('khachhang/sua/{id}', 'KhachHangController@getSua');
    Route::post('khachhang/sua/{id}', 'KhachHangController@postSua');
    Route::get('khachhang/them', 'KhachHangController@getThem');
    Route::post('khachhang/them', 'KhachHangController@postThem');
    Route::get('khachhang/xoa/{id}', 'KhachHangController@getXoa');
    Route::get('khachhang/in/{id}', 'KhachHangController@getIn');
    Route::get('khachhang/viewPDF', 'KhachHangController@getViewPDF');
    Route::get('khachhang/viewSearchPDF', 'KhachHangController@getViewSearchPDF'); 

    Route::get('loaibaohanh', 'LoaiBaoHanhController@index');
    Route::get('loaibaohanh/sua/{id}', 'LoaiBaoHanhController@getSua');
    Route::post('loaibaohanh/sua/{id}', 'LoaiBaoHanhController@postSua');
    Route::get('loaibaohanh/them', 'LoaiBaoHanhController@getThem');
    Route::post('loaibaohanh/them', 'LoaiBaoHanhController@postThem');
    Route::get('loaibaohanh/xoa/{id}', 'LoaiBaoHanhController@getXoa');

    Route::get('xemay', 'XeMayController@index');
    Route::get('xemay/sua/{id}', 'XeMayController@getSua');
    Route::post('xemay/sua/{id}', 'XeMayController@postSua');
    Route::get('xemay/them', 'XeMayController@getThem');
    Route::post('xemay/them', 'XeMayController@postThem');
    Route::get('xemay/xoa/{id}', 'XeMayController@getXoa');
    Route::get('xemay/viewPDF', 'XeMayController@getViewPDF');
    Route::get('xemay/in/{id}', 'XeMayController@getIn');

    // Route::get('thongtinchungxemay', 'ThongTinChungXeController@index');
    // Route::get('thongtinchungxemay/sua/{id}', 'ThongTinChungXeController@getSua');
    // Route::post('thongtinchungxemay/sua/{id}', 'ThongTinChungXeController@postSua');
    // Route::get('thongtinchungxemay/them', 'ThongTinChungXeController@getThem');
    // Route::post('thongtinchungxemay/them', 'ThongTinChungXeController@postThem');
    // Route::get('thongtinchungxemay/xoa/{id}', 'ThongTinChungXeController@getXoa');

    Route::get('baohanh', 'BaoHanhController@index');
    Route::get('baohanh/sua/{id}', 'BaoHanhController@getSua');
    Route::get('baohanh/them', 'BaoHanhController@getThem');

    Route::get('chitietbaohanh/{idbaohanh}', 'ChiTietBaoHanhController@index');
    Route::get('chitietbaohanh/sua/{id}', 'ChiTietBaoHanhController@getSua');
    Route::get('chitietbaohanh/them', 'ChiTietBaoHanhController@getThem');

    Route::get('nhapphutungphukien', 'NhapPhuTungPhuKienController@index');
    Route::get('nhapphutungphukien/sua/{id}', 'NhapPhuTungPhuKienController@getSua');
    Route::post('nhapphutungphukien/sua/{id}', 'NhapPhuTungPhuKienController@postSua');
    Route::get('nhapphutungphukien/them', 'NhapPhuTungPhuKienController@getThem');
    Route::post('nhapphutungphukien/them', 'NhapPhuTungPhuKienController@postThem');
    Route::get('nhapphutungphukien/xoa/{id}', 'NhapPhuTungPhuKienController@getXoa');
    Route::get('nhapphutungphukien/viewPDF', 'NhapPhuTungPhuKienController@getViewPDF');

    Route::get('loaiphutung', 'LoaiPhuTungController@index');
    Route::get('loaiphutung/sua/{id}', 'LoaiPhuTungController@getSua');
    Route::post('loaiphutung/sua/{id}', 'LoaiPhuTungController@postSua');
    Route::get('loaiphutung/them', 'LoaiPhuTungController@getThem');
    Route::post('loaiphutung/them', 'LoaiPhuTungController@postThem');
    Route::get('loaiphutung/xoa/{id}', 'LoaiPhuTungController@getXoa');

    Route::get('thongtinphutung/{idloaiphutung}', 'ThongTinPhuTungController@index');
    Route::get('thongtinphutung/{idloaiphutung}/sua/{id}', 'ThongTinPhuTungController@getSua');
    Route::post('thongtinphutung/{idloaiphutung}/sua/{id}', 'ThongTinPhuTungController@postSua');
    Route::get('thongtinphutung/{idloaiphutung}/them', 'ThongTinPhuTungController@getThem');
    Route::post('thongtinphutung/{idloaiphutung}/them', 'ThongTinPhuTungController@postThem');
    Route::get('thongtinphutung/{idloaiphutung}/xoa/{id}', 'ThongTinPhuTungController@getXoa');

    Route::get('chitietnhapphutungphukien/{id_nhapphutungphukien}', 'ChiTietNhapPhuTungPhuKienController@index');
    Route::get('chitietnhapphutungphukien/sua/{id}', 'ChiTietNhapPhuTungController@getSua');
    Route::get('chitietnhapphutungphukien/{id_nhapphutungphukien}/themchitietphutung', 'ChiTietNhapPhuTungController@getThem');
    Route::post('chitietnhapphutungphukien/{id_nhapphutungphukien}/themchitietphutung', 'ChiTietNhapPhuTungController@postThem');
    Route::get('chitietnhapphutungphukien/{id_nhapphutungphukien}/suachitietphutung/{id}', 'ChiTietNhapPhuTungController@getSua');
    Route::post('chitietnhapphutungphukien/{id_nhapphutungphukien}/suachitietphutung/{id}', 'ChiTietNhapPhuTungController@postSua');
    Route::get('chitietnhapphutungphukien/{id_nhapphutungphukien}/xoachitietphutung/{id}', 'ChiTietNhapPhuTungController@getXoa');
    Route::get('chitietnhapphutungphukien/{id_nhapphutungphukien}/themchitietphukien', 'ChiTietNhapPhuKienController@getThem');
    Route::post('chitietnhapphutungphukien/{id_nhapphutungphukien}/themchitietphukien', 'ChiTietNhapPhuKienController@postThem');
    Route::get('chitietnhapphutungphukien/{id_nhapphutungphukien}/suachitietphukien/{id}', 'ChiTietNhapPhuKienController@getSua');
    Route::post('chitietnhapphutungphukien/{id_nhapphutungphukien}/suachitietphukien/{id}', 'ChiTietNhapPhuKienController@postSua');
    Route::get('chitietnhapphutungphukien/{id_nhapphutungphukien}/xoachitietphukien/{id}', 'ChiTietNhapPhuKienController@getXoa');


    Route::get('thongtinphukien', 'ThongTinPhuKienController@index');
    Route::get('thongtinphukien/sua/{id}', 'ThongTinPhuKienController@getSua');
    Route::post('thongtinphukien/sua/{id}', 'ThongTinPhuKienController@postSua');
    Route::get('thongtinphukien/them', 'ThongTinPhuKienController@getThem');
    Route::post('thongtinphukien/them', 'ThongTinPhuKienController@postThem');
    Route::get('thongtinphukien/xoa/{id}', 'ThongTinPhuKienController@getXoa');

    Route::get('phutung', 'PhuTungController@index');
    Route::get('phutung/sua/{id}', 'PhuTungController@getSua');
    Route::get('phutung/them', 'PhuTungController@getThem');


    Route::get('ajax/getImgXeMay/{idthongtin}', 'AjaxController@getImgXeMay');
    Route::get('ajax/getImgXeMayTableXeMay/{idChiTietNhapXe}', 'AjaxController@getImgXeMayTableXeMay');
    Route::get('ajax/getImgPhuTungTableLoaiPhuTung/{idthongtinphutung}', 'AjaxController@getImgPhuTungTableLoaiPhuTung');
    Route::get('ajax/getImgPhuKienTableLoaiPhuKien/{idthongtinphukien}', 'AjaxController@getImgPhuKienTableLoaiPhuKien');


    //Tìm kiếm
    Route::group(['prefix'=>'timkiem'], function(){
        Route::get('xemay', 'XeMayController@getTimKiem');
        Route::post('xemay', 'XeMayController@postTimKiem');

        Route::get('nhanvien', 'NhanVienController@getTimKiem');
        Route::post('nhanvien', 'NhanVienController@postTimKiem');

        Route::get('khachhang', 'KhachHangController@getTimKiem');
        Route::post('khachhang', 'KhachHangController@postTimKiem');
    });

    //Thống kê
    Route::group(['prefix'=>'thongke'], function(){

        Route::get('nhanvien', 'NhanVienController@getThongKeIndex');
        Route::group(['prefix' => 'nhanvien'], function(){
            Route::get('chucvu', 'NhanVienController@getThongKeChucVu');
            Route::post('chucvu', 'NhanVienController@postThongKeChucVu');
        });
        // Route::post('nhanvien', 'NhanVienController@postTimKiem');
    });
});

Route::get('dangnhap', function () {
    return view('dangnhap');
})->name('dangnhap');

Route::post('dangnhap', 'UserController@postDangNhap');
Route::get('dangxuat', 'UserController@getDangXuat');

Route::get('dangky1', function () {
    return view('dangky1');
});
Route::post('dangky1', 'UserController@postDangKy1');

Route::get('dangky2/{chuoiBaoMat}', function ($chuoiBaoMat) {
    return view('dangky2', ['chuoibaomat'=>$chuoiBaoMat]);
});
Route::post('dangky2/{chuoiBaoMat}', 'UserController@postDangKy2');

Route::get('demo', function () {
    $xemay = DB::table('chi_tiet_nhap_xes')
        ->join('thong_tin_chung_xes', 'id_thongtinchungxe', 'thong_tin_chung_xes.id')
        ->select('thong_tin_chung_xes.img')
        ->where('chi_tiet_nhap_xes.id', '=', 1)
        ->get();
    return $xemay[0]->img;
});
Route::get('demoselect', function () {
    $results = DB::select( DB::raw("SELECT id FROM chi_tiet_nhap_xes WHERE id > 1") );
    return $results;
});
Route::get('demo1', function () {
    $nhanvien = App\NhanVien::DanhSach();
    return view('phieunhapxe', compact('nhanvien'));
});

Route::get('demosession/tao', function () {
    Session::put('key1', 'value1');
    //Xóa 1 session
    // Session::forget('key1');
    //Xóa hết session
    // Session::flush();
    if(Session::has('key1')) {
        echo "co"; echo session('key1');
    }
    else echo "khong";
});