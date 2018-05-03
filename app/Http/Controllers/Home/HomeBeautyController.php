<?php

namespace App\Http\Controllers\Home;

use App\Components\Request\Status;
use App\Models\BeautyModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeBeautyController extends Controller
{
    //
    public function beautyPicUpload(Request $request){//美容日记上传图片
        /* $user = $this->getUser();//获取到用户的token
        $user_id = $user->id;//解析用户token获取到用户的id*/

        $user_id = $request->input('user_id');
        $img =  $request->file('myBeautyImg');
        $variety = $request->input('variety');
        $allowed_extensions = ["png", "jpg", "gif","jpeg"];
        $extension = $img->getClientOriginalExtension();//获取上传图片的后缀名
        if (!in_array(strtolower($extension),$allowed_extensions)){//判断图片上传格式是否正确
            return $this->fail(Status::PICTURE_FORMAT);
        }
        $newImgName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.'jpeg';
        $realPath = $img->getRealPath();

        $bool = Storage::disk('uploads')->put($newImgName,file_get_contents($realPath));
        if ($bool){
            $path = 'uploads/img/'.$newImgName;
            $beautyImg = new BeautyModel();
            $beautyImg->variety = $variety;
            $beautyImg->diary_pic_path = $path;
            $beautyImg->created_at = date('Y-m-d-H-i-s');//保存图片的存入时间戳;
            $beautyImg->user_id = $user_id ;
            $beautyImg ->save();
            $info = [];
            $info['BeautyImgUrl'] = $this->fullPath($path);
            $data =[];
            $data['info'] = $info;
            $data['status'] = Status::PICTURE_SUCCESS;
            return $this->success($data);
        }

    }
    public function beautyImgList(Request $request){//美容日记列表展示操作
        /*  $user = $this->getUser();
           $user_id = $user->id;*/
        $user_id = $request->input('user_id');
        $date  = $request->input('beautyDate');
        $beautyPic = DB::table('user_diary')->where('user_id',$user_id)->select('created_at',$date)->get();
        $data = [];
        foreach ($beautyPic as $items){
            $beautyImg =[];
            $beautyImg['id'] = $items->id;
            $beautyImg['url'] = $this->fullPath($items->diary_pic_path);
            $beautyImg['user_id'] =$items->user_id;
            $beautyImg['variety'] =$items->variety;//
            $beautyImg['created_at'] =$items->created_at;
            $data[]=$beautyImg;
        }
        return $this->success($data);
    }
}
