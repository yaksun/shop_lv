<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table='event';
    protected $primaryKey='event_id';
    public $timestamps=false;
    //禁止的字段,赋值为空
    public $guarded=[];
}
