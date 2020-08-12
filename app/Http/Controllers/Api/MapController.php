<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\tang1_tret;
use MStaack\LaravelPostgis\Geometries\LineString;
use MStaack\LaravelPostgis\Geometries\MultiPolygon;
use Illuminate\Http\Request;
use MStaack\LaravelPostgis\Geometries\Point;
use MStaack\LaravelPostgis\Geometries\Polygon;

class MapController extends Controller
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
        $features = tang1_tret::where('id','=',$id)->first();
        return response()->json($features);
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
        $coordinates = $request->has("geom")?$request->get("geom"):"";
        $features = tang1_tret::where('gid','=',$id)->first();
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
