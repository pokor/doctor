<?php

namespace App\Http\Controllers\Home;

use App\Components\Request\Status;
use App\Models\RemindModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeRemindController extends Controller
{
    //
    public function index(Request $request){
        /* $user = $this->getUser();//获取到用户的token

        $user_id = $user->id;//解析用户token获取到用户的id*/
        $user_id = $request->input('user_id');
        $use_time = $request->input('use_time');
        $kind = $request->input('kind');
        $dosage = $request->input('dosage');
        $way = $request->input('way');
        $status = $request->input('status');
        $remind = new RemindModel();
        $remind ->user_id = $user_id;
        $remind ->use_time = $use_time;
        $remind ->kind = $kind;
        $remind ->dosage = $dosage;
        $remind ->way = $way;
        $remind ->status = $status;
        $remind->save();
        $data = [];
        $info = [];
        $info['use_time'] = $use_time;
        $info['use_id'] = $user_id;
        $info['kind'] = $kind;
        $info['dosage'] = $dosage ;
        $info['way'] = $way;
        $info['status'] = $status;
        $data['info'] = $info;
        return $this->success($data);

    }
    public function remindList(Request $request){
        /* $user = $this->getUser();//获取到用户的token

         $user_id = $user->id;//解析用户token获取到用户的id*/
        $user_id = 15;
        $remin = DB::table('user_medication')->where('user_id',$user_id)->orderby('id','asc')->get();
        $data =[];
        foreach ($remin as $items){
            $reminData = [];
            $reminData['use_time'] =$items->use_time ;
            $reminData['use_id'] =$items->use_id ;
            $reminData['kind'] = $items->kind;
            $reminData['dosage'] = $items->dosage;
            $reminData['way'] = $items->way;
            $reminData['status'] = $items->status;
            $data[] = $reminData;
        }
        return $this->success($data);
    }
    public function deleted(Request $request){
        $remin_id = $request->input('remin_id');
        $user_id = $request->input('user_id');
        $req = DB::table('user_medication')->where('id',$remin_id)->delete();
        if ($req){
            $data = [];
            $info = [];
            $info['status'] = Status::REQUEST_SUCCESS;
            $data[] = $info;
            return $this->success($data);
        }
        return $this->fail(Status::REQUEST_FAIL);
    }
}
