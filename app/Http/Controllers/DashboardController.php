<?php

namespace App\Http\Controllers;

use App\Models\LayersModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //index
    public function index(){
        $electricNetwork =  LayersModel::where('layer_type', '=', 2)->get();
        $data = ['electricNetwork' => $electricNetwork ];
        return view('home2', $data);
    }
}
