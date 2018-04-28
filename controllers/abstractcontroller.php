<?php

namespace PHPMVC\CONTROLLERS;

use PHPMVC\LIB\Filter;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\Validate;

class AbstractController
{
    use Validate, Helper, Filter;

    protected $controller;
    protected $action;
    protected $params;
    protected $language;
    protected $registry;
    protected $_data = [];


    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function setRegistry($registry)
    {
        $this->registry = $registry;
    }

    public function __get($name)
    {

        if (isset($this->registry->$name)) {
            return $this->registry->$name;
        }
        return null;
    }

    // get view on the function
    protected function getFuck()
    {
        extract(array_merge($this->language->getDictionary()));
        require_once NOT_FOUND_PAGE;
    }

    public function view()
    {
        $view = VIEW_PATH . DS . $this->controller . DS . $this->action . '.view.php';
        if (!file_exists($view)) {
            $view = NOT_FOUND_PAGE;
        }

//        var_dump($this, $view);
//        exit();

        extract(array_merge($this->_data, $this->language->getDictionary()));

        require_once TEMPLATE_PATH . 'head.php';
        require_once TEMPLATE_PATH . 'nav.php';
        require_once $view;
        require_once TEMPLATE_PATH . 'footer.php';
    }
}