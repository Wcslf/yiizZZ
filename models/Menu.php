<?php


namespace app\models;


class Menu extends Base
{
    public function rules()
    {
        return [
            [
                ['name','sort','rules'], 'required', 'message' => '{attribute}不能为空'
            ],
            [
                ['rules'], 'unique', 'message' => '{attribute}不能重复'
            ]

        ];

    }
    public function attributeLabels()
    {
        return [
            'name'=>'权限名',
            'sort'=>'排序',
            'rules'=>'规则表达式'
        ];
    }
}