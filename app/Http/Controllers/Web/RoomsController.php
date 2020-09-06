<?php

namespace App\Http\Controllers\Web;

use App\FeaturesConfigUrl;
use App\Http\Controllers\Controller;
use App\Room;
use App\tang1_tret;
use Illuminate\Http\Request;

class RoomsController extends Controller
{

    public function index(Request $request, $floor){
        //Get floor Url
        $floorObj = FeaturesConfigUrl::find($floor)->first();
        $floors = FeaturesConfigUrl::all();
        
        $search = $request->has('search') ? $request->get('search') : '';
        $room = Room::where('floor', '=', $floor)->orderBy('id')->paginate(10);

        $data = ["floor"=>$floorObj, "search"=>$search, "data"=>$room, "floors"=>$floors];

        return view("floor/index", $data);
    }

    public function detail($floor, $id){
        /*
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
        */

        $floors = FeaturesConfigUrl::all();
        $room = Room::where([['floor', '=', $floor], ['id', '=', $id]])->firstOrFail();
        $floor = FeaturesConfigUrl::where('id', '=', $floor)->first();
        $url = $floor->url."&featureid=$id";
        $data = ['floor' => $floor, 'data'=>$room, 'url' => $url, "floors"=>$floors];
        return view('floor/detail', $data);
    }

    public function insert(){
        
    }
}
