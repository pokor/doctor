<?php

namespace App\Http\Controllers\UserCenter;

use App\Components\Request\Status;
use App\Models\UserCenterModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedController extends Controller
{
    public function index(Request $request){
        $user = $this->getUser();
        $user_id = $user->id;
        $conten = $request->input('content');

        if (isset($conten)){//判断用户输入的是否为空
            $feedBack  = new UserCenterModel();//实例化意见反馈表的模型
            $feedBack->user_id = $user_id;//
            $feedBack->conten = $conten;//
            $feedBack->create_at = time();//获取当前时间戳
            $feedBack->save();


            return $this->success(Status::REQUEST_SUCCESS);//意见反馈成功
        }else{
            return $this->fail(Status::REQUEST_FAIL);//意见反馈失败
        }




    }
}
