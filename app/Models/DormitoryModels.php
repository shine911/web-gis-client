<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class DormitoryModels extends Model
{
    protected $table = 'dormitory';
    public $timestamps = false;

    use PostgisTrait;

    protected $postgisFields = [
        'geom'
    ];

    protected $postgisTypes = [
        'geom' => [
            'geomtype' => 'geometry',
            'srid' => 0 //Default map is srid 0 for exactly data ==> Dont know why ???
        ]
    ];
}
