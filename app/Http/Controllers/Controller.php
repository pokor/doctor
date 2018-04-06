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


    /**
     * 解析并验证token 从而获得用户信息
     * @return mixed
     */
    protected function getUser()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return $user;
        } catch (TokenExpiredException $e) {
            echo json_encode([
                'code' => Status::TOKEN_EXPIRED,
                'message' => StatusText::statusToText(Status::TOKEN_EXPIRED),
                'data' => []
            ]);
            die;
        } catch (TokenInvalidException $e) {
            echo json_encode([
                'code' => Status::TOKEN_INVALID,
                'message' => StatusText::statusToText(Status::TOKEN_INVALID),
                'data' => []
            ]);
            die;
        } catch (TokenMismatchException $e) {
            echo json_encode([
                'code' => Status::TOKEN_MISMATCH,
                'message' => StatusText::statusToText(Status::TOKEN_MISMATCH),
                'data' => []
            ]);
            die;
        } catch (JWTException $e) {
            echo json_encode([
                'code' => Status::TOKEN_PARSE_FAIL,
                'message' => StatusText::statusToText(Status::TOKEN_PARSE_FAIL),
                'data' => []
            ]);
            die;
        }
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
            'data' => $data
        ]);
    }


}
