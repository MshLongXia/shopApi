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
<div style="height: 10%;width: 100%;"></div>
<div style="padding: 0 2%;background: #ffffff;height: 100%; display: flex;justify-content: center;align-items: center">
    <form class="layui-form" action="" onsubmit="return false;" lay-filter="form" style="padding: 12px 0">
        <div class="layui-form-item">
            <label class="layui-form-label" style="width: 100px">请输入验证码</label>
            <div class="layui-input-block">
                <input type="text" name="captcha" required  lay-verify="required" placeholder="请输入验证码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width: 100px">验证码</label>
            <img src="{{captcha_src()}}"  onclick="this.src='/captcha/default?'+Math.random()">
        </div>
        <div class="layui-form-item" style="text-align: center;">
            <button class="layui-btn layui-btn-lg btn-div" style="margin-top: 15px" lay-submit lay-filter="formDemo"
                    id="submit">Submit
            </button>
        </div>
    </form>
</div>
</body>

<script type="text/javascript" src="{{asset('layui/layui.js')}}"></script>
<script>
    layui.use(['form', 'layer'], function (){
        let form =layui.form
        form.on('submit(formDemo)',function (data){
            data = {
                'data': data.field,
                '_token': '{{csrf_token()}}'
            }
            url = "{{URL('verify/captcha')}}";
            layui.$.ajax({
                url: url,
                type: 'POST',
                data: data,
                beforeSend: function () {
                    this.layerIndex = layer.load(0, {shade: [0.5, '#393D49']});
                },
                success(res) {
                    if (res.code == 0) {
                        layer.msg(res.msg, {
                            icon: 6,
                            time: 1000,

                        }, function () {
                            parent.layer.closeAll();
                            window.location.reload();
                        });
                    } else {
                        layer.msg(res.msg, {
                            icon: 5,
                            time: 1000,
                        });//失败的表情
                        layer.close(this.layerIndex);
                    }
                }
            });
        });
        return false;
    })
</script>
</html>
