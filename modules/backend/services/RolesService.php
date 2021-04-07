<?php


namespace app\modules\backend\services;



use app\models\AuthItemChild;
use app\models\Roles;

class RolesService
{
    /**
     * 分配权限
     * @param $authids
     * @param $role_id
     * @return bool
     * @throws \yii\db\Exception\
     */
    static function auth($authids,$role_id){

        AuthItemChild::delAuthByRole($role_id);
        $data = [];

        if(!$authids){
            return true;
        }
        foreach ($authids as $k => $v){
            $arr = [];
            $arr['child'] = $v;
            $arr['parent'] = $role_id;
            $data[] = $arr;

        }

        return AuthItemChild::adds($data);
    }
    /*
     * 获取角色
     */
    static public function getRoles(){
        return Roles::getAll(true,"is_super != 1");
    }
}