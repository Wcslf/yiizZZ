<?php
namespace app\models;

use app\lib\services\ToolService;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Base extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::class,
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>[
                        'create_at','update_at'
                    ],
                    ActiveRecord::EVENT_BEFORE_UPDATE=>[
                        'update_at'
                    ]
                ]
            ],
            [
                'class'=>SluggableBehavior::class,
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>[
                        'id'
                    ]
                ],
                'value'=>function(){
                    return ToolService::getUUID();
                }
            ],
        ];
    }
    /**
     * 获取所有数据
     * @param bool $is_array 是否数组形式返回
     * @param string $where
     * @param string $sort
     * @return array|ActiveRecord[]
     */
    static public function getAll($is_array = false,$where='',$sort=''){
        $find = self::find();
        $rst = $find->where($where)->orderBy($sort)->all();
//        $sql=$find->createCommand()->getRawSql();
//        var_dump($sql);die;
        if($is_array){
            return ArrayHelper::toArray($rst);
        }
        return $rst;
    }
    /**
     * 根据ID获取
     * @param $id
     * @return array|ActiveRecord|null
     */
    static public function getOneById($id){
        return self::find()->where("id = '$id'")->one();
    }
    /**
     * 添加
     * @param $data
     * @return bool
     */
    public function add($data){
        $this->setAttributes($data,false);
        return $this->save();
    }
    /**
     * 批量添加数据
     * @param $field
     * @param $value
     * @param string $user_id
     * @return bool
     * @throws \yii\db\Exception
     */
    static public function adds($value){
        $field = array_keys($value[0]);
        $field[] = 'create_at';
        $field[] = 'update_at';
        $field[] = 'id';
        foreach ($value as $k => $v){
            $value[$k]['create_at'] = time();
            $value[$k]['update_at'] = time();
            $value[$k]['id'] = ToolService::getUUID();
        }
        if(\Yii::$app->db->createCommand()->batchInsert(self::tableName(), $field, $value)->execute()){
            return true;
        }else{
            return false;
        }
    }
    /**
     * @param $id
     * @return bool|false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    static public function delById($id){
        if(empty($id)){
            return false;
        }
        $one = self::getOneById($id);
        if(empty($one)){
            return false;
        }
        return $one->delete();
    }
    /**
     * @param array $ids id集合
     */
    static public function delByIds($ids){
        if(empty($ids)){
            return false;
        }

        if(self::deleteAll(['in','id',$ids])){
            return true;
        }else{
            return false;
        }

    }
    /**
     * 根据ID获取直接返回单个值
     * @param $id
     * @return array|ActiveRecord|null
     */
    static public function getOneByIdValue($id,$field){
        $value = self::find()->where("id = '$id'")->select($field)->column();
        return $value[0];
    }
}