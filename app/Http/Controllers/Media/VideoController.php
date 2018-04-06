<?php

namespace App\Http\Controllers\Media;

use App\Models\VideoModel;
use App\Models\videotureModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Components\Request\Status;
class VideoController extends Controller
{
    //
    public function index(){
        return view('media.video');
    }
    public function uploadVideo(Request $request){

        if ($request->isMethod('post')){
            $file = $request->file('myVideo');
            $allowed_extensions = ["mp4", "avi", "rmvb","mkv","mov","flv","3gp","m4v","mpeg"];
            $extension = $file->getClientOriginalExtension();//获取上传图片的后缀名
            if (!in_array(strtolower($extension),$allowed_extensions)){//判断图片上传格式是否正确
                return $this->fail(Status::VIDEO_FORMAT);//上传失败返回状态码
            }
            if ($file){
                //$type = $file->getClientMimeType();//获取文件类型
                //$originName = $file->getClientOriginalName();//获取文件原文件名
                $newImgName = date('Y-m-d-h-i-s').'-'.uniqid().'.'.$extension;//拼接新的文件名

                $realPath = $file->getRealPath();//获取到路径

                /* $file ->move(base_path().'/public/storage/uploads',$newImgName);
                 $idCardFront = '/upload/file/'.$newImgName;*/
                $bool = Storage::disk('uploads')->put($newImgName,file_get_contents($realPath));
                $path = 'uploads/img/'.$newImgName;
                //var_dump(1,$bool,$path);die();
               if ($bool){
                   $video = new VideoModel();
                   //dd(time());
                   $video->video_path = $realPath;//存储文件的路径
                   $video->video_suffix = $extension;//保存图片的后缀
                   $video->created_at = time();//保存图片的存入时间戳
                   $video ->user_id = '';
                   $video->save();
                   return json_encode($path);
               }
            }
            //dd($file);

        }else{
            $idCardFrontImg = '未上传图片';
            return json_encode($idCardFrontImg);
        }
    }
}
