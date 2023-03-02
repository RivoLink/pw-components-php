<?php
namespace Pw\Generator\Helper;

class CoreHelper {

    public static function applyParams($text, $params=[]){
        if(!$text || !is_array($params)){
            return $text;
        }

        foreach($params as $key => $value){
            $value = $value ? $value : "";
            $text = str_replace('{{'.$key.'}}', $value, $text);
        }

        while(is_int($left = strrpos($text, '{{'))){
            $len = strlen($text);

            $right = strrpos($text, '}}');
            $right = ($right > 0) ? $right+2 : $left+2;

            $safe = substr($text, 0, $left);
            $safe = $safe.substr($text, $right, $len - $right);

            $text = $safe;
        }

        return $text;
    }

    public static function getIn($array, $key, $default=null){
        if(is_array($array) && $key){
            if(strpos($key, '|') > 0){
                list($field, $prop) = explode('|', $key);
                
                if(isset($array[$field][$prop]) && $array[$field][$prop]){
                    return $array[$field][$prop];
                }
            }
            else if(isset($array[$key]) && $array[$key]){
                return $array[$key];
            }
        }
        return $default;
    }

    public static function isPath($text){
        if(is_int(strpos($text, "/"))){
            return true;
        }

        return false;
    }

    public static function getProjectDir(){
        return getcwd();
    }
}
