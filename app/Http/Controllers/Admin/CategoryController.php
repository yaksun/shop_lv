<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController
{

    //  | GET|HEAD      | admin/category
    public function index()
    {

        return view('admin.category.index');
    }

    // | GET|HEAD   | admin/category/create
       public function create()
       {
           /* $category=Category::orderBy('cate_order','desc')->get();
            $data=$this->getTree($category);

           return view('admin.category.add',compact('data'));*/
           return view('admin.category.add');
       }


   /* public function getTree($data)
    {
        $arr=[];
        foreach ($data as $k=>$v){

            if($v->cate_pid==0){
                $data[$k]['_cate_name']=str_repeat('|--',$v->cate_level).$v->cate_name;
                $arr[]=$data[$k];

                foreach ($data as $m=>$n){
                    if($n->cate_pid==$v->cate_id){
                        $data[$m]['_cate_name']=str_repeat('|--',$n->cate_level).$n->cate_name;
                        $arr[]=$data[$m];
                    }

                }
            }
        }

        return $arr;
    }*/


    // POST | admin/category
    public function store()
    {
        $input=Input::except('_token');
        $category=Category::create($input);



        if($category->cate_pid==0){
            $arr['cate_path']="0-".$category->cate_id;
        }else{
            $pid=Category::where('cate_id',$category->cate_pid)->first();
            $arr['cate_path']=$pid->cate_path.'-'.$category->cate_id;
        }

       $arr['cate_level']=substr_count($arr['cate_path'],'-');


        $res=Category::where('cate_id',$category->cate_id)->update($arr);
        if($res){
            return redirect('admin/category');
        }else{
            return back()->with('errors','分类添加失败');
        }

    }

    // | GET|HEAD    | admin/category/{category}/edit
    public function edit($id)
    {
        $field=Category::where('cate_id',$id)->first();

        return view('admin.category.edit',compact('field'));
    }

    //  | PUT|PATCH   | admin/category/{category}
    public function update($id)
    {
        $input=Input::except('_token','_method');
        $res1=Category::where('cate_id',$id)->update($input);

        $category=Category::where('cate_id',$id)->first();

        if($category->cate_pid==0){
            $arr['cate_path']="0-".$category->cate_id;
        }else{
            $pid=Category::where('cate_id',$category->cate_pid)->first();
            $arr['cate_path']=$pid->cate_path.'-'.$category->cate_id;
        }

        $arr['cate_level']=substr_count($arr['cate_path'],'-');
        if($category->cate_pid==0){
            $arr['cate_path']="0-".$category->cate_id;
        }else{
            $pid=Category::where('cate_id',$category->cate_pid)->first();
            $arr['cate_path']=$pid->cate_path.'-'.$category->cate_id;
        }

        $arr['cate_level']=substr_count($arr['cate_path'],'-');

       $res2=Category::where('cate_id',$id)->update($arr);
       if($res1||$res2){
           return redirect('admin/category');
       }else{
           return back()->with('errors','分类修改失败');
       }

    }

    // | DELETE   | admin/category/{category}
    public function destroy($id)
    {
        //查找PID等于传入的ID，如果结果为空才删除
       $category=Category::where('cate_pid',$id)->get();

       if(empty($category->all())){
           $res=Category::where('cate_id',$id)->delete();
           if($res){
               $data=[
                   'status'=>0,
                    'msg'=>'分类删除成功'

               ];
           }else{
               $data=[
                   'status'=>1,
                   'msg'=>'分类删除失败'

               ];
           }
       }else{
           $data=[
               'status'=>2,
               'msg'=>'分类下有子集，不能删除'

           ];
       }


       return $data;
    }
}
