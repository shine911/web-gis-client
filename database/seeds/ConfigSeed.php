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
            'url' => 'http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:1',
        ]);
        FeaturesConfigUrl::insert([
            'feature_name' => 'Floor 2',
            'url' => 'http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:2'
        ]);
        FeaturesConfigUrl::insert([
            'feature_name' => 'Floor 3',
            'url' => 'http://localhost:8800/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:3'
        ]);
        FeaturesConfigUrl::insert([
            'feature_name' => 'Floor 4',
            'url' => 'http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:4'
        ]);
        FeaturesConfigUrl::insert([
            'feature_name' => 'Floor 5',
            'url' => 'http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:5'
        ]);
        FeaturesConfigUrl::insert([
            'feature_name' => 'Floor 6',
            'url' => 'http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:6'
        ]);
        FeaturesConfigUrl::insert([
            'feature_name' => 'Floor 7',
            'url' => 'http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:7'
        ]);
        FeaturesConfigUrl::insert([
            'feature_name' => 'Floor 8',
            'url' => 'http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:8'
        ]);
        FeaturesConfigUrl::insert([
            'feature_name' => 'Floor 9',
            'url' => 'http://localhost:8000/geoserver/ctu/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=ctu%3ARoom&maxFeatures=50&outputFormat=application%2Fjson&viewparams=floor:9'
        ]);
    }
}
