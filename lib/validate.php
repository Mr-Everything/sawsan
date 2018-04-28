<?php

namespace PHPMVC\LIB ;


trait Validate
{
    //TODO : I'm not sure of using the url regex validate email .

    private $_regexPattern = [
        'num'           => '/^[0-9]+(?:\.[0-9]+)?$/',
        'int'           => '/^[0-9]+$/',
        'float'         => '/^[0-9]+\.[0-9]+$/',
        'alpha'         => '/^[a-z A-Z\p{Arabic}]+$/u',
        'alphaNum'      => '/^[a-zA-Z\p{Arabic}\0-9]+$/u',
        'email'         => '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',
        'vDate'         => '/^[0-9]{4}-|\/[0-9]{2}-|\/[0-9]{2}/',
        'url'           => '/\b(?:(?:https?|ftp):\/\/|www\.)+[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'
    ];
    public function req($value)
    {
        return !empty($value) || $value != '' ;
    }
    public function num($value)
    {
        return (bool) preg_match($this->_regexPattern['num'], $value);
    }
    public function int($value)
    {
        return (bool) preg_match($this->_regexPattern['int'], $value);
    }
    public function float($value)
    {
        return (bool) preg_match($this->_regexPattern['float'], $value);
    }
    public function alpha($value)
    {
        return (bool) preg_match($this->_regexPattern['alpha'], $value);
    }
    public function alphaNum($value)
    {
        return (bool) preg_match($this->_regexPattern['alphaNum'], $value);
    }
    public function lt($value, $matchAgainst)
    {
        if (is_numeric($value)){
            return $value < $matchAgainst ;
        }elseif (is_string($value)){
            return mb_strlen($value) < $matchAgainst ;
        }
    }
    public function eq($value, $matchAgainst){
        return $value == $matchAgainst ;
    }
    public function eq_field($value, $matchAgainst){
        return $value == $matchAgainst ;
    }
    public function gt($value, $matchAgainst)
    {
        if (is_numeric($value)){
            return $value > $matchAgainst ;
        }elseif (is_string($value)){
            return mb_strlen($value) > $matchAgainst ;
        }
    }
    public function min($value, $min)
    {
        if (is_numeric($value)){
            return strlen($value) >= $min ;
        }elseif (is_string($value)){
            return mb_strlen($value) >= $min ;
        }
    }
    public function max($value, $max)
    {
        if (is_numeric($value)){
            return strlen($value) <= $max ;
        }elseif (is_string($value)){
            return mb_strlen($value) <= $max ;
        }
    }
    public function between($value, $min, $max)
    {
        if (is_numeric($value)){
            return $value >= $min && $value <= $max;
        }elseif (is_string($value)){
            return mb_strlen($value) >= $min && mb_strlen($value) <= $max;
        }
    }
    public function floatLike($value, $beforeDP, $afterDP){
        if (!$this->float($value)){
            return false ;
        }
        $pattern = '/^[0-9]{' . $beforeDP . '}\.[0-9]{' . $afterDP . '}$/';
        return (bool) preg_match($pattern, $value);
    }
    public function vDate($value){
        return (bool) preg_match($this->_regexPattern['vDate'], $value);
    }
    public function email($value){
        return (bool) preg_match($this->_regexPattern['email'], $value);
    }
    public function url($value)
    {
        return (bool) preg_match($this->_regexPattern['url'], $value);
    }
    public function isValid($roles, $inputTypes)
    {
        $errors = [] ;
        foreach ($roles as $fieldName => $validationRoles){
            $value = $inputTypes[$fieldName];
            $validationRoles = explode('|', $validationRoles);
            foreach ($validationRoles as $validationRole){
                if (array_key_exists($fieldName, $errors)) {
                    continue;
                }
                elseif(preg_match_all('/(min)\((\d+)\)/', $validationRole, $m)){
                    if ( $this->min($value, $m[2][0]) === false ) :
                        $this->messenger->add(
                            $this->language->feedKey('text_error_'.$m[1][0], [$this->language->get('text_app_'.$fieldName), $m[2][0]]),
                            Messenger::APP_MESSAGE_ERROR
                        );
                        $errors[$fieldName] = true ;
                    endif;
                }
                elseif (preg_match_all('/(max)\((\d+)\)/', $validationRole, $m)){
                    if ( $this->max($value, $m[2][0]) === false ) :
                        $this->messenger->add(
                            $this->language->feedKey('text_error_'.$m[1][0], [$this->language->get('text_app_'.$fieldName), $m[2][0]]),
                            Messenger::APP_MESSAGE_ERROR
                        );
                        $errors[$fieldName] = true ;
                    endif;
                }
                elseif (preg_match_all('/(lt)\((\d+)\)/', $validationRole, $m)){
                    if ( $this->lt($value, $m[2][0]) === false ) :
                        $this->messenger->add(
                            $this->language->feedKey('text_error_'.$m[1][0], [$this->language->get('text_app_'.$fieldName), $m[2][0]]),
                            Messenger::APP_MESSAGE_ERROR
                        );
                        $errors[$fieldName] = true ;
                    endif;
                }
                elseif (preg_match_all('/(eq)\((\w+)\)/', $validationRole, $m)){
                    if ( $this->eq($value, $m[2][0]) === false ) :
                        $this->messenger->add(
                            $this->language->feedKey('text_error_'.$m[1][0], [$this->language->get('text_app_'.$fieldName), $m[2][0]]),
                            Messenger::APP_MESSAGE_ERROR
                        );
                        $errors[$fieldName] = true ;
                    endif;
                }
                elseif (preg_match_all('/(eq_field)\((\w+)\)/', $validationRole, $m)){
                    $otherFiled = $inputTypes[$m[2][0]];
                    if ( $this->eq_field($value, $otherFiled ) === false ) :
                        $this->messenger->add(
                            $this->language->feedKey('text_error_'.$m[1][0], [$this->language->get('text_app_'.$fieldName), $this->language->get('text_app_'.$m[2][0])]),
                            Messenger::APP_MESSAGE_ERROR
                        );
                        $errors[$fieldName] = true ;
                    endif;
                }
                elseif (preg_match_all('/(gt)\((\d+)\)/', $validationRole, $m)){
                    if ( $this->gt($value, $m[2][0]) === false ) :
                        $this->messenger->add(
                            $this->language->feedKey('text_error_'.$m[1][0], [$this->language->get('text_app_'.$fieldName), $m[2][0]]),
                            Messenger::APP_MESSAGE_ERROR
                        );
                        $errors[$fieldName] = true ;
                    endif;
                }
                elseif (preg_match_all('/(between)\((\d+),(\d+)\)/', $validationRole, $m)){
                    if ( $this->between($value, $m[2][0], $m[3][0]) === false ) :
                        $this->messenger->add(
                            $this->language->feedKey('text_error_'.$m[1][0], [$this->language->get('text_app_'.$fieldName), $m[3][0], $m[2][0]]),
                            Messenger::APP_MESSAGE_ERROR
                        );
                        $errors[$fieldName] = true ;
                    endif;
                }else {
                    if ($this->$validationRole($value) === false) :
                        $this->messenger->add(
                            $this->language->feedKey('text_error_'.$validationRole, [$this->language->get('text_app_'.$fieldName)]),
                            Messenger::APP_MESSAGE_ERROR
                        );
                        $errors[$fieldName] = true ;
                    endif;
                }
            }
        } // end of the first foreach
        return empty($errors) ? true : false ;
    } // end of the function .
}