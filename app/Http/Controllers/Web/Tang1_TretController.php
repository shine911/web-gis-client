<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\tang1_tret;
use Illuminate\Http\Request;

class Tang1_TretController extends Controller
{
    //
    public function index(){
        $tang1_tret = tang1_tret::all();
        $data = ["data"=>$tang1_tret];
        return view("tang1_tret/index", $data);
    }
}
