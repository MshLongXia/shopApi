<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/layui/css/layui.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/eat_ui.css">
    <style>
        body{
            width: 99vw;
            height: 100vh;
            background: #F5F9FC;
            overflow-y: hidden;
        }
        .layui-form-label{
            width: 80px;
        }
        /*
        .background{
            width: 100%;
            height: 100%;
            background: url({{asset('logo/Background.jpg')}}) no-repeat;
            background-size: cover;
        }*/
        .right{
            height:100%;
        }
        label.eat_black {
            font-size:31px;
            font-weight:bold;
            width:auto;
        }
        label.eat_gray {
            font-size:27px;
            font-weight:normal;
            width:auto;
        }
        div.eat_gray {
            width:100%;
            text-align:center;
            font-size:16px;
            font-weight:normal;
        }

        .div-form, .div-form-input{
            background-color:transparent;
        }

        .layui-form-item {
            border:0;
        }

        .div-form-input{
            border-width: 1.5px;
            border-style: solid;
            border-color: #DDDDDD;
            border-radius: 15px;
            padding-left: 30px;
            margin-left: 0px;
            border-radius: 2em;
            width:400px;
            line-height: normal;
            height:53px;
            font-size: 20px;
        }
        .div-form-input::-webkit-input-placeholder{
            color: #D9D9D9;
            font-size: 20px;
        //transform: translate(0, -4px);
        }

        .login-captcha{
            margin-left: -134px;
            width: 120px;
            height: 36px;
        }
        .form-div{
            width:400px;
            padding:0;
        }
        .login-btn{
            width:420px;
            height:56px;
            margin:0;
            font-size:28px;
        }
    </style>
</head>
<body>
<div class="background">
    <img id='banner' src="{{asset('logo/eat-admin.jpg')}}" style="height:1px; width:1px;" alt="">
</div>
<div id='content' class="div-form search-div">
    <form class="layui-form" action="" method="post" onsubmit="return false;">
        <div class="layui-inline">
            <p><label class='eat_black'>Welcome,</label>&nbsp;&nbsp;<label class='eat_gray'> please login to</label></p>
            <p><label class='eat_gray'>your account</label></p>
        </div><br/><br/><br/>
        <div class="layui-form-item">
            <input type="text"
                   name="username"
                   required lay-verify="required"
                   placeholder="Please type username"
                   autocomplete="off" class="div-form-input">
        </div>
        <div class="layui-form-item">
            <input type="password"
                   name="password"
                   required lay-verify="required"
                   placeholder="Input password"
                   autocomplete="off"
                   class="div-form-input">
        </div>
{{--        <div class="layui-form-item" style="display: flex;align-items: flex-end">--}}
{{--            <input type="text"--}}
{{--                   name="captcha"--}}
{{--                   required lay-verify="required"--}}
{{--                   placeholder="Captcha"--}}
{{--                   autocomplete="off"--}}
{{--                   class="div-form-input verity">--}}
{{--            <img class="login-captcha"--}}
{{--                 src="{{captcha_src()}}"--}}
{{--                 onclick="this.src='/captcha/default?'+Math.random()"--}}
{{--                 alt="captcha">--}}
{{--        </div>--}}
        <div class="form-div layui-form-item">
            <button class="layui-btn login-btn" id="loginButton" lay-submit lay-filter="formDemo">Login</button>
        </div><br/><br/><br/><br/><br/><br/>
        <div class="layui-inline eat_gray">
            @all rights reserved
        </div>
    </form>
</div>
<script type="text/javascript" src="/layui/layui.js"></script>
<script>
    $ = layui.$;
    function set_elements(){
        h = $(window).height();
        w = $(window).width();
        $('#banner').height(h);
        $('#banner').width(h);
        content_height = $('#content').height();
        content_width = $('#content').width();
        $('#content').css("top",0);
        $('#content').css("padding-left",10);
        $('#content').css("padding-right",10);
        if(h + content_width + (10+10) < w){
            $('#content').css("left",(w - h - content_width - (10+10)) / 2 + h);
        }else{
            $('#content').css("left",w - content_width - (10+10));
        }
        if(h > content_height){
            $('#content').css("padding-bottom",(h - content_height) / 2);
            $('#content').css("padding-top",(h - content_height) / 2);
        }else{
            $('#content').css("padding-bottom",0);
            $('#content').css("padding-top",0);
        }
    }
    set_elements();
    $(window).resize(set_elements);
    layui.$('.layui-form-item input').focus(function () {
        layui.$(this).css("border-color","#E60019");
    });
    layui.$('.layui-form-item input').blur(function () {
        layui.$(this).css("border-color","#DDDDDD");
    });
    layui.$('#loginButton').click(function () {
        var data = {
                'business_id': layui.$("[name='business_id']").val(),
                'username': layui.$("[name='username']").val(),
                'password': layui.$("[name='password']").val(),
                'captcha': layui.$("[name='captcha']").val(),
                '_token': '{{csrf_token()}}'
            },
            url = "{{ URL('auth/login') }}";
        layui.$.ajax({
            url: url,
            type: 'POST',
            data: data,
            beforeSend: function () {
                this.layerIndex = layer.load(0, {shade: [0.5, '#393D49']});
            },
            success:function (data){
                if(data.code == -1){
                    layer.msg(data.msg,{
                        icon: 5,
                        time: 1000,
                    });//失败的表情
                    layer.close(this.layerIndex);
                    layui.$('.login-captcha').click();
                }else{
                    layer.msg(data.msg, {
                        icon: 6,//成功的表情
                        time: 1000 //1秒关闭（如果不配置，默认是3秒）
                    }, function(){
                        window.location.href ='{{ URL('index/index') }}';
                    });
                }
            },complete: function () {
                layer.close(this.layerIndex);
            },
        });
    });
    // });
    // layui.use(['form', 'layedit', 'laydate'], function () {
    //     var form = layui.form
    //         , layer = layui.layer
    //         , layedit = layui.layedit
    //
    //     //创建一个编辑器
    //     var editIndex = layedit.build('LAY_demo_editor');
    //
    //     //自定义验证规则
    //     form.verify({
    //         username: function (value) {
    //             if (value.length < 4) {
    //                 return '标题至少得5个字符啊';
    //             }
    //         }
    //         , password: [
    //             /^[\S]{6,12}$/
    //             , '密码必须6到12位，且不能出现空格'
    //         ]
    //         , content: function (value) {
    //             layedit.sync(editIndex);
    //         }
    //     });
    //
    //     // //监听指定开关
    //     // form.on('switch(switchTest)', function (data) {
    //     //     layer.msg('开关checked：' + (this.checked ? 'true' : 'false'), {
    //     //         offset: '6px'
    //     //     });
    //     //     layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
    //     // });
    //
    //     // //监听提交
    //     // form.on('submit(demo1)', function (data) {
    //     //     layer.alert(JSON.stringify(data.field), {
    //     //         title: '最终的提交信息'
    //     //     })
    //     //     return false;
    //     // });
    //
    //     //表单初始赋值
    //     /* form.val('example', {
    //        "username": "贤心" // "name": "value"
    //        ,"password": "123456"
    //        ,"interest": 1
    //        ,"like[write]": true //复选框选中状态
    //        ,"close": true //开关状态
    //        ,"sex": "女"
    //        ,"desc": "我爱 layui"
    //      })*/
    //
    //
    // });
</script>
</body>
</html>
