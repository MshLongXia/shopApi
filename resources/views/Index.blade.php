<!DOCTYPE html>
<html style="background: #F5F9FC">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>shopApi</title>
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/list.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        .layui-side-scroll .layui-nav .layui-nav-item a:hover {
            color: white;
            background-color: #E60019;
        }
        .layui-side-scroll .layui-nav .layui-nav-item a:hover .layui-nav-more {
            border-color: #fff transparent transparent;
        }

        .layui-side-scroll .layui-nav .layui-nav-item a:hover .nav-img {
            display: none !important;
        }

        .layui-side-scroll .layui-nav .layui-nav-item a:hover .nav-img-clicked {
            display: inline !important;
        }
    </style>

</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-side layui-bg-gray">
        <div style="
        color: red;
        height: 110px;
        text-align: center;
        padding-bottom: 10px;
        line-height: 140px;
        border-top-right-radius: 2em;
        background: white;
">
            <img src="{{asset('logo/logo.png')}}" width="70%" alt="" style="position: relative;right: 2%" id="logo">
        </div>
        <div class="layui-side-scroll">
            {{--            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->--}}
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                @foreach($menu as $parent_menu)
                    <li class="layui-nav-item" value="son_{{$parent_menu['id']}}">
                        <a href="javascript:;">
{{--                            <div style="width: 20px;display: inline-block"></div>--}}
                            <img class="nav-img" src="{{asset(explode('|',$parent_menu['url'])[0])}}" alt="">
                            <img class="nav-img-clicked" src="{{asset(explode('|',$parent_menu['url'])[1])}}"
                                 alt="">
                            <span class="nav-item-span">{{ $parent_menu['name'] }}</span>
                        </a>
                    </li>
                    @if (array_key_exists('son',$parent_menu))--}}
                    <div class="nav-child" id="son_{{$parent_menu['id']}}" style="display: none">
                        @foreach($parent_menu['son'] as $son_menu)
                            <div class="nav-child-div layui-this">
                                <a href="{{$son_menu['url']}}"
                                   target="eatbody"
                                   class="nav-child-div-a">{{ $son_menu['name'] }}</a>
                            </div>
                        @endforeach
                    </div>
                    @else
                        @continue
                    @endif
                @endforeach
            </ul>
            <div class="return-div" id="return">
                <img src="{{asset('logo/return.png')}}" class="nav-img">
            </div>
        </div>
    </div>
    <div style="height: 100%;width: 100%"></div>
    <ul class="layui-nav layui-layout-right" style="position: absolute;top: 35px;background:transparent;z-index: 1000">
        <li class="top-nav-item">
            <a href="{{ URL('auth/changPwd') }}" target="eatbody"
               style="padding: 0px;margin-right: 25px;color: #3f3f3f;font-weight: 550;font-size: 16px">修改密码</a>
        </li>
        <li class="top-nav-item">
            <a href="{{ URL('auth/loginOut') }}"
               style="padding: 0px;margin-right: 50px;color: #3f3f3f;font-weight: 550;font-size: 16px">退出</a>
        </li>
    </ul>
    <div class="layui-body" style="padding: 30px;padding-top:50px;top:0;">
        <!-- 内容主体区域 -->
        <iframe name='eatbody' src="" frameborder="0" id="demoAdmin"
                style="width: 100%; height: 100%; border-radius: 2em;"></iframe>
    </div>
</div>

<script src="{{asset('layui/layui.js')}}"></script>
<script>
    //JavaScript代码区域
    layui.use(['element', 'form'], function () {
        var form = layui.form,
            $ = layui.$,
            checkNav, is_simple = 0,show_id,checkChild,min_width = 40,min_radius = '50%';
        // $(".layui-nav-item").hover(function(){
        //     if(show_id != null){
        //         is_simple = 0;
        //         $(show_id).css('display','none');
        //         changeNavStyle('b');
        //     }
        // },function(){
        //     if(show_id != null){
        //         is_simple = 1;
        //         $(show_id).css('display','block');
        //         changeNavStyle('m');
        //     }
        // })
        $('.layui-nav-item').on('click',function () {
            $('.nav-img').each(function () {
                layui.$(this).css('display', 'inline');
            });
            $('.nav-img-clicked').each(function () {
                layui.$(this).css('display', 'none');
            });
            if (checkNav != null) {
                checkNav.find('a').removeClass('layui-parent-this');
            }
            if(show_id != null){
                $(show_id).css('display','none');
            }
            // $(this).find('a').addClass('layui-parent-this');
            $(this).find('a').find('.nav-img-clicked').css('display', 'inline');
            $(this).find('a').children('.nav-img').css('display', 'none');
            show_id = '#'+$(this).attr('value');
            $(show_id).css('display','block')
            checkNav = $(this);
            is_simple = 1;
            changeNavStyle('m');
        });
        $('#return').on('click',function () {
            if(is_simple == 1){
                is_simple= 0;
                if(show_id != null){
                    $(show_id).css('display','none');
                }
                changeNavStyle('b');
            }else{
                is_simple= 1;
                if(show_id != null){
                    $(show_id).css('display','block');
                }
                changeNavStyle('m');
            }
        });
        $('.nav-child-div-a').on('click',function () {
            if(checkChild != null){
                checkChild.removeClass('nav-child-this');
                checkChild.parent('.nav-child-div').removeClass('nav-child-div-this');
            }
            checkChild = $(this);
            $(this).addClass('nav-child-this');
            $(this).parent('.nav-child-div').addClass('nav-child-div-this');
        });
        function changeNavStyle(style) {
            if(style == 'm'){
                $('.layui-nav-item').width(min_width + 'px');
                $('.layui-nav-item').css('border-radius',min_radius);
            }else{
                $('.layui-nav-item').width('240px');
                $('.layui-nav-item').css('border-radius','2em');
            }
        }
    });
</script>
</body>
</html>
