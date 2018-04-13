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
    public function index(){

        return view('media.picture');
        //dd(456655556585);
    }
    public function uploadImg(Request $request){
        //$user = $this->getUser();
        //dd($user);

        //$user_id = $user->id;
        //var_dump($request->file('myPicture'));

        //return response($request->all());
        if ($request->isMethod('post')){
            $file = $request->file('myPicture');
            $allowed_extensions = ["png", "jpg", "gif","jpeg"];

            $extension = $file->getClientOriginalExtension();//获取上传图片的后缀名
            if (!in_array(strtolower($extension),$allowed_extensions)){//判断图片上传格式是否正确
                return $this->fail(Status::PICTURE_FORMAT);
            }

                $newImgName = date('Y-m-d-h-is').'-'.uniqid().'.'.$extension;//拼接新的文件名

                $realPath = $file->getRealPath();
               $bool = Storage::disk('uploads')->put($newImgName,file_get_contents($realPath));
               if ($bool){
                   $path = 'uploads/img/'.$newImgName;
                   $pic = new PictureModel();
                   //dd(time());
                   $pic->pic_path = $path;//存储文件的路径
                   $pic->created_at = time();//保存图片的存入时间戳
                   $pic->save();//存入数据库
                   $info = [];
                   $info['url'] = env('APP_URL').'/'.$path;
                   $data =[];
                   $data['info'] = $info;
                   return $this->success($data);
               }else{
                   return $this->fail(Status::REQUEST_FAIL);
               }

        }else{
            return $this->fail(Status::REQUEST_FAIL);
        }
    }
    public function pictureList(Request $request){
        //dd($request->all());
       /* $user = $this->getUser();//获取到用户的token

        $user_id = $user->id;//解析用户token获取到用户的id*/

        $pic = DB::table('user_pic')->where('user_id',$request->input('id'))->orderby('id','asc')->get();
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
        $pic_id = $request->input('id');

        $res = json_decode($pic_id,true);

        //var_dump($res);

        //dd('');


        $date[] = '';
        foreach ($res as $item){
            $pictureID = [];
            $pictureID['id'] = $item;
            echo($item);
        };

        $pic_deleted = DB::table('user_pic')->where('user_id',$request->input('user_id'))->orderby('id',$pic_id)->delete();

    }
}
