<?php

namespace App\Http\Controllers\Auth;

use App\Components\Request\Status;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
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
        $mobile = $request->input('mobile');//获取APP端请求的手机号
        $password = $request->input('password');//获取用户的密码
        
        //通过手机号查询用户
        $user = User::where('mobile',$mobile)->first();//通过条件或来筛选
        //dd($user);
        if(is_null($user)){
            //响应请求 - 手机号不通过
            return $this->fail(Status::LOGIN_MOBILE_UNREGISTERED);
        }

        // 判断密码是否正确
        if (Hash::check($password, $user->password)) {
            //生成请求 token
            $token = JWTAuth::fromuser($user);
            $user_status = $user->user_status;
            $signature = $user->signature;
            $created_at = $user->created_at;
            $nickname = $user->nickname;
            $user_id = $user->id;

            $user_avatar = DB::table('user_avatar')->where('user_id',$user_id)->first();
            if (is_null($user_avatar)){

            }
            //dd($user_id);
            $avatar_path =$user_avatar->avatar_path;
            $uaer_avatar_img =$this->fullPath($avatar_path);
            // 响应的数据
            $info = [];//声明用户信息
            $data = [];//
            $data ['token'] = $token;//返回用户的toke
            $info ['user_id'] = $user_id;
            $info ['mobile'] = $mobile;//返回用户的手机
            $info ['signature'] = isset($signature)?$signature:'';//返回用户的签名
            $info ['user_status'] = isset($user_status)?$user_status:'';//返回用户的注册时间
            $info ['nickname'] = isset($nickname)?$nickname:'';//返回用户的昵称*/
            $info ['avatar_img'] = $uaer_avatar_img;//返回用户的昵称
            $info ['created_at'] =date('Y-m-d H:i:s',strtotime($created_at)  );//返回用户的注册时间
            $data['info'] = $info;
            //响应请求
            return $this->success($data);

        } else {
            //响应请求 - 密码验证不通过
            return $this->fail(Status::LOGIN_FAIL);
        }
    }

}
