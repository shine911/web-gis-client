<?php

use App\FeaturesConfigUrl;
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
        //
        FeaturesConfigUrl::insert([
            'feature_name' => 'Floor 1',
            'url' => 'http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:1',
        ]);
        FeaturesConfigUrl::insert([
            'feature_name' => 'Floor 2',
            'url' => 'http://localhost:8600/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:2'
        ]);
    }
}
