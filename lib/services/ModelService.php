<?php


namespace app\lib\services;


class ModelService
{
    public function __construct($model)
    {
        $this->model = $model;
    }
    /**
     * 添加成功后直接返回消息
     * @param $data
     * @return \yii\console\Response|\yii\web\Response
     */
    public function addReturn($data){
        $this->add($data);
        return SendService::success();
    }

    /**
     * 修改成功后直接返回数据
     * @param $id
     * @param $data
     * @return \yii\console\Response|\yii\web\Response
     * @throws \app\lib\exception\UserErrorException
     */
    public function modifyReturn($id,$data){
        $model = $this->model;
        $find = $model::getOneById($id);
        if($find->add($data)){
            return SendService::success();
        }else{
            $msg = self::getErrorOne($find);
            SendService::error($msg);
        }
    }
    /**
     * 成功返回ID 失败直接返回错误消息
     * @param $data
     * @return mixed
     */
    public function add($data){
        $model = new $this->model;
        $rst = $model->add($data);
        if($rst){
            return $model->id;
        }else{
            $msg = self::getErrorOne($model);
            SendService::error($msg);
            echo  4;
        }
    }
    /**
     * 返回第一条错误模型消息
     * @param $model object 处理的模型
     * @return bool|mixed
     */
    public static function getErrorOne($model) {
        $errors = $model->getErrors();    //得到所有的错误信息
        if(!is_array($errors)){
            return true;
        }
        $firstError = array_shift($errors);
        if(!is_array($firstError)) {
            return true;
        }
        return array_shift($firstError);
    }
    /**
     * 切换
     * @param $id
     * @param string $field
     * @return mixed
     */
    public function sw($id,$field = 'is_show'){
        $model = $this->model;
        $one = $model::getOneById($id);
        if($one->$field == 1){
            $one->$field = 0;
        }else{
            $one->$field = 1;
        }
        return $one->save();
    }
}