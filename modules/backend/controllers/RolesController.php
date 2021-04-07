<?php


namespace app\modules\backend\controllers;

/*
 * 角色控制器
 */

use app\lib\services\ModelService;
use app\lib\services\RequestService;
use app\lib\services\SendService;
use app\models\AuthItemChild;
use app\models\Roles;
use app\modules\backend\services\HelpService;
use app\modules\backend\services\RolesService;


class RolesController extends BaseController
{
    /**
     * 角色列表
     * @return string
     */
    public function actionIndex(){
        return $this->render('index');
    }
    /**
     * 返回数据
     * @return \yii\console\Response|\yii\web\Response
     */
    public function actionGetData(){
        $get = RequestService::get();
        $where = '';
        if($get['title']){
            $where = "name like '%{$get['title']}%'";
        }
        $getMenuAll= HelpService::getPageList(Roles::class,$get['limit'],$get['page'],$where);
        return SendService::customSend($getMenuAll);
    }

    /**
     * 添加数据
     * @return string|\yii\console\Response|\yii\web\Response
     */
    public function actionAdd(){
        if(RequestService::isPost()){
            $post = RequestService::post();
            $Model = new ModelService(Roles::class);
            return $Model->addReturn($post);
        }
        return $this->render('handle');
    }
    /**
     * 编辑数据
     * @return string|\yii\console\Response|\yii\web\Response
     */
    public function actionEdit(){
        if(RequestService::isPost()){
            $post = RequestService::post();
            $Model = new ModelService(Roles::class);
            return $Model->addReturn($post);
        }
        $get = RequestService::get();
        $data = Roles::getOneById($get['id']);
        return $this->render('handle',[
            'data'=>$data,
        ]);
    }
    /**
     * 删除数据
     * @throws \Throwable
     * @throws \app\lib\exception\UserErrorException
     * @throws \yii\db\StaleObjectException
     */
    public function actionDel(){
        $post = RequestService::post();
        if(AuthItemChild::find()->where("parent = '{$post['id']}'")->count()){
            SendService::error('请先取消当前角色的权限');
        }
        if(Roles::delById($post['id'])){
            SendService::success();
        }else{
            SendService::error();
        }

    }

    /**
     * 权限列表
     * @return string
     */
    public function actionDistribution(){
        $get = RequestService::get();
        $user_id = $get['id'];
        return $this->render('distribution',[
            'user_id'=>$user_id,
        ]);
    }

    /**
     * 编辑权限
     * @return void|\yii\console\Response|\yii\web\Response
     * @throws \app\lib\exception\UserErrorException
     */
    public function actionAuthEdit(){

        $Post = RequestService::get();
        //提交的权限
        $authids = $Post['authids'];
        //角色
        $id = $Post['id'];

        //分配权限
        if(RolesService::auth($authids,$id)){
            return SendService::success();
        }else{
            SendService::error();
        }

    }
}