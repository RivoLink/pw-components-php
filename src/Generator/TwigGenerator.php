<?php
namespace Pw\Generator;

use Pw\Generator\Helper\CoreHelper;
use Pw\Generator\Helper\FileHelper;

class TwigGenerator {

    const DEFAULT_DOMAINS = [
        "front",
        "admin",
        "member",
    ];

    public static function getDefaultDir(){
        $project_dir = CoreHelper::getProjectDir();
        return "$project_dir/templates";
    }

    public static function getBasePath($name){
        $base_path = "$name.html.twig";
        return $base_path;
    }

    public static function getPath($name){
        $default_dir = self::getDefaultDir();

        $path = "$default_dir/$name";

        if(!is_int(strpos($name, ".html.twig"))){
            $path = "$default_dir/$name.html.twig";
        }

        return $path;
    }

    public static function getFilename($name, $extension=false){
        $path = self::getPath($name);
        
        if($extension){
            return basename($path);
        }

        return basename($path, ".html.twig");
    }

    public function createLayout($name=null){
        $dir = self::getDefaultDir();

        if($name){
            $dir = dirname(self::getPath($name));
        }

        $path = "$dir/layout.html.twig";


        // TODO

        
        return $path;
    }

    public static function createTwig($name){
        $path = self::getPath($name);
        $dir = dirname($path);

        if(is_file($path)){
            return $path;
        }

        if(!file_exists($dir)){
            mkdir($dir, 0775, true);
        }

        // TODO

        return $path;
    }

    

    


    





}
