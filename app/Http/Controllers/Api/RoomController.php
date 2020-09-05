<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Room;
use MStaack\LaravelPostgis\Geometries\LineString;
use MStaack\LaravelPostgis\Geometries\MultiPolygon;
use MStaack\LaravelPostgis\Geometries\Point;
use MStaack\LaravelPostgis\Geometries\Polygon;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $floor = $request->has('floor')?$request->get('floor'):1;
        
        //Get all list of Room
        $room = Room::where('floor', '=', $floor)->paginate(10);

        //return room
        return response()->json($room);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $floor)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
                //TODO: Store value in here
        //Input from user
        $coordinates = $request->has("geom")?$request->get("geom"):"";
        $floor = $request->has("floor")?$request->get('floor'):"";
        $features = Room::where([['floor','=',$floor], ["id", "=", $id]])->firstOrFail();

        /**
         * If you see coordinates from Vue client then we will update geom in database
         * Separate update geom data and text data
         */
        if(strlen($coordinates)!=0 ){
            $geo_array = json_decode($coordinates, true);
            $point_array = array();
            $linestring_array = array();
            $polygon_array = array();
            //Point to Multipolygon Alg by shine911
            /**
             * Convert point to multipolygon
             * Input: Coordinates from client
             * Process: Point -> LineStrings -> Polygon -> Multipolygon
             * Output: Multipolygon type
             */
            foreach ($geo_array as $polygon){
                foreach ($polygon as $linestring){
                    foreach ($linestring as $pointValue){
                        $point = new Point($pointValue[1], $pointValue[0]);
                        array_push($point_array, $point);
                    }
                    array_push($linestring_array, new LineString($point_array));
                }
                array_push($polygon_array, new Polygon($linestring_array));
            }
            $features->geom = new MultiPolygon($polygon_array);
            $features->save();
            return response()->json($features->geom);
        }

        //Other in put from user
        $roomid = $request->has('id')?$request->get('id'):response()->json('no', 500);
        $roomcode = $request->has('roomcode')?$request->get('roomcode'):"";
        $roomVi = $request->has('roomnamevi')?$request->get('roomnamevi'):"";
        $roomEn = $request->has('roomnameen')?$request->get('roomnameen'):"";
        $building = $request->has('buildingcode')?$request->get('buildingcode'):"";
        $block = $request->has('block')?$request->get('block'):"";
        $floor = $request->has('floor')?$request->get('floor'):"";
        $campusCode = $request->has('campuscode')?$request->get('campuscode'):"";
        $zoneCode = $request->has('zonecode')?$request->get('zonecode'):"";;
        $using = $request->has('usingpurposecode')?$request->get('usingpurposecode'):"";
        $length = $request->has('length')?$request->get('length'):response()->json('no', 500);
        $with = $request->has('width')?$request->get('width'):response()->json('no', 500);
        $area = $request->has('area')?$request->get('area'):response()->json('no', 500);
        $capacity = $request->has('roomcapacity')?$request->get('roomcapacity'):response()->json('no', 500);
        $mAgencyCode = $request->has('managementagencycode')?$request->get('managementagencycode'):response()->json('no', 500);

        //$features->id = $id;
        $features->roomcode = $roomcode;
        $features->roomnamevi = $roomVi;
        $features->roomnameen = $roomEn;
        $features->buildingcode = $building;
        $features->block = $block;
        $features->floor = $floor;
        $features->campuscode = $campusCode;
        $features->zonecode = $zoneCode;
        $features->length = $length;
        $features->width = $with;
        $features->area = $area;
        $features->roomcapacity = $capacity;
        $features->usingpurposecode = $using;
        $features->managementagencycode = $mAgencyCode;
        $features->save();
        return redirect()->route('room.show', ['floor' => $floor, 'id'=>$id]);
        //return response()->json($features->geom);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
