<?php


namespace app\models;


class AuthItemChild extends Base
{
    static public function delAuthByRole($role_id){

        self::deleteAll(['parent'=>$role_id]);

    }
}