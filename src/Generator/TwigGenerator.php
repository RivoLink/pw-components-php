<?php
namespace Pw\Generator;

use Pw\Generator\Helper\CoreHelper;
use Pw\Generator\Helper\FileHelper;

class TwigGenerator {

    const FILE_PAGE = "templates_page.twig.pw";
    const FILE_LAYOUT = "templates_layout.twig.pw";

    public static function getDefaultDir(){
        $project_dir = CoreHelper::getProjectDir();
        return "$project_dir/templates";
    }

    public static function getBasePath($name){
        $base_path = "$name.html.twig";
        return $base_path;
    }

    public static function getTemplatePath($path){
        $template_pos = strpos($path, "templates");

        if(is_int($template_pos)){
            $template_path = substr($path, $template_pos+10);
            return $template_path;
        }

        return $path;
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

    public static function createLayout($name=null){
        $dir = self::getDefaultDir();

        if($name){
            $dir = dirname(self::getPath($name));
        }

        $path = "$dir/layout/index.html.twig";

        if(is_file($path)){
            return $path;
        }

        $text = FileHelper::getCompiled(self::FILE_LAYOUT);

        FileHelper::create($path, $text);
        
        return $path;
    }

    public static function createTwig($data){
        $get = [CoreHelper::class, "getIn"];

        $name = $get($data, "name");
        $title = $get($data, "title");
        $entrypoint = $get($data, "entrypoint");
        $description = $get($data, "description");
        $webpack = $get($data, "webpack");

        $path = self::getPath($name);
        $name = CoreHelper::camelToSnake($name);

        if(is_file($path)){
            return $path;
        }

        $layout = self::createLayout($name);
        $layout_tpath = self::getTemplatePath($layout);

        $text = FileHelper::getCompiled(self::FILE_PAGE, [
            "name" => $name,
            "title" => $title,
            "layout" => $layout_tpath,
            "description" => $description,
            "entrypoint" => $entrypoint,
            "webpack_config" => basename($webpack, ".js"),
        ]);
        
        FileHelper::create($path, $text);

        return $path;
    }
}
