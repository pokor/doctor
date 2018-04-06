<?php
/**
 * 定义响应状态码
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/6
 * Time: 15:04
 */

namespace App\Components\Request;


class Status
{
    const REQUEST_SUCCESS = 0;//请求成功
    const REQUEST_FAIL = -1;//请求失败

    // 登录相关
    const LOGIN_FAIL = 10000; //登录失败
    const LOGIN_MOBILE_UNREGISTER = 10001; //手机号未注册
    const REGISTER_FAIL = 10002; //注册失败
    const MOBILE_HAS_REGISTERED = 10003; //注册失败
    const MOBILE_HAS_MUST = 10004; //缺少手机号参数
    const PASSWORD_HAS_MUST = 10005; //缺少密码参数


    //
}