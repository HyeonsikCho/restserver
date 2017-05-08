<?php

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017-04-20
 * Time: 오후 6:52
 */
class LoginConfigHelper
{
    static function SESSION_VALID_TIME() {
        //return 60; // 1분
        return 60 * 60 * 5; // 5시간
    }

    static function REFRESH_SIGN_ATLEAST_TIME() {
        //return 30; // 30초
        return 60 * 60 * 1; // 1시간
    }
}