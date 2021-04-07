<?php


namespace app\models;



class Account extends Base
{

    public function rules()
    {
        return [
            [
                ['account'], 'required', 'message' => '{attribute}不能为空'
            ],
            [
                ['account'], 'unique', 'message' => '{attribute}不能重复'
            ]

        ];

    }
    public function attributeLabels()
    {
        return [
            'account'=>'登录账户'
        ];
    }
    public function getRole(){

        return $this->hasOne(Roles::class, ['id' => 'roles_id']);

    }
}