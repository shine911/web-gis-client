<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\tang1_tret;
use Illuminate\Http\Request;

class Tang1_TretController extends Controller
{
    private $port;
    private $localhost;
    private $appname;
    private $workspace;
    protected $layer;
    protected $index;
    protected $detail;

    public function __construct()
    {
        $this->port = config('app.geoserver.port',  8888);
        $this->localhost = config('app.geoserver.hostname');
        $this->appname = config('app.geoserver.appname', 'geoserver');
        $this->workspace = config('app.geoserver.workspace', 'ctu');
    }
    public function index(){
        $tang1_tret = tang1_tret::orderBy("gid")->paginate(10);
        $data = ["data"=>$tang1_tret];
        return view("tang1_tret/index", $data);
    }

    public function detail($id){
        $localhost = $this->localhost;
        $port = $this->port;
        $appname = $this->appname;
        $workspace = $this->workspace;
        $layer = 'tang1_tret';
        $filter = "$layer.$id";
        $url = "http://$localhost/$workspace/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=$workspace:$layer&outputFormat=application/json&featureid=$filter";
        $data = ["url"=>$url, "name"=>$layer.$id];
        return view('tang1_tret/detail', $data);
    }

    public function insert(){
        
    }
}
