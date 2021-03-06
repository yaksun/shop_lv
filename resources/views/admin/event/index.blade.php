@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  活动管理
    </div>
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>活动列表</h3>
        </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增活动</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>活动列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>活动名称</th>
                        <th>介绍</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,'{{$v->event_id}}')" value="{{$v->event_order}}">
                        </td>
                        <td class="tc">{{$v->event_id}}</td>
                        <td>
                            <a href="#">{{$v->event_name}}</a>
                        </td>
                        <td>{{$v->event_title}}</td>
                        <td>
                            <a href="{{url('admin/event').'/'.$v->event_id.'/edit'}}">修改</a>
                            <a href="javascript:;" onclick="delCate({{$v->event_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>


    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(obj,event_id) {
           var event_order= $(obj).val();
           $.post('{{url('admin/event/changeorder')}}',{'_token':'{{csrf_token()}}',event_id:event_id,event_order:event_order},function (data) {
                if(data.status==0){
                    layer.alert(data.msg, {icon: 6});
                }
           });
        }

        function delCate(event_id) {
            //询问框
            layer.confirm('你确定要删除该活动吗', {
                btn: ['确定','取消'] //按钮
            }, function(){
                    $.post("{{url('admin/event')}}"+'/'+event_id,{'_method':'delete','_token':'{{csrf_token()}}',event_id:event_id},function (data) {
                        if(data.status==0){
                            location.href=location.href;
                            layer.alert(data.msg, {icon: 6});
                        }else{
                            layer.alert(data.msg, {icon: 5});
                        }
                    });
            }, function(){

                /*layer.msg('也可以这样', {
                    time: 20000, //20s后自动关闭
                    btn: ['明白了', '知道了']
                });*/
            });
        }
    </script>
@endsection
