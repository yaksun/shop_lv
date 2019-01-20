<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use App\Http\Model\Event;
use App\Http\Model\Goods;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class GoodsController extends CommonController
{
    //  | GET|HEAD   | admin/goods
    public function index()
    {

        $goods=Goods::join('event','goods.event_id','=','event.event_id')->join('category','goods.cate_id','=','category.cate_id')->get();

        return view('admin.goods.index',compact('goods'));
    }

    //   | GET|HEAD         | admin/goods/create
    public function create()
    {
        return view('admin.goods.add');
    }

    // POST   	| admin/goods
    public function store()
    {
        $input=Input::except('_token');
        $input['goods_time']=time();
        $res=Goods::create($input);
        if($res){
            return redirect('admin/goods');
        }else{
            return back()->with('errors','商品添加失败');
        }


    }


    public function upload()
    {
        $file=Input::file('Filedata');
        if($file->isValid()){
            //获取文件后缀
            $suffix=$file->getClientOriginalExtension();
            //拼装新的文件名
            $fileName=time().rand(100,999).'.'.$suffix;
            //将文件移动的指定路径
            $file->move(base_path().'/uploads',$fileName);
            return $newPath='uploads/'.$fileName;
        }
    }

    public function show()
    {
        
    }

    // GET|HEAD     | admin/goods/{goods}/edit
    public function edit($id)
    {
        $goods=Goods::join('event','goods.event_id','=','event.event_id')->join('category','goods.cate_id','=','category.cate_id')->where('goods_id',$id)->first();


        return view('admin.goods.edit',compact('goods'));
    }

    // | PUT|PATCH    | admin/goods/{goods}
    public function update($id)
    {
       $input= Input::except('_method','_token');

        Goods::where('goods_id',$id)->update($input);

    }
}
