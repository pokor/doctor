<?php

namespace App\Http\Controllers\Auth;

use App\Components\Request\Status;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        //获取请求的参数
        $mobile = $request->input('mobile');
        $password = $request->input('password');

        //dd($request->all());

        //通过手机号查询用户
        $user = User::where('mobile',$mobile)->first();//通过条件或来筛选

        if(is_null($user)){
            //响应请求 - 手机号不通过
            return $this->fail(Status::LOGIN_MOBILE_UNREGISTERED);
        }

        // 判断密码是否正确
        if (Hash::check($password, $user->password)) {
            //生成请求 token
            $token = JWTAuth::fromuser($user);
            // 响应的数据
            $data = [];
            $data ['token'] = $token;
            //响应请求
            return $this->success($data);

        } else {
            //响应请求 - 密码验证不通过
            return $this->fail(Status::LOGIN_FAIL);
        }
    }

}
