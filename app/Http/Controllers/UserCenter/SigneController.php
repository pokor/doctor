<?php

namespace App\Http\Controllers\UserCenter;

use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SigneController extends Controller
{
    //
    public function index(Request $request){
        $user_id = $this->getUser()->id;
        $signature = $request->input('signature');
        $user = new UserModel();

        $user ->id = $user_id;
        $user->signe = $signature;
        $user->save();
        $data = [];
        $data ['signature'] = $signature;
        //响应请求
        return $this->success($data);
    }
}
