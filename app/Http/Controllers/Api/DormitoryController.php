<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DormitoryModels;
use Illuminate\Http\Request;
use MStaack\LaravelPostgis\Geometries\LineString;
use MStaack\LaravelPostgis\Geometries\MultiPolygon;
use MStaack\LaravelPostgis\Geometries\Point;
use MStaack\LaravelPostgis\Geometries\Polygon;

class DormitoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
         //
        //TODO: Store value in here
        //Input from user
        $formData = $request->has("data")?$request->get("data"):"";
        $coordinates = $formData["geom"];
        $features = DormitoryModels::where([['floor','=',$formData["floor"]], ["id", "=", $id]])->firstOrFail();

        /*
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
        $dormitoryzone = $formData["dormitoryzone"];
        $range = $formData["range"];
        $floor = $formData["floor"];
        $roomquantity = $formData["roomquantity"];
        $roomcapity = $formData["roomcapity"];
        $floorcapity = $formData["floorcapity"];
        $cook = $formData["cook"];
        $roomarea = $formData["roomarea"];
        $building = $formData["building"];
        $contruclevel = $formData["contruclevel"];
        $state = $formData["state"];
        $area = $formData["area"];
        $startusingyear = $formData["startusingyear"];

        //$features->id = $id;
        $features->dormitoryzone = $dormitoryzone;
        $features->range = $range;
        $features->floor = $floor;
        $features->roomquantity = $roomquantity;
        $features->roomcapity = $roomcapity;
        $features->floorcapity = $floorcapity;
        $features->cook = $cook;
        $features->roomarea = $roomarea;
        $features->building = $building;
        $features->contruclevel = $contruclevel;
        $features->state = $state;
        $features->area = $area;
        $features->startusingyear = $startusingyear;
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
        $feature = DormitoryModels::where("id", "=", $id)->firstOrFail();
        $feature->delete();
        return response()->json("Deleted!", 200);
    }
}
