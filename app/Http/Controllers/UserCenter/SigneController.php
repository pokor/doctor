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
        $signe = $request->input('signe');
        $user = new UserModel();

        $user ->id = $user_id;
        $user->signe = $signe;
        $user->save();
        $data = [];
        $data ['signe'] = $signe;
        //响应请求
        return $this->success($data);
    }
}
