<?php

namespace App\Http\Controllers\UserCenter;

use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenderController extends Controller
{
    //
    public function index(Request $request){
        $user_id = $this->getUser()->id;
        $gender = $request->input('gender');
        $user = new UserModel();

        $user ->id = $user_id;
        $user->sex = $gender;
        $user->reated_at = time();
        $user->save();
        $data = [];
        $data ['gender'] = $gender;
        //响应请求
        return $this->success($data);
    }
}
