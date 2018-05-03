<?php

namespace App\Http\Controllers\Auth;

use App\Components\Request\Status;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Qcloud\Sms\SmsSingleSender;

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
    public function sendMsg(Request $request){
        $mobile = 18652497020;
        // 短信应用SDK AppID
        // 短信应用SDK AppKey
        $appkey = config('sms.msgKey');
        //dd($appkey);


        $appid = config('sms.appID');// 1400开头
        //dd($appid);

        // 需要发送短信的手机号码
        //$phoneNumbers = [$mobile];

        // 短信模板ID，需要在短信应用中申请
        $templateId = config('sms.msgTemplate.content_id'); // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        //dd($templateId);
        $smsSign = "握富信息咨询有限公司"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        $ssender = new SmsSingleSender($appid,$appkey);
        $parms = ['123456'];
        $result = $ssender->sendWithParam("86",$mobile,$templateId,$parms,$smsSign);
        $rsp = json_decode($result);
        print_r($rsp);
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
        $password = $request->input('password');
        //dd($password);
        

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
        //dd($user);
        if($user){
            // 生成token
            $token=JWTAuth::fromuser($user);
            // 响应的数据
            $data = [];
            $info = [];
            $info['mobile']= $mobile;//返回用户手机号
            $info['user_id']= $user->id;//返回手机号
            $info['password']= $password;
            $data ['token'] = $token;
            $data ['info'] = $info;
            return $this->success($data);
        }
        else{
            //响应失败请求
            return $this->fail(Status::REGISTER_FAIL);
        }
    }
}
