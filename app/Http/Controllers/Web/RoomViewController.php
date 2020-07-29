<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RoomViewController extends Controller
{
    //index
    public function index(Request $request){
        $search = $request->has('search') ? $request->get('search') : '';
        $room = Room::where('roomcode', 'LIKE', '%'.$search.'%')->paginate(15);
        $data = ["room" => $room,
                "search" => $search,
    ];
        return view('/room/index', $data);
    }

    public function detail(Request $req){
        if(!$req->has('id')){
            return redirect()->action('RoomViewController@index')->with('message', 'Something is wrong');
        }
        $id = $req->get('id');
        $room = Room::where('roomid', '=', $id)->first();
        if(!$room){
            return redirect()->action('RoomViewController@index')->with('message', 'Something is wrong');
        }
        $data = ['room' => $room];
        return view('/room/detail', $data);
    }
}
