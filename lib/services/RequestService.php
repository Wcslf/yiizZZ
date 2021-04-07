<?php


namespace app\lib\services;

class RequestService
{
    /**
     * 获取当前的链接
     * @return mixed|string
     */
    static public function self(){
        return \Yii::$app->request->url;
    }
    /**
     * 判断请求是否为Post
     * @return bool|mixed
     */
    static public function isPost(){
        $request = self::Request();

        return $request->isPost;
    }

    /**
     * 判断请求是否为Post
     * @return bool|mixed
     */
    static public function isAjax(){
        $request = self::Request();

        return $request->isAjax;
    }
    /**
     * 获取请求url
     * @return mixed|string
     */
    static public function getUrl(){
        $request = self::Request();
        return $request->url;
    }
    /**
     * 获取POST数据
     * @return array|mixed]
     */
    static public function post(){
        $request = self::Request();
        return $request->post();
    }
    /**
     * 获取GET数据
     * @return array|mixed
     */
    static public function get(){
        $request = self::Request();
        return $request->get();
    }
    /**
     * 获取请求
     * @return \yii\console\Request|\yii\web\Request
     */
    static public function Request(){
        return  \Yii::$app->request;
    }
    /**
     * 获取headers参数
     * @param string $key
     * @return array|mixed|string|\yii\web\HeaderCollection
     */
    static public function headers($key = ''){

        if($key) {
            return self::Request()->headers->get($key);
        }else{
            return self::Request()->headers;
        }
    }
    /**
     * 获取域名
     * @return mixed|string|null
     */
    static public function domain(){
        return self::Request()->hostInfo;
    }
    /**
     * 获取IP
     * @return string
     */
    static public function ip(){
        return self::Request()->userIP;
    }
    /**
     * 获取请求 oauth/token
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    static public function ac(){
        $info = \Yii::$app->controller->id.'/'.\Yii::$app->controller->action->id;
        return $info;
    }
}