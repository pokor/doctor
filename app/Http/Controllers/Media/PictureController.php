<?php

namespace App\Http\Controllers\Media;

use App\Models\PictureModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Components\Request\Status;




class PictureController extends Controller
{
    //
    public function uploadImg(Request $request){
        //$user = $this->getUser();
        //$user_id = $user->id;

        //dd($request);

        if ($request->isMethod('post')){
            $img = $request->file('myPicture');
            $user_id = $request->input('user_id');
            //$file = $request->file('myPicture');

            $allowed_extensions = ["png", "jpg", "gif","jpeg"];

            $extension = $img->getClientOriginalExtension();//获取上传图片的后缀名
            //return '111555555555';
            if (!in_array(strtolower($extension),$allowed_extensions)){//判断图片上传格式是否正确
                return $this->fail(Status::PICTURE_FORMAT);
            }

                $newImgName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$extension;//拼接新的文件名

                $realPath = $img->getRealPath();
               $bool = Storage::disk('uploads')->put($newImgName,file_get_contents($realPath));
               if ($bool){
                   $path = 'uploads/img/'.$newImgName;
                   $pic = new PictureModel();
                   //dd(time());
                   $pic->pic_path = $path;//存储文件的路径
                   $pic->updated_at = time();//保存图片的存入时间戳
                   $pic->user_id = $user_id;//保存图片的存入时间戳
                   $pic->save();//存入数据库
                   $info = [];
                   $info['imgUrl'] = $this->fullPath($path);
                   $data =[];
                   $data['info'] = $info;
                   return $this->success($data);
               }else{
                   return $this->fail(Status::VIDEO_FORMAT);
               }

        }else{
            return $this->fail(Status::VIDEO_FORMAT);
        }
    }
    public function pictureList(Request $request){
        //dd($request->all());
       /* $user = $this->getUser();//获取到用户的token

        $user_id = $user->id;//解析用户token获取到用户的id*/


        $pic = DB::table('user_pic')->where('user_id',$request->input('user_id'))->orderby('id','asc')->get();
        //dd($pic);
        $data=[];

        foreach ($pic as $items){
                $pictureData =[];
                $pictureData['id'] = $items->id;
                $pictureData['url'] = $this->fullPath($items->pic_path);
                $pictureData['user_id'] =$items->user_id;
                $pictureData['created_at'] =$items->created_at;
                $data[]=$pictureData;
        }
        return $this->success($data);

    }

    public function pictureDelete(Request $request){
          /*  $user = $this->getUser();
            $user_id = $user->id;*/
        $pic_id = $request->input('pic_id');

        $user_id = $request->input('user_id');



        $picDelete = DB::table('user_pic')->where('user_id',$user_id)->get();
        //dd($user);
        $res = json_decode($pic_id,true);

        if (!empty($picDelete)){

            $date[] = '';
            //$request = DB::table('user_pic')->truncate();
            $pictureID = [];
            foreach ($res as $item){
                $pictureID[] = $item;
            };
            //dd($pictureID);
            $request = DB::table('user_pic')->where('user_id',$user_id)->whereIn('id',$pictureID)->delete();
            if (!is_null($request)){
                return $this->success();
            }
        }
        return $this->success(Status::REQUEST_FAIL);

    }
    public function base64_picture(Request $request){
        /*  $user = $this->getUser();
           $user_id = $user->id;*/
        $base64 =  preg_replace("/\s/",'',$request->input('myPicture'));
        $img = base64_decode($base64);
        //return $img;
        $newImgName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.'jpg';

        $bool = Storage::disk('uploads')->put($newImgName,$img);
        if ($bool){
            $path = 'uploads/img/'.$newImgName;
            $pic = new PictureModel();
            $pic->pic_path = $path;//存储文件的路径
            $pic->created_at = date('Y-m-d-H-i-s');//保存图片的存入时间
            $pic->save();//存入数据库
            $info = [];
            $info['imgUrl'] = $this->fullPath($path);
            $data =[];
            $data['info'] = $info;
            $data['status'] = Status::PICTURE_SUCCESS;
            return $this->success($data);
        }
        return $this->success(Status::PICTURE_FAIL);

    }
}
