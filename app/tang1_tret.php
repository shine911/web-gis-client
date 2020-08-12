<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;
class tang1_tret extends Model
{
    public $timestamps = false;
    protected $table = "tang1_tret";
    //
    use PostgisTrait;

    protected $postgisFields = [
        'geom'
    ];

    protected $postgisTypes = [
        'geom' => [
            'geomtype' => 'geometry',
            'srid' => 0 //Default map is srid 0 need to be convert to 3857
        ]
    ];
}
