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
use Tymon\JWTAuth\Exceptions\JWTException;

class ResetController extends Controller
{
    use ResetsPasswords;

    public function reset(Request $request)
    {
        $user = $this->getUser();

    }
}