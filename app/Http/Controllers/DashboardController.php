<?php

namespace App\Http\Controllers;

use App\Models\LayersModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //index
    public function index(){
        $floors = LayersModel::all();
        $data = ["floors"=>$floors];
        return view('home2', $data);
    }
}
