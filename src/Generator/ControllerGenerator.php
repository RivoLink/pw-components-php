<?php
namespace Pw\Generator;

use Pw\Generator\Helper\CoreHelper;
use Pw\Generator\Helper\FileHelper;

class ControllerGenerator {

    const PSR4 = "App";
    const FILE = "class_controller.php.pw";

    public static function getDefaultDir(){
        $project_dir = CoreHelper::getProjectDir();
        return "$project_dir/src/Controller";
    }

    public static function getFilename($name, $extension=false){
        $path = self::getPath($name);
        
        if($extension){
            return basename($path);
        }

        return basename($path, ".php");
    }

    public static function getPath($name){
        $default_dir = self::getDefaultDir();
        $project_dir = CoreHelper::getProjectDir();

        if(CoreHelper::isPath($name)){
            $path = "$project_dir/$name";

            if(!is_int(strpos($name, ".php"))){
                $path = "$project_dir/$name.php";
            }

            return $path;
        }
        else {
            $path = "$default_dir/$name.php";
            return $path;
        }

        return null;
    }

    public static function getNamespace($name){
        $path = self::getPath($name);
        $path = dirname($path);

        $src_pos = strpos($path, "src");
        
        $namespace = self::PSR4.substr($path, $src_pos+3);
        $namespace = str_replace('/', '\\', $namespace);

        return $namespace;
    }

    public static function createController($name){
        $path = self::getPath($name);
        $dir = dirname($path);

        if(is_file($path)){
            return $path;
        }

        if(!file_exists($dir)){
            mkdir($dir, 0775, true);
        }

        $text = FileHelper::getCompiled(self::FILE, [
            "name" => self::getFilename($name),
            "namespace" => self::getNamespace($name),
        ]);

        FileHelper::create($path, $text);

        return $path;
    }




}
