<?php

namespace PHPMVC ;
use PHPMVC\LIB\Authentication;
use PHPMVC\LIB\FrontController;
use PHPMVC\LIB\Language;
use PHPMVC\LIB\Messenger;
use PHPMVC\LIB\Registry;
use PHPMVC\LIB\SessionManager;

require_once 'config' . DIRECTORY_SEPARATOR . 'config.php';
require_once 'lib' . DS . 'autoload.php';

$session = new SessionManager();
$session->start();
if (!isset($session->lang)) {
    $session->lang = 'en';
}

// Language object
$language = new Language();

// singleton
$messenger = Messenger::getInstance($session);
$registry  = Registry::getInstance();
$auth      = Authentication::getInstance($session);

$registry->session   = $session  ;
$registry->messenger = $messenger ;

// template object

$frontController = new FrontController($language, $registry, $auth);
$frontController->dispatch();