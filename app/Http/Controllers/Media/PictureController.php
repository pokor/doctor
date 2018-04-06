<?php

namespace App\Http\Controllers\Media;

use App\Models\PictureModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Components\Request\Status;



class PictureController extends Controller
{
    //
    public function index(){

        return view('media.picture');
        //dd(456655556585);
    }
    public function uploadImg(Request $request){
        $user = $this->getUser();
        //dd($user);

        $user_id = $user->id;

        if ($request->isMethod('post')){
            $file = $request->file('myPicture');
            $allowed_extensions = ["png", "jpg", "gif","jepg"];

            $extension = $file->getClientOriginalExtension();//获取上传图片的后缀名
            if (!in_array(strtolower($extension),$allowed_extensions)){//判断图片上传格式是否正确
                return $this->fail(Status::PICTURE_FORMAT);
            }

                //dd($extension);
                //$type = $file->getClientMimeType();//获取文件类型
                //$originName = $file->getClientOriginalName();//获取文件原文件名
                $newImgName = date('Y-m-d-h-is').'-'.uniqid().'.'.$extension;//拼接新的文件名

                $realPath = $file->getRealPath();

               /* $file ->move(base_path().'/public/storage/uploads',$newImgName);
                $idCardFront = '/upload/file/'.$newImgName;*/
               $bool = Storage::disk('uploads')->put($newImgName,file_get_contents($realPath));
               if ($bool){
                   $path = 'uploads/img/'.$newImgName;
                   //var_dump(1,$bool,$path);die();
                   $pic = new PictureModel();
                   //dd(time());
                   $pic->pic_path = $realPath;//存储文件的路径
                   $pic->pic_suffix = $extension;//保存图片的后缀
                   $pic->created_at = time();//保存图片的存入时间戳
                   $pic ->user_id = $user_id;//获取用户ID
                   $pic->save();//存入数据库
                   return json_encode($path);
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
