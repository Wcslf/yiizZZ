<?php


namespace app\modules\backend\services;


use app\lib\services\ModelService;
use app\lib\services\SendService;
use app\models\Account;

class AccountService
{
    /**
     * 账户添加
     * @param $getPostData
     * @return mixed
     * @throws \app\lib\exception\UserErrorException
     */
    static public function addAccount($getPostData){
        $Model = new ModelService(Account::class);
        if(empty($getPostData['password'])){
            SendService::error('密码不得为空');
        }
        $getPostData['password'] = AuthService::encryption($getPostData['password']);
        return $Model->add($getPostData);
    }
    /**
     * 账户编辑
     * @param $post
     * @return \yii\console\Response|\yii\web\Response
     * @throws \app\lib\exception\UserErrorException
     */
    static public function editAccount($post){
        if($post['password']){
            $post['password'] = AuthService::encryption($post['password']);
        }else{
            unset($post['password']);
        }
        $Model = new ModelService(Account::class);
        return $Model->modifyReturn($post['id'],$post);
    }
}