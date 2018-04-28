<?php

namespace PHPMVC\LIB ;

class Autoload {

    public static function autoload($class_name){
        $class_name = str_replace("PHPMVC", '', $class_name);
        $class_name = strtolower($class_name);
        $class_name = APP_PATH . $class_name ;
        $class_name = str_replace("\\", '/', $class_name) . '.php';
        if (file_exists($class_name)){
            require_once $class_name  ;
        }
    }
}


spl_autoload_register(__NAMESPACE__ . '\Autoload::autoload');