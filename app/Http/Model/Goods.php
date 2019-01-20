<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table='goods';
    protected $primaryKey='goods_id';
    public $timestamps=false;
    //禁止的字段,赋值为空
    public $guarded=[];
}
