@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>文章列表</h3>
        </div>

    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>文章列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>品名</th>
                        <th>标题</th>
                        <th>缩略图</th>
                        <th>分类</th>
                        <th>参与活动</th>
                        <th>库存数量</th>
                        <th>上架时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($goods as $v)
                    <tr>
                        <td class="tc">{{$v->goods_id}}</td>
                        <td>
                            <a href="#">{{$v->goods_name}}</a>
                        </td>
                        <td>{{$v->goods_title}}</td>
                        <td><img width="100px" src="/{{$v->goods_thumb}}" alt="{{$v->goods_name}}"></td>
                        <td>{{$v->cate_name}}</td>
                        <td>{{$v->event_name}}</td>
                        <td>{{$v->goods_number}}</td>
                        <td>{{date('Y-m-d',$v->goods_time)}}</td>
                        <td>
                            <a href="{{url('admin/goods').'/'.$v->goods_id}}/edit">修改</a>
                            <a href="javascript:;" onclick="delArt({{$v->goods_id}})">删除</a>
                        </td>
                    </tr>
                        @endforeach
                </table>
                <div class="page_list">
                 {{--  {{$data->links()}}--}}

                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <style>
        .result_content ul li span {
            font-size: 15px;
            padding: 6px 12px;
            text-decoration: none;
        }
    </style>
    <script>
        function delArt(art_id) {
            //询问框
            layer.confirm('你确定要删除这篇文章吗', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/article')}}"+'/'+art_id,{'_method':'delete','_token':'{{csrf_token()}}',art_id:art_id},function (data) {
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
