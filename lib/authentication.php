<?php

namespace PHPMVC\LIB;

class Authentication
{
    private static $Instance ;
    private $session ;
//    private $_excludedRoutes = [
//        '/index/default',
//        '/auth/logout',
//        '/users/profile',
//        '/users/changepassword',
//        '/users/settings',
//        '/language/default',
//        '/accessdenied/default',
//        '/notfound/notfound',
//        '/test/default',
//        '/users/checkuserexistsajax'
//    ];

    private function __construct($session){
        $this->session = $session;
    }
    private function __clone(){}

    public static function getInstance(SessionManager $session)
    {
        if(self::$Instance === null){
            self::$Instance = new self($session);
        }
        return self::$Instance;
    }

    public function isAuthorized(){
        return isset($this->session->u);
    }

    public function hasAccess($controller, $action)
    {
        return true ;

//        $url = strtolower('/' . $controller . '/' . $action);
//        if (in_array($url, $this->_excludedRoutes) || self::checkIfInArray($url, $this->session->u->Privileges)){
//            return true ;
//        }
//        return false;
    }


    private static function checkIfInArray($needle, $heystacks /* associative array */){
        foreach($heystacks as $heystack) {
            if($needle == $heystack->PrivilegeLink) { return true ; }
        }
        return false ;
    }

}