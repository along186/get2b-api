<?php
namespace App\Helper;

class ArrayHelper
{
    static function object2Array($obj){
        $newArray = array();

        if($obj) {
            foreach($obj as $key => $value){
                if(is_object($value)||is_array($value)){
                    $newArray[$key] = self::object2Array($value);
                }else{
                    $newArray[$key] = $value;
                }
            }
        }

        return $newArray;
    }

    //二维数组去掉重复值
    static function array_unique_fb($array2D){
        foreach ($array2D as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v); //再将拆开的数组重新组装
        }
        return $temp;
    }
}