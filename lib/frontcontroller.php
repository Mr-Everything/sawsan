<?php

namespace PHPMVC\LIB;

class FrontController
{

    use Helper;

    private $_controllers = 'index';
    private $_action = 'default';
    private $_params = [];
    private $_language;
    private $registry;
    private $authentication;

    const NOT_FOUND_CONTROLLER = 'PHPMVC\Controllers\\notfoundController';
    const NOT_FOUND_ACTION = 'NotFoundAction';

    public function __construct(Language $lang, Registry $registry, Authentication $auth)
    {

        $this->_language = $lang;
        $this->registry = $registry;
        $this->authentication = $auth;
        $this->_parseUrl();

    }

    private function _parseUrl()
    {
        $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 3);
        if (isset($url[0]) && $url[0] != '') {
            $this->_controllers = $url[0];
        }
        if (isset($url[1]) && $url[1] != '') {
            $this->_action = $url[1];
        }
        if (isset($url[2]) && $url[2] != '') {
            $this->_params = explode('/', $url[2]);
        }

    }

    public function dispatch()
    {
        /**
         * If its a service so use this inside the url
         * ("/serv/file_name_/action_name_without_using_action")
         */
        if ($this->_controllers == 'serv') {
            // so this is a request ...
            $controllerClassName = 'PHPMVC\Controllers\Serv\\' . ucfirst($this->_action);
            if (!class_exists($controllerClassName)) {
                $controllerClassName = $this->_controllers = self::NOT_FOUND_CONTROLLER;
                $actionName = $this->_action . 'Action';
            } else {
                $actionName = @$this->_params[0] . 'Action';

                if (!method_exists($controllerClassName, $actionName)) {
                    $actionName = $this->_action = self::NOT_FOUND_ACTION;
                    $controllerClassName = $this->_controllers = self::NOT_FOUND_CONTROLLER;
                }
            }

        } /**
         * If its not a service then use this
         * ("/serv/file_name_/action_name_without_using_action")
         */

        else {
            $controllerClassName = 'PHPMVC\Controllers\\' . ucfirst($this->_controllers) . 'Controller';

            if (!class_exists($controllerClassName)) {
                $controllerClassName = $this->_controllers = self::NOT_FOUND_CONTROLLER;
            }
            $actionName = $this->_action . 'Action';

            if (!method_exists($controllerClassName, $actionName)) {
                $actionName = $this->_action = self::NOT_FOUND_ACTION;
                $controllerClassName = $this->_controllers = self::NOT_FOUND_CONTROLLER;
            }
        }

        $object = new $controllerClassName();
        $object->setController($this->_controllers);
        $object->setAction($this->_action);
        $object->setParams($this->_params);
        $object->setLanguage($this->_language);
        $object->setRegistry($this->registry);
        $object->$actionName();

    }

}