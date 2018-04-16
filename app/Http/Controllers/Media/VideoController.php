<?php

namespace App\Http\Controllers\Media;

use App\Models\VideoModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
           /* $user_id = $this->getUser()->id;*/
            $file = $request->file('myVideo');
            $allowed_extensions = ["mp4", "avi", "rmvb","mkv","mov","flv","3gp","m4v","mpeg"];
            $extension = $file->getClientOriginalExtension();//获取上传图片的后缀名
            if (!in_array(strtolower($extension),$allowed_extensions)){//判断图片上传格式是否正确
                return $this->fail(Status::VIDEO_FORMAT);//上传失败返回状态码
            }
            if ($file){
                $newImgName = date('Y-m-d-h-i-s').'-'.uniqid().'.'.$extension;//拼接新的文件名
                $realPath = $file->getRealPath();//获取到路径
                $bool = Storage::disk('uploads')->put($newImgName,file_get_contents($realPath));
                $path = 'uploads/img/'.$newImgName;
               if ($bool){
                   $video = new VideoModel();
                   $video->video_path = $path;//存储文件的路径
                  /* $video->video_suffix = $extension;//保存图片的后缀*/
                   $video->created_at = time();//保存视频的存入时间戳
                  /* $video ->user_id = $user_id;*/
                   $video->save();
                   $info = [];
                   $info['imgUrl'] = env('APP_URL').'/'.$path;
                   $data = [
                       'error' =>0,
                       'info' => $info
                   ];
                   return $this->success($data);
               }
            }
            //dd($file);

        }else{
            return response($this->fail(Status::REQUEST_FAIL));
        }
    }
   /* public function videoList(Request $request){
        $user = $this->getUser();//获取到用户的token

        $user_id = $user->id;//解析用户token获取到用户的id
        $userID = $request->input('id');

        $video = DB::table('user_video')->where('user_id',$userID)->orderby('id','asc')->get();//获取当前用户的所有视频

        $data = [];

        foreach ($video as $item){//遍历查询的结果

            $videoData = [];
            $videoData['id'] = $item->id;
            $videoData['url'] = $this->fullPath($item->video_path);//返回视频内容
            $videoData['user_id'] = $item->user_id;
            $data[] =$videoData;
        }
        return $this->success($data);
    }*/
}
