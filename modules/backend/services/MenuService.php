<?php
namespace app\modules\backend\services;

use app\models\AuthItemChild;
use app\models\Menu;

class MenuService
{
    /**
     * 简单而朴素
     * @return array|\yii\db\ActiveRecord[]
     */
    static public function getAllTree(){
       $menu0 = Menu::getAll(true,['parent_id'=>'0'],'sort asc');
       $tree = [];
        foreach ($menu0 as $k => $v){
            $tree[] = $v;
            $menu2 = Menu::getAll(true,['parent_id'=>$v['id']],'sort asc');
            foreach ($menu2 as $k1 => $v1){
                $v1['le'] = 10;
                $tree[] = $v1;
                $menu3 = Menu::getAll(true,['parent_id'=>$v1['id']],'sort asc');
                foreach ($menu3 as $k2 => $v2){
                    $v1['le'] = 20;
                    $tree[] = $v2;
                }
            }
        }
        return $tree;
    }
    /**
     * 权限树
     * @param $parent_id
     * @param $roleid
     * @return array
     */
    static public function toTree($parent_id,$roleid){
        $menu = Menu::find()->where("parent_id = '$parent_id' and is_show = 1 ")->asArray()->orderBy('sort')->all();
        $tree = [];
        if($menu){
            foreach ($menu as $k => $v){
                $arr = [];
                $arr['name'] = $v['name'];
                $arr['value'] = $v['rules'];
                $checked =false;
                //有权限则选中
                $menu = AuthItemChild::find()->where(" parent = '$roleid' and child = '{$v['rules']}'")->select('parent')->column();
                if(!empty($menu)){
                    $checked = true;
                }
                $arr['checked'] = $checked;
                $arr['list'] =self::toTree($v['id'],$roleid);
                $tree[] = $arr;
            }
            return $tree;
        }else{
            return $tree;
        }
    }
}