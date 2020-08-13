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
        $this->port = config('app.geoserver.port', 8600 );
        $this->localhost = config('app.geoserver.hostname', 'localhost');
        $this->appname = config('app.geoserver.appname', 'geoserver');
        $this->workspace = config('app.geoserver.workspace', 'ctu');
    }
    public function index(Request $request){
        $localhost = $this->localhost;
        $port = $this->port;
        $appname = $this->appname;
        $workspace = $this->workspace;
        $layer = 'room';
        //format localhost:port/appname
        $search = $request->has('search') ? $request->get('search') : '';
        $localhost = "$localhost:$port/$appname";
        $url = "http://$localhost/$workspace/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=$workspace:$layer&outputFormat=application/json";
        $tang1_tret = tang1_tret::where('roomcode', 'LIKE', '%'.$search.'%')->orderBy("id")->paginate(10);
        $filter = "&featureid=";
        foreach($tang1_tret as $room){
            $filter = $filter."$layer.$room->id,";
            $url = "http://$localhost/$workspace/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=$workspace:$layer&outputFormat=application/json$filter";

        }
        $data = ["data"=>$tang1_tret, "url"=>$url, "search" => $search];
        return view("tang1_tret/index", $data);
    }

    public function detail($id){
        $room = tang1_tret::where('id', '=', $id)->firstOrFail();
        $localhost = $this->localhost;
        $port = $this->port;
        $appname = $this->appname;
        $workspace = $this->workspace;
        $layer = 'room';
        //format localhost:port/appname
        $localhost = "$localhost:$port/$appname";
        $filter = "$layer.$id";
        $url = "http://$localhost/$workspace/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=$workspace:$layer&outputFormat=application/json&featureid=$filter";
        
        //Get room information
        
        $data = ["url"=>$url, "name"=>$layer.$id, "id"=>$id, "data" => $room];
        return view('tang1_tret/detail', $data);
    }

    public function insert(){
        
    }
}
