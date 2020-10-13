<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DormitoryModels;
use App\Models\LayersModel;
use Illuminate\Http\Request;

class DormitoryController extends Controller{
    public function index(Request $req, $layerId, $floor){
        $layerObj = LayersModel::where("id", "=", $layerId)->firstOrFail();
        $search = $req->get('search')??'';
        $dormitory = DormitoryModels::where("floor", '=', $floor)->orderBy('id')->paginate(10);
        $data = ["data" => $dormitory, "layerObj" => $layerObj, "search" => $search];
        return view('dormitory/index', $data);
    }

    public function detail($layerId, $floor, $id){
        $room = DormitoryModels::where([['floor', '=', $floor], ['id', '=', $id]])->firstOrFail();
        $floor = LayersModel::where('id', '=', $layerId)->first();
        $url = $floor->url."&featureid=$id";
        $data = ['floor' => $floor, 'data'=>$room, 'url' => $url];
        return view('dormitory/detail', $data);
    }
}