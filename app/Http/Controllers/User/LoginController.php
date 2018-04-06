<?php

namespace App\Http\Controllers\User;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    //
    public function index(){
        //dd(22222);
        return view('login');
    }
    public function login(Request $request){
        $username = $request->input('username');
        $u_passwd = $request->input('password');
        //dd($passwd);
        $users = new UserModel();
        $user = $users->username;
        $passwd = $users->password;
        $con = DB::table('user')->select('username',$username)->first();
        //dd($con);
        if (!empty($con)){
            return response('登录成功');
        }else{
            return response('登录失败');
        }


            dd($request->all());
    }
}
