<?php
namespace app\modules\backend\services;

use app\lib\services\RequestService;
use yii\helpers\Url;

class ViewService
{
    /**
     * 加载css
     * @return string
     */
    static public function css(){
       return "@app/modules/backend/views/layouts/css.php";
    }
    /**
     * 加载js
     * @return string
     */
    static public function js(){
        return '@app/modules/backend/views/layouts/js.php';
    }
    /**
     * 加载assets
     * @return string
     */
    static public function assets(){
        return '@app/modules/backend/views/layouts/assets.php';
    }
    /**
     * 根据控制器生成url
     * @param $action
     */
    static public function toUrl($action){
        return Url::toRoute(\Yii::$app->controller->id.'/'.$action);
    }
    /**
     * 直接生成url
     * @param $url
     */
    static public function Url($url){
        return Url::toRoute($url);
    }
    /**
     * 获取当前连接
     * @return mixed|string
     */
    static public function self(){
        return RequestService::self();
    }
}