<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $rules = [
        'username' => 'required|max:50',
        'password' => 'required',
        'captcha'  => 'required|captcha',
    ];
    protected $returnErrorMsg = [
        'username.required' => '请输入用户名',
        'username.max' => '您输入的用户名不符合规范',
        'password.required' => '请输入密码',
        'captcha.required' =>  '请输入验证码',
        'captcha.captcha' =>   '验证码错误',
    ];

    public function login(Request $request,User $user)
    {
        if (!$request->isMethod('post')){
            if(!empty(session('userInfo'))){
                return redirect('index/index');
            }
            return view('Login');
        }else{
            $validator = Validator::make($request->all(),$this->rules,$this->returnErrorMsg);
            if($validator->fails()){
                return $this->jsonError($validator->errors()->first());
            }
            $param = $validator->validated();
            $findRes = $user->where('username',$param['username'])->first();
            if(empty($findRes)){
                return $this->jsonError('未找到该用户');
            }
            if($param['password'] != ($findRes->password)){
                return $this->jsonError('密码错误');

            }
            session_start();
            session(['userInfo'=>$findRes->toArray()]);
            write_manage_log('登录','登录','用户:'.session('userInfo')['username'].'登录');
            return $this->jsonSuccess([],'login success');
        }
    }
    public function loginOut()
    {
        write_manage_log('登出','登出','用户:'.session('userInfo')['username'].'退出登录');
        session()->flash('userInfo');
        return redirect('auth/login');
    }
    public function ChangPwd(Request $request)
    {
        $param = $request->post('data');
        if($param['new_pwd'] == $param['old_pwd']){
            return $this->jsonError('新旧密码一致');
        }
        $user = User::firstWhere(['id'=> session('userInfo')['id']]);
        if($param['old_pwd'] != $user->password){
            return $this->jsonError('旧密码错误');
        }
        if($param['new_pwd'] != $param['re_pwd']){
            return $this->jsonError('确认密码错误');
        }
        try {
            $user->password = $param['new_pwd'];
            $user->save();
            write_manage_log('登录','修改密码',session('userInfo')['username'].'修改密码');
        }catch (\Exception $exception){
            return $this->jsonError();
        }
        return $this->jsonSuccess();
    }
}
