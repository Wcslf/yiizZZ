<?php


namespace frontend\lib\services;


class TransactionService
{
    //事务对象
    public $transaction;
    /**
    * 开启事务
    */
    public function beginTransaction(){
        $db = \Yii::$app->db;
        $this->transaction = $db->beginTransaction();
    }
    /**
     * 提交事务
     */
    public function commit(){
        $this->transaction->commit();
    }
    /**
     * 回滚事务
     */
    public function rollBack(){
        $this->transaction->rollBack();
    }

    /**
     *
     * 事务
     * return TransactionService::transaction(function($db) {
     *      $user = Users::getRecordById("1");
     *      $user->source = '13';
     *      $user->save();
     *      return ResponseService::success();
     * });
     */
    static public function transaction($callback){
        return \Yii::$app->db->transaction($callback);
    }
}