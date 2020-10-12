<?php

namespace App\Http\Controllers;

use App\Models\LayersModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //index
    public function index(){
        $urlFloors = LayersModel::where("layer_type", "=", 0)->orderBy('floor')->get();
        $urlDormitys = LayersModel::where("layer_type", "=", 1)->orderBy('floor')->get();
        $data = ['url' => $urlFloors, 'urlDormitys' => $urlDormitys ];
        return view('home2', $data);
    }
}
