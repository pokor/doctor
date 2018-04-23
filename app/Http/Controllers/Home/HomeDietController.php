<?php

namespace App\Http\Controllers\Home;

use App\Components\Request\Status;
use App\Models\MealUserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeDietController extends Controller
{
    public function index(Request $request){
        /*  $user = $this->getUser();
           $user_id = $user->id;*/
        $mealStyle = $request->input('mealStyle');
        $user_id = $request->input('user_id');
        $myDietPicture  = $request->input('myDietPicture');
        $base64 =  preg_replace("/\s/",'',$myDietPicture);
        $img = base64_decode($base64);
        $newImgName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.'jpg';
        $bool = Storage::disk('uploads')->put($newImgName,$img);
        if ($bool){
            $date = date('Y-m-d-H-i-s');//保存图片的存入时间戳;
            $path = 'uploads/img/'.$newImgName;
            $meal_user_pic = new MealUserModel();
            $meal_user_pic->user_id = $user_id;
            $meal_user_pic->meal_style = $mealStyle;
            $meal_user_pic->meal_pic_path = $path;
            $meal_user_pic->created_at = $date;
            $meal_user_pic->save();
            $info['mealImgUrl'] = $this->fullPath($path);
            $data =[];
            $data['info'] = $info;
            $data['status'] = Status::PICTURE_SUCCESS;
            return $this->success($data);
        }else{
            return $this->fail(Status::REQUEST_FAIL);
        }
    }
    public function mealImgList(Request $request){
        /* $user = $this->getUser();//获取到用户的token

        $user_id = $user->id;//解析用户token获取到用户的id*/
        $mealPic = DB::table('user_meal_pic')->where('user_id',$request->input('user_id'))->orderby('id','asc')->get();
        $data = [];
        foreach ($mealPic as $item){
            $pictureData =[];
            $pictureData['id'] = $item->id;
            $pictureData['mealUrl'] = $this->fullPath($item->meal_pic_path);
            $pictureData['mealStyle'] = $item->meal_style;
            $pictureData['user_id'] =$item->user_id;
            $pictureData['created_at'] =$item->created_at;
            $data[]=$pictureData;
        }
        return $this->success($data);
    }
    public function choice(Request $request){
        /*  $user = $this->getUser();
          $user_id = $user->id;*/
        $date = $request->input('date');

    }
    public function mealImgDelete(Request $request){
        /*  $user = $this->getUser();
           $user_id = $user->id;*/
        $meal_pic_id = $request->input('meal_pic_id');
        $user_id = $request->input('user_id');
        $mealPicList = DB::table('user_meal_pic')->where('user_id',$user_id)->first();
        $res = json_decode($meal_pic_id,true);
        foreach ($res as $item){
            $pictureID = [];
            $pictureID['meal_pic_id'] = $item;
            $request = DB::table('user_meal_pic')->where('id',$pictureID)->delete();
        }
        if (!is_null($request)){
            return $this->success();
        }
    }
}
