<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/6
 * Time: 16:19
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Components\Request\Status;
class ResetController extends Controller
{
    use ResetsPasswords;

    public function reset(Request $request)
    {
        /*$user = $this->getUser();*/
        $reset_password = $request->input('restPassword');
        //dd(bcrypt($reset_password));
        $mobile = $request->input('mobile');
        $reset = DB::table('user')->where('mobile',$mobile)->update(['password'=>bcrypt($reset_password),'updated_at'=>date('Y-m-d H:i:s')]);
        //dd($reset);
        $data =[];
        $info = [];
        if (!empty($reset)){
            $info['code'] = Status::REQUEST_SUCCESS;
            $info['massage']= '修改成功';
            return $this->success($data);
        }else{
            return $this->fail(Status::REQUEST_FAIL);
        }
    }
}