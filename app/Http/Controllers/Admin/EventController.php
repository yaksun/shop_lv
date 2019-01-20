<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{   
    
    //  | GET|HEAD     | admin/category    
    public function index()
    {
        $data=Event::all();
        return view('admin.event.index',compact('data'));
    }
    
    //   | GET|HEAD    | admin/event/create
    public function create()
    {
        $data=[];

        return view('admin.event.add',compact('data'));
    }

    // POST  | admin/event
    public function store()
    {
        $input=Input::except('_token');
        $rule=[
            'event_name'=>'required'
        ];
        $msg=[
            'event_name.required'=>'活动名称不能为空'
        ];

        $validator=Validator::make($input,$rule,$msg);

        if($validator->passes()){
            $res=Event::create($input);
            if($res){
                return back()->with('errors','活动添加成功');
            }else{
                return back()->with('errors','活动添加失败');
            }
        }else{
            return back()->withErrors($validator);
        }

    }
    
    // | GET|HEAD    | admin/event/{event}/edit
    public function edit($id)
    {
       $field=Event::where('event_id',$id)->first();
       return view('admin.event.edit',compact('field'));

    }

    public function changeOrder()
    {
        $input = Input::all();
        $res=Event::where('event_id', $input['event_id'])->update(['event_order' => $input['event_order']]);
        if($res){
            $data=[
                'status'=>'0',
                'msg'=>'活动排序OK'
            ];
        }else{
            $data=[
                'status'=>'1',
                'msg'=>'活动排序失败'
            ];
        }

        return $data;
    }

    //    | DELETE     | admin/event/{event}
    public function destroy()
    {
       $input=Input::all();
       $res=Event::where('event_id',$input['event_id'])->delete();
       if($res){
           $data=[
               'status'=>0,
               'msg'=>'活动删除成功'
           ];
       }else{
           $data=[
               'status'=>1,
               'msg'=>'活动删除失败'
           ];
       }
       return $data;
    }
}
