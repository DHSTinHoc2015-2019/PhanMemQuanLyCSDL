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
    Route::get('nhanvien/xemThongKeToanBoChucVuPDF', 'NhanVienController@getxemThongKeToanBoChucVuPDF');
    Route::get('nhanvien/xemThongKeToanBoGioiTinhPDF', 'NhanVienController@getxemThongKeToanBoGioiTinhPDF');
    Route::get('nhanvien/xemThongKeGioiTinhPDF', 'NhanVienController@getxemThongKeGioiTinhPDF');
    Route::get('nhanvien/xemThongKeTuoiPDF', 'NhanVienController@getxemThongKeTuoiPDF');
    Route::get('nhanvien/xemThongKeLuongPDF', 'NhanVienController@getxemThongKeLuongPDF');
    Route::get('nhanvien/xemThongKeToanBoLuongPDF', 'NhanVienController@getxemThongKeToanBoLuongPDF');
    Route::get('nhanvien/xemThongKeToanBoTuoiPDF', 'NhanVienController@getxemThongKeToanBoTuoiPDF');

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
    Route::get('nhapxemay/in/{id}', 'NhapXeMayController@getInPhieuNhap');

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
    Route::get('xemay/viewSearchPDF', 'XeMayController@getViewSearchPDF'); 
    Route::get('xemay/xemThongKeTenXePDF', 'XeMayController@getThongKeTenXePDF');
    Route::get('xemay/xemDanhSachTheoTungLoaiXePDF', 'XeMayController@getxemDanhSachTheoTungLoaiXePDF');
    Route::get('xemay/xemThongKeMauXePDF', 'XeMayController@getxemThongKeMauXePDF');
    Route::get('xemay/xemDanhSachTheoMauXePDF', 'XeMayController@getxemDanhSachTheoMauXePDF');
    Route::get('xemay/xemThongKeDonGiaPDF', 'XeMayController@getxemThongKeDonGiaPDF');
    Route::get('xemay/xemDanhSachTheoDonGiaPDF', 'XeMayController@getxemDanhSachTheoDonGiaPDF');
    
    Route::get('loaiphutung', 'LoaiPhuTungController@index');
    Route::get('loaiphutung/sua/{id}', 'LoaiPhuTungController@getSua');
    Route::post('loaiphutung/sua/{id}', 'LoaiPhuTungController@postSua');
    Route::get('loaiphutung/them', 'LoaiPhuTungController@getThem');
    Route::post('loaiphutung/them', 'LoaiPhuTungController@postThem');
    Route::get('loaiphutung/xoa/{id}', 'LoaiPhuTungController@getXoa');

    Route::get('phutung', 'PhuTungController@index');
    Route::get('phutung/sua/{id}', 'PhuTungController@getSua');
    Route::post('phutung/sua/{id}', 'PhuTungController@postSua');
    Route::get('phutung/them', 'PhuTungController@getThem');
    Route::post('phutung/them', 'PhuTungController@postThem');
    Route::get('phutung/xoa/{id}', 'PhuTungController@getXoa');
    Route::get('phutung/in/{id}', 'PhuTungController@getIn');
    Route::get('phutung/viewPDF', 'PhuTungController@getViewPDF');

    Route::get('nhapphutungphukien', 'NhapPhuTungPhuKienController@index');
    Route::get('nhapphutungphukien/sua/{id}', 'NhapPhuTungPhuKienController@getSua');
    Route::post('nhapphutungphukien/sua/{id}', 'NhapPhuTungPhuKienController@postSua');
    Route::get('nhapphutungphukien/them', 'NhapPhuTungPhuKienController@getThem');
    Route::post('nhapphutungphukien/them', 'NhapPhuTungPhuKienController@postThem');
    Route::get('nhapphutungphukien/xoa/{id}', 'NhapPhuTungPhuKienController@getXoa');
    Route::get('nhapphutungphukien/{id_nhapphutungphukien}/danhsachchitiet', 'NhapPhuTungPhuKienController@danhsachchitiet');
    Route::get('nhapphutungphukien/{id_nhapphutungphukien}/themchitietphutung', 'ChiTietNhapPhuTungController@getThem');
    Route::post('nhapphutungphukien/{id_nhapphutungphukien}/themchitietphutung', 'ChiTietNhapPhuTungController@postThem');
    Route::get('nhapphutungphukien/{id_nhapphutungphukien}/suachitietphutung/{id}', 'ChiTietNhapPhuTungController@getSua');
    Route::post('nhapphutungphukien/{id_nhapphutungphukien}/suachitietphutung/{id}', 'ChiTietNhapPhuTungController@postSua');
    Route::get('nhapphutungphukien/{id_nhapphutungphukien}/xoachitietphutung/{id}', 'ChiTietNhapPhuTungController@getXoa');
    Route::get('nhapphutungphukien/viewPDF', 'NhapPhuTungPhuKienController@getViewPDF');
    // 
    Route::get('nhapphutungphukien/{id_nhapphutungphukien}/themchitietphukien', 'ChiTietNhapPhuKienController@getThem');
    Route::post('nhapphutungphukien/{id_nhapphutungphukien}/themchitietphukien', 'ChiTietNhapPhuKienController@postThem');
    Route::get('nhapphutungphukien/{id_nhapphutungphukien}/suachitietphukien/{id}', 'ChiTietNhapPhuKienController@getSua');
    Route::post('nhapphutungphukien/{id_nhapphutungphukien}/suachitietphukien/{id}', 'ChiTietNhapPhuKienController@postSua');
    Route::get('nhapphutungphukien/{id_nhapphutungphukien}/xoachitietphukien/{id}', 'ChiTietNhapPhuKienController@getXoa');
     
    Route::get('phukien', 'PhuKienController@index');
    Route::get('phukien/sua/{id}', 'PhuKienController@getSua');
    Route::post('phukien/sua/{id}', 'PhuKienController@postSua');
    Route::get('phukien/them', 'PhuKienController@getThem');
    Route::post('phukien/them', 'PhuKienController@postThem');
    Route::get('phukien/xoa/{id}', 'PhuKienController@getXoa');
    Route::get('phukien/in/{id}', 'PhuKienController@getIn');
    Route::get('phukien/viewPDF', 'PhuKienController@getViewPDF');

    Route::get('hoadonbanxemay', 'HoaDonBanXeMayController@index');
    Route::get('hoadonbanxemay/sua/{id}', 'HoaDonBanXeMayController@getSua');
    Route::post('hoadonbanxemay/sua/{id}', 'HoaDonBanXeMayController@postSua');
    Route::get('hoadonbanxemay/them', 'HoaDonBanXeMayController@getThem');
    Route::post('hoadonbanxemay/them', 'HoaDonBanXeMayController@postThem');
    Route::get('hoadonbanxemay/xoa/{id}', 'HoaDonBanXeMayController@getXoa');
    Route::get('hoadonbanxemay/viewPDF', 'HoaDonBanXeMayController@getViewPDF');
    Route::get('hoadonbanxemay/in/{id}', 'HoaDonBanXeMayController@getIn');
    /*Tháng hiện tại*/
    Route::get('hoadonbanxemay/xemThangHienTaiDanhSachTenXePDF', 'HoaDonBanXeMayController@getxemThangHienTaiDanhSachTenXePDF');
    Route::get('hoadonbanxemay/xemThangHienTaiDanhSachTheoNgayPDF', 'HoaDonBanXeMayController@getxemThangHienTaiDanhSachTheoNgayPDF');
    Route::get('hoadonbanxemay/xemThongKeThangHienTaiTenXePDF', 'HoaDonBanXeMayController@getxemThongKeThangHienTaiTenXePDF');
    Route::get('hoadonbanxemay/xemThongKeThangHienTaiTheoNgayPDF', 'HoaDonBanXeMayController@getxemThongKeThangHienTaiTheoNgayPDF');
    /*Năm hiện tại*/
    Route::get('hoadonbanxemay/xemNamHienTaiDanhSachTenXePDF', 'HoaDonBanXeMayController@getxemNamHienTaiDanhSachTenXePDF');
    Route::get('hoadonbanxemay/xemThongKeNamHienTaiTenXePDF', 'HoaDonBanXeMayController@getxemThongKeNamHienTaiTenXePDF');
    Route::get('hoadonbanxemay/xemNamHienTaiDanhSachTheoThangPDF', 'HoaDonBanXeMayController@getxemNamHienTaiDanhSachTheoThangPDF');
    Route::get('hoadonbanxemay/xemThongKeNamHienTaiTheoThangPDF', 'HoaDonBanXeMayController@getxemThongKeNamHienTaiTheoThangPDF');
    /*Tháng bất kỳ*/
    Route::get('hoadonbanxemay/xemTheoThangDanhSachTenXePDF/thang{thang}/nam{nam}', 'HoaDonBanXeMayController@getxemTheoThangDanhSachTenXePDF');
    Route::get('hoadonbanxemay/xemThongKeThangBatKyTenXePDF/{thang}/{nam}', 'HoaDonBanXeMayController@getxemThongKeThangBatKyTenXePDF');
    Route::get('hoadonbanxemay/xemTheoThangDanhSachTheoNgayPDF/{thang}/{nam}', 'HoaDonBanXeMayController@getxemTheoThangDanhSachTheoNgayPDF');
    Route::get('hoadonbanxemay/xemThongKeThangBatKyTheoNgayPDF', 'HoaDonBanXeMayController@getxemThongKeThangBatKyTheoNgayPDF');
    /*Tháng quý*/
    Route::get('hoadonbanxemay/xemTheoQuyDanhSachTenXePDF/{quy}/{nam}', 'HoaDonBanXeMayController@getxemTheoQuyDanhSachTenXePDF');
    Route::get('hoadonbanxemay/xemThongKeQuyTenXePDF/{quy}/{nam}', 'HoaDonBanXeMayController@getxemThongKeQuyTenXePDF');
    Route::get('hoadonbanxemay/xemTheoQuyDanhSachTheoNgayPDF/{quy}/{nam}', 'HoaDonBanXeMayController@getxemTheoQuyDanhSachTheoNgayPDF');
    Route::get('hoadonbanxemay/xemThongKeQuyTheoNgayPDF', 'HoaDonBanXeMayController@getxemThongKeQuyTheoNgayPDF');
    /*Tháng năm*/
    Route::get('hoadonbanxemay/xemTheoNamDanhSachTenXePDF/{nam}', 'HoaDonBanXeMayController@getxemTheoNamDanhSachTenXePDF');
    Route::get('hoadonbanxemay/xemThongKeNamTenXePDF/{nam}', 'HoaDonBanXeMayController@getxemThongKeNamTenXePDF');
    Route::get('hoadonbanxemay/xemTheoNamDanhSachTheoNgayPDF/{nam}', 'HoaDonBanXeMayController@getxemTheoNamDanhSachTheoNgayPDF');
    Route::get('hoadonbanxemay/xemThongKeNamTheoNgayPDF', 'HoaDonBanXeMayController@getxemThongKeNamTheoNgayPDF');
    /*Khoảng thời gian*/
    Route::get('hoadonbanxemay/xemTheoKhoangThoiGianDanhSachTenXePDF/{tungay}/{denngay}', 'HoaDonBanXeMayController@getxemTheoKhoangThoiGianDanhSachTenXePDF');
    Route::get('hoadonbanxemay/xemThongKeKhoangThoiGianTenXePDF/{tungay}/{denngay}', 'HoaDonBanXeMayController@getxemThongKeKhoangThoiGianTenXePDF');
    Route::get('hoadonbanxemay/xemTheoKhoangThoiGianDanhSachTheoNgayPDF/{tungay}/{denngay}', 'HoaDonBanXeMayController@getxemTheoKhoangThoiGianDanhSachTheoNgayPDF');
    Route::get('hoadonbanxemay/xemThongKeKhoangThoiGianTheoNgayPDF', 'HoaDonBanXeMayController@getxemThongKeKhoangThoiGianTheoNgayPDF');
    
    Route::get('hoadonbanphutungphukien', 'HoaDonBanPhuTungPhuKienController@index');
    Route::get('hoadonbanphutungphukien/sua/{id}', 'HoaDonBanPhuTungPhuKienController@getSua');
    Route::post('hoadonbanphutungphukien/sua/{id}', 'HoaDonBanPhuTungPhuKienController@postSua');
    Route::get('hoadonbanphutungphukien/them', 'HoaDonBanPhuTungPhuKienController@getThem');
    Route::post('hoadonbanphutungphukien/them', 'HoaDonBanPhuTungPhuKienController@postThem');
    Route::get('hoadonbanphutungphukien/xoa/{id}', 'HoaDonBanPhuTungPhuKienController@getXoa');
    Route::get('hoadonbanphutungphukien/viewPDF', 'HoaDonBanPhuTungPhuKienController@getViewPDF');
    // Route::get('hoadonbanphutungphukien/in/{id}', 'HoaDonBanPhuTungPhuKienController@getIn');
    Route::get('hoadonbanphutungphukien/{id_banphutungphukien}/danhsachchitiet', 'HoaDonBanPhuTungPhuKienController@danhsachchitiet');
    Route::get('hoadonbanphutungphukien/{id_banphutungphukien}/themchitietphutung', 'ChiTietHoaDonBanPhuTungController@getThem');
    Route::post('hoadonbanphutungphukien/{id_banphutungphukien}/themchitietphutung', 'ChiTietHoaDonBanPhuTungController@postThem');
    Route::get('hoadonbanphutungphukien/{id_banphutungphukien}/suachitietphutung/{id}', 'ChiTietHoaDonBanPhuTungController@getSua');
    Route::post('hoadonbanphutungphukien/{id_banphutungphukien}/suachitietphutung/{id}', 'ChiTietHoaDonBanPhuTungController@postSua');
    Route::get('hoadonbanphutungphukien/{id_banphutungphukien}/xoachitietphutung/{id}', 'ChiTietHoaDonBanPhuTungController@getXoa');
    // Route::get('hoadonbanphutungphukien/viewPDF', 'NhapPhuTungPhuKienController@getViewPDF');
    // 
    Route::get('hoadonbanphutungphukien/{id_banphutungphukien}/themchitietphukien', 'ChiTietHoaDonBanPhuKienController@getThem');
    Route::post('hoadonbanphutungphukien/{id_banphutungphukien}/themchitietphukien', 'ChiTietHoaDonBanPhuKienController@postThem');
    Route::get('hoadonbanphutungphukien/{id_banphutungphukien}/suachitietphukien/{id}', 'ChiTietHoaDonBanPhuKienController@getSua');
    Route::post('hoadonbanphutungphukien/{id_banphutungphukien}/suachitietphukien/{id}', 'ChiTietHoaDonBanPhuKienController@postSua');
    Route::get('hoadonbanphutungphukien/{id_banphutungphukien}/xoachitietphukien/{id}', 'ChiTietHoaDonBanPhuKienController@getXoa');
    
    // Route::get('baohanh', 'BaoHanhController@index');
    // Route::get('baohanh/sua/{id}', 'BaoHanhController@getSua');
    // Route::get('baohanh/them', 'BaoHanhController@getThem');

    // Route::get('chitietbaohanh/{idbaohanh}', 'ChiTietBaoHanhController@index');
    // Route::get('chitietbaohanh/sua/{id}', 'ChiTietBaoHanhController@getSua');
    // Route::get('chitietbaohanh/them', 'ChiTietBaoHanhController@getThem');

    //Ajax
    Route::get('ajax/getImgXeMay/{id}', 'AjaxController@getImgXeMay');
    Route::get('ajax/getImgHoaDonXeMay/{id}', 'AjaxController@getImgHoaDonXeMay');
    Route::get('ajax/getImgPhuTung/{id}', 'AjaxController@getImgPhuTung');
    Route::get('ajax/getImgPhuTungBangPhuTung/{id}', 'AjaxController@getImgPhuTungBangPhuTung');
    Route::get('ajax/getImgPhuTungBangPhuTungHoaDon/{id}', 'AjaxController@getImgPhuTungBangPhuTungHoaDon');
    Route::get('ajax/getImgPhuKienBangPhuKien/{id}', 'AjaxController@getImgPhuKienBangPhuKien');
    Route::get('ajax/getImgPhuKienBangPhuKienHoaDon/{id}', 'AjaxController@getImgPhuKienBangPhuKienHoaDon');
    Route::get('ajax/getThongKeXeMayTheoGia/{gia}', 'AjaxController@getThongKeXeMayTheoGia');


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
            Route::get('gioitinh', 'NhanVienController@getThongKeGioiTinh');
            Route::post('gioitinh', 'NhanVienController@postThongKeGioiTinh');
            Route::get('tuoi', 'NhanVienController@getThongKeTuoi');
            Route::post('tuoi', 'NhanVienController@postThongKeTuoi');
            Route::get('luong', 'NhanVienController@getThongKeLuong');
            Route::post('luong', 'NhanVienController@postThongKeLuong');
        });

        Route::get('xemay', 'XeMayController@getThongKeIndex');
        Route::group(['prefix' => 'xemay'], function(){
            Route::get('xetrongcuahang', 'XeMayController@getThongKeXeTrongCuaHang');

            Route::get('tenxe', 'XeMayController@getThongKeTenXe');
            Route::post('tenxe', 'XeMayController@postThongKeTenXe');
            Route::get('mauxe', 'XeMayController@getThongKeMauXe');
            Route::post('mauxe', 'XeMayController@postThongKeMauXe');
            Route::get('dongia', 'XeMayController@getThongKeDonGia');
            Route::post('dongia', 'XeMayController@postThongKeDonGia');
        });

        Route::get('phutungphukien', 'PhuTungPhuKienController@getThongKeIndex');
        Route::group(['prefix' => 'phutungphukien'], function(){
            // Route::get('phutungphukientrongcuahang', 'PhuTungPhuKienController@getThongKeXeTrongCuaHang');

            // Route::get('tenxe', 'PhuTungPhuKienController@getThongKeTenXe');
            // Route::post('tenxe', 'PhuTungPhuKienController@postThongKeTenXe');
        });

        Route::get('nhapxemay', 'NhapXeMayController@getThongKeIndex');
        Route::group(['prefix' => 'nhapxemay'], function(){
            // Route::get('tenxe', 'PhuTungPhuKienController@getThongKeTenXe');
            // Route::post('tenxe', 'PhuTungPhuKienController@postThongKeTenXe');
        });

        Route::get('hoadonbanxemay', 'HoaDonBanXeMayController@getThongKeIndex');
        Route::group(['prefix' => 'hoadonbanxemay'], function(){
            Route::get('thanghientai', 'HoaDonBanXeMayController@getThongKeThangHienTai');
            Route::get('namhientai', 'HoaDonBanXeMayController@getThongKeNamHienTai');
            Route::get('thanghientaitheotenxe', 'HoaDonBanXeMayController@getThangHienTaiTheoTenXe');
            Route::post('thanghientaitheotenxe', 'HoaDonBanXeMayController@postThangHienTaiTheoTenXe');
            Route::get('thanghientaitheongay', 'HoaDonBanXeMayController@getThangHienTaiTheoNgay');
            Route::post('thanghientaitheongay', 'HoaDonBanXeMayController@postThangHienTaiTheoNgay');
            /* Năm hiện tại */
            Route::get('namhientaitheotenxe', 'HoaDonBanXeMayController@getNamHienTaiTheoTenXe');
            Route::post('namhientaitheotenxe', 'HoaDonBanXeMayController@postNamHienTaiTheoTenXe');
            Route::get('namhientaitheothang', 'HoaDonBanXeMayController@getNamHienTaiTheoThang');
            Route::post('namhientaitheothang', 'HoaDonBanXeMayController@postNamHienTaiTheoThang');
            /* Thống kê theo tháng */
            Route::get('chonthang', 'HoaDonBanXeMayController@getChonThang');
            Route::post('chonthang', 'HoaDonBanXeMayController@postChonThang');
            Route::get('thangbatkytheotenxe/{thang}/{nam}', 'HoaDonBanXeMayController@getThangBatKyTheoTenXe');
            Route::post('thangbatkytheotenxe/{thang}/{nam}', 'HoaDonBanXeMayController@postThangBatKyTheoTenXe');
            Route::get('thangbatkytheongay/{thang}/{nam}', 'HoaDonBanXeMayController@getThangBatKyTheoNgay');
            Route::post('thangbatkytheongay/{thang}/{nam}', 'HoaDonBanXeMayController@postThangBatKyTheoNgay');
            /* Thống kê theo quý */
            Route::get('chonquy', 'HoaDonBanXeMayController@getChonQuy');
            Route::post('chonquy', 'HoaDonBanXeMayController@postChonQuy');
            Route::get('quytheotenxe/{quy}/{nam}', 'HoaDonBanXeMayController@getQuyTheoTenXe');
            Route::post('quytheotenxe/{quy}/{nam}', 'HoaDonBanXeMayController@postQuyTheoTenXe');
            Route::get('quytheongay/{quy}/{nam}', 'HoaDonBanXeMayController@getQuyTheoNgay');
            Route::post('quytheongay/{quy}/{nam}', 'HoaDonBanXeMayController@postQuyTheoNgay');
            /* Thống kê theo năm */
            Route::get('chonnam', 'HoaDonBanXeMayController@getChonNam');
            Route::post('chonnam', 'HoaDonBanXeMayController@postChonNam');
            Route::get('namtheotenxe/{nam}', 'HoaDonBanXeMayController@getNamTheoTenXe');
            Route::post('namtheotenxe/{nam}', 'HoaDonBanXeMayController@postNamTheoTenXe');
            Route::get('namtheongay/{nam}', 'HoaDonBanXeMayController@getNamTheoNgay');
            Route::post('namtheongay/{nam}', 'HoaDonBanXeMayController@postNamTheoNgay');
            /* Thống kê theo khoảng thời gian */
            Route::get('chonkhoangthoigian', 'HoaDonBanXeMayController@getChonKhoangThoiGian');
            Route::get('khoangthoigian/{tungay}/{denngay}', 'HoaDonBanXeMayController@getKhoangThoiGian');
            // Route::post('chonnam', 'HoaDonBanXeMayController@postChonNam');
            Route::get('khoangthoigiantheotenxe/{tungay}/{denngay}', 'HoaDonBanXeMayController@getKhoangThoiGianTheoTenXe');
            Route::post('khoangthoigiantheotenxe/{tungay}/{denngay}', 'HoaDonBanXeMayController@postKhoangThoiGianTheoTenXe');
            Route::get('khoangthoigiantheongay/{tungay}/{denngay}', 'HoaDonBanXeMayController@getKhoangThoiGianTheoNgay');
            Route::post('khoangthoigiantheongay/{tungay}/{denngay}', 'HoaDonBanXeMayController@postKhoangThoiGianTheoNgay');

        });
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

Route::get('hoadon', function () {
    
    return view('hoadon');
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

//Gốc
// Route::get('api/{d}', function($d){
//   // Get the number of days to show data for, with a default of 7
//   // $days = Input::get('days', 7);
//   $days = $d;

  
//   $range = Carbon\Carbon::now()->subDays($d);
//   $stats = DB::table('hoa_don_ban_xe_mays')
//     ->where('created_at', '>=', $range)
//     ->groupBy('date')
//     ->orderBy('date', 'ASC')
//     ->get([
//       DB::raw('Date(created_at) as date'),
//       DB::raw('COUNT(*) as value')
//     ])->toJSON();

//   return $stats;
// });

Route::get('api/{d}', function($d){
    // $arrGia = explode('-', $gia);

    // $dongia10_20 = DB::table('xe_mays')
    // ->select(DB::raw('concat(tenxe, \' \', mauxe) as ten'),  DB::raw('SUM(soluong) as soluong'))
    // ->groupBy('tenxe', 'mauxe')
    // ->where('dongia', '>', $arrGia[0])
    // ->where('dongia', '<=', $arrGia[1])
    // ->get()->toJSON();;
    // return $dongia10_20;

  $days = $d;
  
  $range = Carbon\Carbon::now()->subDays($d);
  $stats = DB::table('hoa_don_ban_xe_mays')
    ->where('created_at', '>=', $range)
    ->groupBy('date')
    ->orderBy('date', 'ASC')
    ->get([
      DB::raw('Date(created_at) as date'),
      DB::raw('COUNT(*) as value')
    ])->toJSON();

  return $stats;
});

Route::get('demoMorrisJS', function(){
    return view('demoMorrisJS');
});