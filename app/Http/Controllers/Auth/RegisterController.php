<?php

namespace App\Http\Controllers\Auth;

use App\Components\Request\Status;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255',
            'mobile' => 'required|string|mobile|max:255|unique:user',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //dd($data);
        return User::create([
            'username' => isset($data['username'])?$data['username']:'',
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);

    }

    /**
     * 注册
     * @param Request $request
     * @return string
     */
    public function register(Request $request)
    {
        //获取手机号
        $mobile = $request->input('mobile');

        //验证手机号参数
        if (!$request->has('mobile')){
            return $this->fail(Status::MOBILE_HAS_MUST);
        }
        //验证密码参数
        if (!$request->has('password')){
            return $this->fail(Status::PASSWORD_HAS_MUST);
        }

        //判断手机号是否注册
        $user = User::where('mobile',$mobile)->first();//通过条件或来筛选
        if (!is_null($user)){
            //响应请求 - 手机号已注册
            return $this->fail(Status::MOBILE_HAS_REGISTERED);
        }

        $user = $this->create($request->all());
        if($user){
            // 生成token
            $token=JWTAuth::fromuser($user);
            // 响应的数据
            $data = [];
            $data ['token'] = $token;
            return $this->success($data);
        }
        else{
            //响应失败请求
            return $this->fail(Status::REGISTER_FAIL);
        }
    }
}
