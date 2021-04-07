<?php


namespace app\modules\backend\services;


class HelpService
{
    /**
     * 后台分页数据
     * @param $classModel
     * @param $limit
     * @param $page
     * @param string $where
     * @return array
     */
    static public function getPageList($classModel,$limit,$page,$where = ''){
        $find = $classModel::find();
        if($where){
            $find->andWhere($where);
        }
        $rst['count'] = $find->count();
        $offset = ($page-1)*$limit;
        $find->offset($offset);
        $find->limit($limit);
        $rst['data'] =$find->asArray()->all();
        $rst['code'] =0;
        return $rst;
    }

}