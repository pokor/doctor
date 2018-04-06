<?php

namespace App\Http\Controllers\Auth;

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
         $paswd = $request->input('password');
        //dd($paswd);
        $user=User::where('mobile',$request->mobile)->orwhere('mobile',$request->mobile)->firstOrFail();//通过条件或来筛选
        $user=User::where('mobile',$request->mobile)->firstOrFail();//通过条件或来筛选
        //$credentials = $request->only('mobile','password');
        if($user && Hash::check($paswd,$user->password)){
        /*var_dump(bcrypt($user->password),bcrypt($paswd));

        exit;*/
         $token=JWTAuth::fromuser($user);    //获取token

        return response([
            'token'=>$token,
            'message'=>"Login Success",
            'status_code'=>200
        ]);
        } else{
            return response([
                'token'=>'',
                'message'=>"Login fail",
                'status_code'=>500
            ]);
        }
       /* $credentials = $request->only('mobile','password');
       // dd($credentials);
        if (!$token = JWTAuth::attempt($credentials)){
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ],400);
        }
        return response(['status'=>'success'])->headers('Authorization', $token);*/

    }
    
}
