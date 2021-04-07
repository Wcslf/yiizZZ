<?php


namespace app\modules\backend\services;




class AuthService
{
    /**
     * 账户加密
     * @param $pwd
     * @return string
     * @version v1
     * @date 2020/9/11
     */
    static public function encryption($pwd){
        return md5($pwd);
    }
    /**
     * 检查账户
     * @param $account
     * @param $password
     * @throws \app\lib\exception\Error
     * @throws \app\lib\exception\ReLogin
     * @version v1
     * @date 2020/9/12
     */
    static public function checklogin($account,$password){

//        if(!$Account = AdminService::getAccountByAP($account,$password)){
//            SendService::error('账号或密码错误');
//        }
//        if($Account->is_prohibit == 1){
//            SendService::error('账号已被禁用');
//        }
//        \Yii::$app->session->set('account_id',$Account->id);
//
//        MenuService::getAccountMenu(); //登录成功获取用户菜单
//        return SendService::send('登录成功');
    }
}