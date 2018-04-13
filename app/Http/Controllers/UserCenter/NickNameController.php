<?php

namespace App\Http\Controllers\UserCenter;

use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NickNameController extends Controller
{

    public function index(Request $request){
        $user_id = $this->getUser()->id;
        $nickname = $request->input('nickName');
        $user = new UserModel();

        $user ->id = $user_id;
        $user->nickname = $nickname;
        $user->save();
        $data = [];
        $data ['nickName'] = $nickname;
        //响应请求
        return $this->success($data);
    }

}
