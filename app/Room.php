<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //table
    protected $table = 'room';

    //set primary key
    protected $primary_key = 'roomid';

    //no timestamp set
    public $timestamps = false;


}
