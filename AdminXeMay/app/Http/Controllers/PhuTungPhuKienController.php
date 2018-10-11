<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhuTungPhuKienController extends Controller
{
    function getThongKeIndex(){
        return view('thongkephutungphukien.phutungphukien');
    }
}
