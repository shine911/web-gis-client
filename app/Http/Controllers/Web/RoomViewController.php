<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomViewController extends Controller
{
    //index
    public function index(){
        return view('/room/index');
    } 
}
