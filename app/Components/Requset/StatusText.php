<?php
/**
 * 定义响应状态码说明
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/6
 * Time: 15:08
 */

namespace App\Components\Request;


class StatusText
{
    /**
     * 返回状态码对应的文本说明
     * @param $statusCode
     * @return mixed
     */
    public static function statusToText($statusCode)
    {
        if(isset(static::text()[$statusCode])){
            return static::text()[$statusCode];
        }
        var_dump("状态码 $statusCode 未定义说明") ;die;
    }

    /**
     * 定义状态码对应的说明
     * @return array
     */
    private static function text(){
        return [
            Status::REQUEST_SUCCESS => '请求成功',
            Status::REQUEST_FAIL => '请求失败',
            Status::CODE_ERROR => '验证码不正确',

            // 登录相关
            Status::LOGIN_FAIL => '登录失败',
            Status::LOGIN_MOBILE_UNREGISTERED => '手机号未注册',
            Status::REGISTER_FAIL => '注册失败',
            Status::MOBILE_HAS_REGISTERED => '手机号已注册',
            Status::MOBILE_HAS_MUST => '缺少手机号参数',
            Status::PASSWORD_HAS_MUST => '缺少密码参数',

            //token
            Status::TOKEN_EXPIRED => 'token过期',
            Status::TOKEN_INVALID => 'token无效',
            Status::TOKEN_MISMATCH => 'token缺少',
            Status::TOKEN_PARSE_FAIL => 'token解析失败',


            //图片或视频上传相关
            Status::PICTURE_FORMAT => '图片格式不正确',
            Status::PICTURE_FAIL => '图片上传失败',
            Status::PICTURE_SUCCESS => '图片上传成功',
            Status::PICTURE_FAIL => '图片上传失败',
            Status::PICTURE_SIZE => '图片格式不正确',
            Status::VIDEO_FORMAT => '视频格式不正确',
            Status::VIDEO_SIZE => '视频太大',
            Status::VIDEO_FAIL => '视频上传失败',
            Status::VIDEO_SUCCESS => '视频上传成功',
            Status::VIDEO_FAIL => '视频上传失败',
        ];
    }

}