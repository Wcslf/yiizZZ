<?php


namespace app\modules\backend\services;


class ConfService
{
    /**
     * 列出控制器
     * @return array
     */
    static public function getAllController(){
        $modelPath = 'modules/backend';
        $planPath = \Yii::$app->BasePath.DIRECTORY_SEPARATOR.$modelPath.DIRECTORY_SEPARATOR.'controllers';

        $dirRes   = opendir($planPath);
        while($dir = readdir($dirRes))
        {
            if(!in_array($dir,array('.','..','.svn')))
            {
                $planList[] = basename($dir,'.php');
            }
        }
        return $planList;
    }
    /**
     * 列出控制器里的方法
     * @param $c
     * @return array
     * @throws \ReflectionException
     */
    static public function getActionByController($c){
        $selectControl = [];
        $className = "app\modules\backend\controllers\\".$c;

        $methods = (new \ReflectionClass($className))->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            if ($method->class == $className) {
                if ($method->name != 'beforeAction') {
                    $selectControl[] = $method->name;
                }
            }
        }

        return $selectControl;

    }
}