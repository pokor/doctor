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
        $user = $this->getUser();//获取用户
        //dd($user);
        $user_id = $user->id;//

        if ($request->isMethod('post')){
            $file = $request->file('avatarPicture');
            $allowed_extensions = ["png", "jpg", "gif","jepg"];

            $extension = $file->getClientOriginalExtension();//获取上传图片的后缀名
            if (!in_array(strtolower($extension),$allowed_extensions)){//判断图片上传格式是否正确
                return $this->fail(Status::PICTURE_FORMAT);
            }
            //$type = $file->getClientMimeType();//获取文件类型
            //$originName = $file->getClientOriginalName();//获取文件原文件名
            $newImgName = date('Y-m-d-h-is').'-'.uniqid().'.'.$extension;//拼接新的文件名

            $realPath = $file->getRealPath();

            $bool = Storage::disk('uploads')->put($newImgName,file_get_contents($realPath));
            if ($bool){
                $path = 'uploads/img/'.$newImgName;
                $pic = new AvaterModel();
                //dd(time());
                $pic->avatar_path = $path;//存储文件的路径
                $pic->avatar_suffix = $extension;//保存图片的后缀
                $pic->created_at = time();//保存图片的存入时间戳
                $pic ->user_id = $user_id;//获取用户ID
                $pic->save();//存入数据库
                $data = [
                    'error' =>0,
                    'status' => $this->success(Status::REQUEST_SUCCESS)
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
