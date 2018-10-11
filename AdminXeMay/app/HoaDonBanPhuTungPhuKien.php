<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoaDonBanPhuTungPhuKien extends Model
{
    protected $table = 'hoa_don_ban_phu_tung_phu_kiens';

    function scopeDanhSachHoaDonBanPhuTungPhuKien($query){
    	return $query->join('nhan_viens', 'id_nhanvien', '=', 'nhan_viens.id')
    	->join('khach_hangs', 'id_khachhang', '=', 'khach_hangs.id')
    	->select('hoa_don_ban_phu_tung_phu_kiens.id', 'id_khachhang', 'id_nhanvien', 'tenkhachhang', 'diachi', 'hoten', 'hoa_don_ban_phu_tung_phu_kiens.created_at')
    	->get();
    }

    function scopeHoaDonBanPhuTungPhuKienTheoID($query, $id){
    	return $query->join('nhan_viens', 'id_nhanvien', '=', 'nhan_viens.id')
    	->join('khach_hangs', 'id_khachhang', '=', 'khach_hangs.id')
    	->select('hoa_don_ban_phu_tung_phu_kiens.id', 'id_khachhang', 'id_nhanvien', 'tenkhachhang', 'diachi', 'hoten', 'hoa_don_ban_phu_tung_phu_kiens.created_at')
    	->where('hoa_don_ban_phu_tung_phu_kiens.id', $id)
    	->first();
    }
}
