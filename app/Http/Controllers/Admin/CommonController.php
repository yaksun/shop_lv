<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use App\Http\Model\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        $category=Category::orderBy('cate_path')->get();

        $data=[];
        foreach ($category as $k=>$v){
            $category[$k]['_cate_name']=str_repeat('|--',$v->cate_level).$v->cate_name;
            $data[]=$category[$k];
        }

        $event=Event::all();

        View::share('data',$data);
        View::share('event',$event);
    }



}
