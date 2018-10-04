<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietNhapXeMay extends Model
{
    protected $table = 'chi_tiet_nhap_xe_mays';

    function nhapxe(){
    	return $this->belongsTo('App\NhapXe', 'id_nhapxe', 'id');
    }

    function scopeDanhSachTheoID($query, $id_nhapxemay){
    	return $query->join('xe_mays', 'id_xemay', 'xe_mays.id')
    	->select('chi_tiet_nhap_xe_mays.id', 'id_nhapxemay', 'tenxe', 'mauxe', 'dongia', 'chi_tiet_nhap_xe_mays.soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'img')
    	->where('id_nhapxemay', $id_nhapxemay)
    	->get();
    }
}
