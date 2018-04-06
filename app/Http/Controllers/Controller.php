<?php

namespace App\Http\Controllers;

use App\Components\Request\Status;
use App\Components\Request\StatusText;
use Illuminate\Foundation\Bus\DispatchesJobs;
//use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Tymon\JWTAuth\JWTAuth;
use Illuminate\Session\TokenMismatchException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function getUser()
    {
        try {
            $token = JWTAuth::parseToken();
        } catch (TokenExpiredException $e) {
            var_dump($e->getMessage());
            return $this->fail('');
        } catch (TokenInvalidException $e) {
            var_dump($e->getMessage());
            return $this->fail('');
        } catch (TokenMismatchException $e) {
            var_dump($e->getMessage());
            return $this->fail('');
        } catch (JWTException $e) {

            var_dump($e);
            die;
        }
        return $token->authenticate();

    }

    /**
     * 响应成功
     * @param array $data
     * @return string
     */
    protected function success(array $data = [])
    {
        return response([
            'code' => Status::REQUEST_SUCCESS,
            'message' => StatusText::statusToText(Status::REQUEST_SUCCESS),
            'data' => $data
        ]);
    }

    /**
     * 响应失败 - 验证参数、验证输入的错误提示
     * @param $code
     * @param array $data
     * @return string
     */
    protected function fail($code, array $data = [])
    {
        return response([
            'code' => $code,
            'message' => StatusText::statusToText($code),
            'date' => $data
        ]);
    }


}
