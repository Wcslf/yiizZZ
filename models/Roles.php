<?php
namespace app\models;


class Roles extends Base
{
    public function rules()
    {
        return [
            [
                ['name'], 'required', 'message' => '{attribute}不能为空'
            ],
            [
                ['name'], 'unique', 'message' => '{attribute}已存在'
            ],
        ];

    }
    public function attributeLabels()
    {
        return [
            'name'=>'角色名',
        ];
    }
}