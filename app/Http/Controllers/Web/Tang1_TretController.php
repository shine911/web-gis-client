<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\tang1_tret;
use Illuminate\Http\Request;

class Tang1_TretController extends Controller
{
    //
    public function index(){
        $tang1_tret = tang1_tret::paginate(10);

        $data = ["data"=>$tang1_tret];
        return view("tang1_tret/index", $data);
    }

    public function detail($id){
        $port = 8600;
        $localhost = "localhost:$port/geoserver";
        $workspace = "ctu";
        $layer = "tang1_tret";
        $filter = "$layer.$id";
        $url = "http://$localhost/$workspace/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=$workspace:$layer&outputFormat=application/json&featureid=$filter";
        $data = ["url"=>$url, "name"=>$layer.$id];
        return view('tang1_tret/detail', $data);
    }
}
