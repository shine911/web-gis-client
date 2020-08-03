<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebMapEditorController extends Controller
{
    public function index(){
        return view('mapeditor/index');
    }
}
