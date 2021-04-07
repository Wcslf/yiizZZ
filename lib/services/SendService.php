<?php


namespace app\lib\services;



use app\lib\exception\UserErrorException;
use yii\web\Response;

class SendService
{
    /**
     * 发送错误消息
     * @param $msg
     * @throws UserErrorException
     */
    static public function error($msg='操作失败'){
        throw new UserErrorException($msg);
    }
    /**
     * 操作成功
     * @param string $msg
     * @return \yii\console\Response|Response
     */
    static public function success($msg='操作成功'){
        return self::send([],$msg);
    }
    /**
     * 发送数据
     * @param $data
     * @param string $msg
     * @param int $error_code
     * @return \yii\console\Response|Response
     */
    static public function send($data,$msg='操作成功',$error_code = 0){
        $response = \Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->statusCode = 200;
        $response->data = [
            'data'=>$data,
            'msg'=>$msg,
            'error_code'=>$error_code,
            'code'=>0
        ];
        $response->send();
        return $response;
    }
    /**
     * 自定义返回内容
     * @param $data
     * @param string $msg
     * @param int $error_code
     * @return \yii\console\Response|Response
     */
    static public function customSend($data,$msg='操作成功',$error_code = 0){
        $response = \Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->statusCode = 200;
        $response->data = $data;
        $response->send();
        return $response;
    }
}