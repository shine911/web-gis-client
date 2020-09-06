<?php

namespace App\Http\Controllers;

use App\FeaturesConfigUrl;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //index
    public function index(){
        $floors = FeaturesConfigUrl::all();
        $data = ["floors"=>$floors];
        return view('home2', $data);
    }
}
