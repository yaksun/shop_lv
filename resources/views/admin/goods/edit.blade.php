@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;文章管理
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3> 添加文章</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>文章列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/goods/'.$goods->goods_id)}}" method="post">
            <input type="hidden" name="_method" value="put">

            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>

                    <th><i class="require">*</i>品名：</th>
                    <td>
                        <input type="text" name="goods_name"  value="{{$goods->goods_name}}"><span>商品名称必须填写</span>
                    </td>
                </tr>
                <tr>
                    <th>标题</th>
                    <td>
                        <input type="text" name="goods_title" class="lg" value="{{$goods->goods_title}}">
                    </td>
                </tr>
                <tr>
                    <th width="120">分类：</th>
                    <td>
                        <select name="cate_id" >
                            @foreach($data as $d)
                            <option value="{{$d->cate_id}}"
                            @if($d->cate_id==$goods->cate_id)
                            selected
                                    @endif
                            >{{$d->_cate_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th width="120">参与促销：</th>
                    <td>
                        @foreach($event as $e)
                        <input type="radio" name="event_id" value="{{$e->event_id}}"
                        @if($e->event_id==$goods->event_id)
                            checked
                        @endif
                        >{{$e->event_name}}&nbsp;&nbsp;
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <th>进价：</th>
                    <td>
                        <input type="text" name="goods_bid" class="sm" value="{{$goods->goods_bid}}">
                    </td>
                </tr>
                <tr>
                    <th>售价：</th>
                    <td>
                        <input type="text" name="goods_price"  class="sm" value="{{$goods->goods_price}}" >
                    </td>
                </tr>
                <tr>
                    <th>数量：</th>
                    <td>
                        <input type="text" name="goods_keywords"  value="{{$goods->goods_number}}">
                    </td>
                </tr>
                <tr>
                    <th>缩略图</th>
                    <td>
                        <input type="text" name="goods_thumb" value="{{$goods->goods_thumb}}">
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                        <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                        <link rel="stylesheet" type="text/css" href="{{asset('resources/org/uploadify/uploadify.css')}}">
                        <script type="text/javascript">
                            <?php $timestamp = time();?>
                             $(function() {
                                $('#file_upload').uploadify({
                                    'buttonText' :'图片上传',
                                    'formData'     : {
                                        'timestamp' : '<?php echo $timestamp;?>',
                                        '_token'     : '{{csrf_token()}}'
                                    },
                                    'swf'      : "{{asset('resources/org/uploadify/uploadify.swf')}}",
                                    'uploader' : "{{asset('/admin/goods/upload')}}",
                                    'onUploadSuccess' : function (file,data,response) {
                                        $('input[name=goods_thumb]').val(data);
                                        $('#goods_thumb_src').attr('src','/'+data);
                                    }
                                });
                            });
                        </script>
                        <style>
                            .uploadify{display:inline-block;}
                            .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                            table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                        </style>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <img  alt="" id="goods_thumb_src" style="max-width: 350px; max-height: 200px" src="/{{$goods->goods_thumb}}">
                    </td>
                </tr>

                <tr>
                    <th>商品详情：</th>
                    <td>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                        <script id="editor" name="goods_intro" type="text/plain" style="width:1024px;height:500px;">{!! $goods->goods_intro !!}</script>
                        <script type="text/javascript">

                        //实例化编辑器
                        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                        var ue = UE.getEditor('editor');
                        </script>
                        <style>
                            .edui-default{line-height: 28px;}
                            div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                            {overflow: hidden; height:20px;}
                            div.edui-box{overflow: hidden; height:22px;}
                        </style>
                    </td>
                </tr>
                <tr>
                    <th>关键字：</th>
                    <td>
                        <input type="text" name="goods_keywords"  class="lg" value="{{$goods->goods_keywords}}">
                    </td>
                </tr>
                <tr>
                    <th>描述：</th>
                    <td>
                        <input type="text" name="goods_description"  class="lg"  value="{{$goods->goods_description}}">
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection

