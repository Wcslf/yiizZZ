<?php
namespace app\lib\exception;



use app\lib\services\SendService;
use yii\web\ErrorHandler;


class ExceptionHandler extends ErrorHandler
{
    public function renderException($exception) {
        // 处理用户错误
        if($exception instanceof UserErrorException){
            return SendService::send([],$exception->getMessage(),1);
        }
/*
        // 权限不足
        if($exception instanceof NoPermissions){
            return SendService::errorMsg('权限不足,请联系管理员开通');
        }
        // 重新登录
        if($exception instanceof ReLogin){
            return header('Location: '.url::toRoute('site/login'));
        }*/

        if(YII_DEBUG){
            //开发模式使用YII自带的错误处理便于寻找错误
            parent::renderException($exception);
        }else{
            //生产模式
//            return SendService::errorMsg('内部错误');
        }
    }
}