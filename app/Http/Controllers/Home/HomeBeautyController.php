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
        $base64 =  preg_replace("/\s/",'',$request->input('myBeautyImg'));
        $variety = $request->input('variety');
        $img = base64_decode($base64);
        $newImgName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.'jpg';

        $bool = Storage::disk('uploads')->put($newImgName,$img);
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
