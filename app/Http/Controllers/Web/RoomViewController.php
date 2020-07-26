<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Room;
use Illuminate\Http\Request;

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
}
