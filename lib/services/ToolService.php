<?php


namespace app\lib\services;
use Faker\Provider\Uuid;
class ToolService
{
    /**
     * 返回格式的时间
     * @param string $format
     * @return false|string
     */
    static public function datetime($format = "Y-m-d H:i:s"){
        return date($format,time());
    }
    /**
     * 生成随机编号
     */
    static public function randCode($len = 5,$prefix=''){
        $str = '';
        for ($i = 0;$i<$len;$i++){
            $str = $str.rand(0,9);
        }
        return $prefix.$str;
    }
    /**
     * 生成补位编号
     * @param $code
     * @param string $prefix
     * @param int $len
     * @return string
     */
    static public function sprintfCode($code,$prefix='',$len = 8){
        $var=$prefix.sprintf("%0".$len."d", $code);//生成4位数，不足前面补0
        return $var;
    }
    /**
     * 生成UUID
     * @return string
     */
    static public function getUUID(){
        return Uuid::uuid();
    }
    /**
     * 判断文件夹是否存在不存在则创建
     * @param $dir
     * @param int $mode
     * @return bool
     * @version v1
     * @date 2020/10/14
     */
    static public function mkdirs($dir, $mode = 0777){
        if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
        if (!self::mkdirs(dirname($dir), $mode)) return FALSE;
        return @mkdir($dir, $mode);
    }
}