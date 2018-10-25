<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class HoaDonBanXeMay extends Model
{
	protected $table = 'hoa_don_ban_xe_mays';

    function scopeDanhSachHoaDonXeMay($query){
    	return $query->join('xe_mays', 'id_xemay', 'xe_mays.id')
    	->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
    	->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img', 'thueVAT')
    	->get();
    }

    function scopeDanhSachHoaDonXeMayTheoID($query, $id){
    	return $query->join('xe_mays', 'id_xemay', 'xe_mays.id')
    	->join('khach_hangs', 'id_khachhang', 'khach_hangs.id')
    	->join('nhan_viens', 'id_nhanvien', 'nhan_viens.id')
    	->select('hoa_don_ban_xe_mays.id','tenkhachhang', 'khach_hangs.diachi','tenxe', 'mauxe', 'dongia', 'hoa_don_ban_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'thueVAT', DB::raw('(dongia + dongia * thueVAT/100) * hoa_don_ban_xe_mays.soluong as thanhtien'), DB::raw('DATE(hoa_don_ban_xe_mays.created_at) as ngayban'), 'hoten')
    	->where('hoa_don_ban_xe_mays.id', $id)
    	->first();
    }
}
