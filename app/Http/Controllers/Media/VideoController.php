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
    public function uploadVideo(Request $request){

        if ($request->isMethod('post')){
           /* $user_id = $this->getUser()->id;*/
            $file = $request->file('myVideo');
            //dd($file);
            $allowed_extensions = ["mp4", "avi", "rmvb","mkv","mov","flv","3gp","m4v","mpeg"];
            $extension = $file->getClientOriginalExtension();//获取上传图片的后缀名
            if (!in_array(strtolower($extension),$allowed_extensions)){//判断图片上传格式是否正确
                return $this->fail(Status::VIDEO_FORMAT);//上传失败返回状态码
            }
            if ($file){
                $newImgName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$extension;//拼接新的文件名
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
                   $info['imgUrl'] = $this->fullPath($path);
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
    public function base64_picture(Request $request){
        $base64 =  preg_replace("/\s/",'',$request->input('myVideo'));
        $img = base64_decode($base64);
        //return $img;
        $newImgName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.'mp4';
        /*return($newImgName);*/
        $bool = Storage::disk('uploads')->put($newImgName,$img);
        if ($bool){
            $path = 'uploads/img/'.$newImgName;
            $pic = new VideoModel();
            $pic->video_path = $path;//存储文件的路径
            $pic->created_at = date('Y-m-d-H-i-s');//保存图片的存入时间戳
            $pic->save();//存入数据库
            $info = [];
            $info['videoUrl'] = $this->fullPath($path);
            $data =[];
            $data['info'] = $info;
            $data['status'] = Status::PICTURE_SUCCESS;
            return $this->success($data);
        }
        return $this->success(Status::PICTURE_FAIL);


    }
    public function videoList(Request $request){
        $user = $this->getUser();//获取到用户的token

        //$user_id = $user->id;//解析用户token获取到用户的id
        $user_id = $request->input('user_id');

        $video = DB::table('user_video')->where('user_id',$user_id)->orderby('id','asc')->get();//获取当前用户的所有视频

        $data = [];

        foreach ($video as $item){//遍历查询的结果

            $videoData = [];
            $videoData['id'] = $item->id;
            $videoData['url'] = $this->fullPath($item->video_path);//返回视频内容
            $videoData['user_id'] = $item->user_id;
            $data[] =$videoData;
        }
        return $this->success($data);
    }
    public function pictureDelete(Request $request){
        /*  $user = $this->getUser();
          $user_id = $user->id;*/
        $video_id = $request->input('video_id');

        $user_id = $request->input('user_id');



        $videoDelete = DB::table('user_video')->where('user_id',$user_id)->get();
        //dd($user);
        $res = json_decode($video_id,true);

        if (!empty($videoDelete)){

            $date[] = '';
            //$request = DB::table('user_pic')->truncate();
            $videoID = [];
            foreach ($res as $item){
                $videoID[] = $item;
            };
            //dd($pictureID);
            $request = DB::table('video_id')->where('user_id',$user_id)->whereIn('id',$videoID)->delete();
            if (!is_null($request)){
                return $this->success();
            }
        }
        return $this->success(Status::REQUEST_FAIL);

    }
}
