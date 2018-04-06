<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;



class PictureController extends Controller
{
    //
    public function index(){

        return view('media.picture');
        //dd(456655556585);
    }
    public function uploadImg(Request $request){
        $user = $this->getUser();

        $id = $user->id;

        if ($request->isMethod('post')){
            $file = $request->file('myPicture');
            if ($file){
                $extension = $file->extension();//获取上传图片的后缀名
                //dd($extension);
                //$type = $file->getClientMimeType();//获取文件类型
                //$originName = $file->getClientOriginalName();//获取文件原文件名
                $newImgName = date('Y-m-d-h-is').'-'.uniqid().'.'.$extension;//拼接新的文件名

                $realPath = $file->getRealPath();

               /* $file ->move(base_path().'/public/storage/uploads',$newImgName);
                $idCardFront = '/upload/file/'.$newImgName;*/
               $bool = Storage::disk('uploads')->put($newImgName,file_get_contents($realPath));
               $path = 'uploads/img/'.$newImgName;
                dd(1,$bool,$path);

                //$url = Storage::url($newImgName);//获取图片的远程地址
                //$size = Storage::size($newImgName)/1024;//获取图片资源的大小
                //$created_at = time();
                if ($bool){
                    //dd($realPath);

                }

                return json_encode($path);
            }
            //dd($file);

        }else{
            $idCardFrontImg = '未上传图片';
            return json_encode($idCardFrontImg);
        }
        //dd(222);

    }
}
