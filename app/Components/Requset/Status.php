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
    const LOGIN_MOBILE_UNREGISTERED = 10001; //手机号未注册
    const REGISTER_FAIL = 10002; //注册失败
    const MOBILE_HAS_REGISTERED = 10003; //注册失败
    const MOBILE_HAS_MUST = 10004; //缺少手机号参数
    const PASSWORD_HAS_MUST = 10005; //缺少密码参数


    // token解析
    const TOKEN_EXPIRED = 10011; //token过期
    const TOKEN_INVALID = 10012; //token无效
    const TOKEN_MISMATCH = 10013; //token缺少
    const TOKEN_PARSE_FAIL = 10014; //token解析失败
}