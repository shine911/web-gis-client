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
        $formData = $request->has("data")?$request->get("data"):"";
        $coordinates = $formData["geom"];
        $features = Room::where([['floor','=',$formData["floor"]], ["id", "=", $id]])->firstOrFail();

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
        }

        //Other in put from user
        //$roomid = $formData["id"];
        $roomcode = $formData["roomcode"];
        $roomVi = $formData["roomnamevi"];
        $roomEn = $formData["roomnameen"];
        $building = $formData["buildingcode"];
        $block = $formData["block"];
        $floor = $formData["floor"];
        $campusCode = $formData["campuscode"];
        $zoneCode = $formData["zonecode"];
        $using = $formData["usingpurposecode"];
        $length = $formData["length"];
        $with = $formData["width"];
        $area = $formData["area"];
        $capacity = $formData["roomcapacity"];
        $mAgencyCode = $formData["managementagencycode"];
        $note = $formData["note"];

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
        $features->note = $note;
        $features->save();
        //return redirect()->route('room.show', ['floor' => $floor, 'id'=>$id]);
        return response()->json("Saved!", 200);
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
