<?php
namespace Database\Seeders;

use App\LayersModel;
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
        for($i = 1; $i <= 5; $i++) {
            LayersModel::insert([
                'layer_name' => "Floor $i",
                'url' => "http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu:room_by_floor&outputFormat=application%2Fjson&viewparams=floor:$i",
                'layer_type' => 0,
                'user_hide' => false,
            ]);
        }

    }
}
