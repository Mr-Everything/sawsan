<?php

namespace PHPMVC\LIB;

class Messenger
{

    const APP_MESSAGE_SUCCESS   = 1 ;
    const APP_MESSAGE_ERROR     = 2 ;
    const APP_MESSAGE_WARNING   = 3 ;
    const APP_MESSAGE_INFO      = 4 ;

    private static $_instance       ;
    private $_session               ;
    private $_messages              ;

    public static function getInstance($session){
        if (self::$_instance === null){
            self::$_instance = new self($session);
        }
        return self::$_instance ;
    }
    private function __construct($session)
    {
        $this->_session = $session ;
    }
    private function __clone(){}

    public function add($message, $type = self::APP_MESSAGE_SUCCESS)
    {
        if (!$this->messageExist()){
            $this->_session->messages = [] ;
        }
        $msgs = $this->_session->messages ;
        $msgs[] = [$message, $type]       ;
        $this->_session->messages = $msgs ;
    }
    private function messageExist(){
        return isset($this->_session->messages);
    }
    public function getMessages(){
        if ($this->messageExist()){
            $this->_messages = $this->_session->messages ;
            unset($this->_session->messages);
            return $this->_messages ;
        }
        return [] ;
    }


}