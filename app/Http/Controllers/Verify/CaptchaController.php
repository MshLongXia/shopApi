<?php

namespace App\Http\Controllers\Verify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CaptchaController extends Controller
{
    //
    public function captcha(Request $request)
    {
        if ($request->method() == 'GET'){
            return view('Verify/Captcha');
        }else{
            $data['captcha'] = $request->get('data')['captcha'];
            //定义规则
            $rules = [
                'captcha' => 'required|captcha',  //注意这里验证码的验证在这里，不用写逻辑
            ];
            //提示信息
            $message = [
                'captcha.required' => '验证码不能为空',
                'captcha.captcha'=>'验证码错误,请重新输入',
            ];
            //进行验证
            $validator = Validator::make($data,$rules,$message);
            if($validator->fails()){
                return $this->jsonError($validator->errors()->first());
            }
            return $this->jsonSuccess([],'captcha correct');
        }
    }
}
