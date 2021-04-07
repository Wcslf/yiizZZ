<?php


namespace app\modules\backend\controllers;

use app\lib\services\RequestService;
use app\lib\services\SendService;
use app\models\Account;
use app\modules\backend\services\AccountService;
use app\modules\backend\services\HelpService;
use app\modules\backend\services\RolesService;


class AccountController extends BaseController
{
    /*
     * 列表
     */
    public function actionIndex(){

        return $this->render('index');
    }
    public function actionGetData(){
        $get = RequestService::get();
        $getMenuAll= HelpService::getPageList(Account::class,$get['limit'],$get['page']);
        return SendService::customSend($getMenuAll);
    }
    /*
     *  添加
     */
    public function actionAdd(){
        if(RequestService::isPost()){
            $post = RequestService::post();
            AccountService::addAccount($post);
            return SendService::success();
        }
        $Roles = RolesService::getRoles();
        return $this->render('handle',[
            'roles'=>$Roles
        ]);
    }
    public function actionEdit(){
        $get = RequestService::get();
        if(RequestService::isPost()){
            $post = RequestService::post();
            return AccountService::editAccount($post);
        }
        $data = Account::getOneById($get['id']);
        $Roles = RolesService::getRoles();
        return $this->render('handle',[
            'data'=>$data,
            'roles'=>$Roles
        ]);
    }
    /*
     * 删除
     */
    public function actionDel(){
        $post = RequestService::post();
        if(Account::delById($post['id'])){
            return SendService::success();
        }else{
            SendService::error();
        }
    }
    /*
     * 批量删除
     */
    public function actionDels(){
        $get = RequestService::post();
        if(Account::delByIds($get['ids'])){
            SendService::success();
        }else{
            SendService::error();
        }
    }
}