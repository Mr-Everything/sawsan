<?php

namespace PHPMVC\LIB;

class Registry
{
    private static $instance ;

    private function __construct(){} // prevent instantiation
    private function __clone(){} // prevent cloning

    public static function getInstance() // get only one object
    {
        if (null === self::$instance){
            self::$instance = new self();
        }
        return self::$instance ;
    }

    public function __set($name, $value)
    {
        $this->$name = $value ;
    }
    public function __get($name)
    {
        return $this->$name ;
    }

}

