<?php

namespace PHPMVC\LIB;

class Language
{
    private $dictionary = [];

    public function load($path)
    {
        $defaultLanguage = DEFAULT_LANG ;
        if (isset($_SESSION['lang'])){
            $defaultLanguage = $_SESSION['lang'] ;
        }
        $arrayPath = explode('.', $path);
        $fileToLoad= LANG_PATH . $defaultLanguage. DS . $arrayPath[0] . DS . $arrayPath[1] . '.lang.php';
        if(file_exists($fileToLoad)){
            require_once $fileToLoad;
            if (isset($_) && is_array($_) && !empty($_)){
                foreach ($_ as $key => $value){
                    $this->dictionary[$key] = $value ;
                }
            }
        }else {
            trigger_error("the language file {$arrayPath[0]} does not exist", E_USER_WARNING);
        }

    }
    public function getDictionary()
    {
        return $this->dictionary;
    }
    public function get($key){
        if (array_key_exists($key, $this->dictionary)) {
            return $this->dictionary[$key];
        }
    }
    public function feedKey($key, $data){
        if (array_key_exists($key, $this->dictionary)){
            array_unshift($data, $this->dictionary[$key]);
            return call_user_func_array('sprintf', $data);
        }
    }
}