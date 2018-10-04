<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function nhanvien()
    {
        return $this->belongsTo('App\NhanVien', 'id_nhanvien', 'id');
    }

    public function scopeAllUser($query){
        return $query->get();
    }

    public function scopeDanhSachUser($query){
        return $query->join('nhan_viens', 'id_nhanvien', '=', 'nhan_viens.id')
        ->join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->select('users.id', 'name', 'email', 'chuc_vus.tenchucvu', 'quyen')->get();
    }
}
