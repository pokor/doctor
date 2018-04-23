<?php

namespace App\Http\Controllers\UserCenter;

use App\Components\Request\Status;
use App\Models\AvaterModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    //
    public function index(Request $request){
       /* $user = $this->getUser();//获取用户

        $user_id = $user->id;//*/

        if ($request->isMethod('post')){
            $base64 =  preg_replace("/\s/",'',$request->input('myAvatar'));
            $img = base64_decode($base64);
            $newImgName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.'jpeg';//拼接新的文件名
            $bool = Storage::disk('uploads')->put($newImgName,$img);
            if ($bool){
                $path = 'uploads/img/'.$newImgName;
                $pic = new AvaterModel();
                $pic->avatar_path = $path;//存储文件的路径
                //$pic ->user_id = $user_id;//获取用户ID
                $pic->save();//存入数据库
                $avatar = $this->fullPath($path);
                $info = [];
                $info['avatar'] = $avatar;
                $data = [
                    'error' =>0,
                    'status' => $this->success(Status::REQUEST_SUCCESS),
                    'info' => $info

                ];
                return response($this->success($data));
            }else{
                return response(json_encode([
                    'token' => '',
                    'code' => '501',
                    'message' => '保存失败，请重新上传'
                ]));
            }


        }else{
            $idCardFrontImg = '未上传图片';
            return json_encode($idCardFrontImg);
        }

    }

}
