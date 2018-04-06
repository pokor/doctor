<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class ResetController extends Controller
{
    //
    public function index(){
        return view('reset');
    }
    public function reset(Request $request){
        $oldPassword = $request->input('oldPassword');
        $password = $request->input('password');
        $data = $request->all();
        $rules = [
            'oldpassword'=>'required|between:6,20',
            'password'=>'required|between:6,20|confirmed',
        ];
        $message = [
            'required' => '密码不能为空',
            'between' => '密码必须是6~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];
        $validator = Validator::make($data,$rules,$message);
        $user = Auth::user();
        //dd($user);
        $validator->after(function($validator) use ($oldPassword, $user) {
            if (!\Hash::check($oldPassword,$user->password)){
                $validator -> errors()->add('oldPassword', '原密码错误');
            }
        });
        if ($validator->fail()){
            return back()->withErrors($validator);//返回一次性错误

        }

        $user ->password = bcrypt($password);
        $user ->save();
        dd('测试');
        Auth::logout();
        $token = JWTAuth::fromuser($user);
        return response([
            'token'=>$token,
            'message'=>"Login Success",
            'status_code'=>200
        ]);

            //dd($request->all());
    }
}
