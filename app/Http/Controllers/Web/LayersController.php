<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LayersModel;
use Illuminate\Http\Request;

class LayersController extends Controller
{
    //index page
    public function index(){
        $layer = LayersModel::paginate(10);
        $search = '';
        $data = ["dataLayer"=>$layer, "search" => $search];
        return view('layers.index', $data);
    }
    public function create(){
        $floors = LayersModel::where("layer_type", "=", 0)->get();
        $data = ["floors"=>$floors];
        return view('layers.create', $data);
    }

    public function createPost(Request $req){
        $layer = new LayersModel();
        $layer_name = $req->get('layer_name');
        $url = $req->get('url');
        $layer_type = $req->get('layer_type');
        $user_hidden = $req->get('user_hidden');

        $layer->layer_name = $layer_name;
        $layer->url = $url;
        $layer->layer_type = $layer_type;
        $layer->user_hide = $user_hidden??false;
        $layer->save();
        return redirect('/layers');
    }
    public function detail($id){
        $layer = LayersModel::where("id", "=", $id)->firstOrFail();
        $data = [ "layer" => $layer];
        return view('layers.detail', $data);
    }

    public function detailPost($id, Request $req){
        $layer = LayersModel::where("id", "=", $id)->firstOrFail();
        $layer_name = $req->get('layer_name');
        $url = $req->get('url');
        $layer_type = $req->get('layer_type');
        $user_hidden = $req->get('user_hidden');

        $layer->layer_name = $layer_name;
        $layer->url = $url;
        $layer->layer_type = $layer_type;
        $layer->user_hide = $user_hidden??false;
        $layer->save();
        return redirect('/layers');
    }
}
