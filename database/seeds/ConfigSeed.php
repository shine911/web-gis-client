<?php
namespace Database\Seeders;

use App\Models\LayersModel;
use Illuminate\Database\Seeder;

class ConfigSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CREATE exist room data change $i <= 5 to increase more floor
        for($i = 1; $i <= 9; $i++) {
            $layer = new LayersModel;
            $layer->layer_name = "Dãy phòng tầng $i";
            $layer->url = "http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu:room_by_floor&outputFormat=application%2Fjson&viewparams=floor:$i";
            $layer->layer_type = 0;
            $layer->floor = $i;
            $layer->user_hide = false;
            $layer->save();
            /*
            LayersModel::insert([
                'layer_name' => "Floor $i",
                'url' => "http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu:room_by_floor&outputFormat=application%2Fjson&viewparams=floor:$i",
                'layer_type' => 0,
                'floor' => $i,
                'user_hide' => false,
            ]);
            */
        }

    }
}
