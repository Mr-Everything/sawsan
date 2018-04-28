<?php

namespace PHPMVC\CONTROLLERS;

use PHPMVC\LIB\Filter;
use PHPMVC\LIB\Helper;
use PHPMVC\LIB\Messenger;
use PHPMVC\MODELS\UsersModel;

class AuthController extends AbstractController
{

    private $_authdata = [
        'username'  => 'req|between(5,12)|alphaNum',
        'password'  => 'req|min(8)',
    ];

    public function loginAction()
    {
        $this->language->load('default.common');
        $this->language->load('auth.data');

        if (isset($_POST['submit'])){

//            var_dump($_POST);
//            exit();

            $this->language->load('auth.message');

            $user = new UsersModel();

            $username = Filter::filterString($_POST['username']);
            $password =  Filter::cryptPassword($_POST['password']);
            $xss = Filter::CrossSiteScripting($username);
            if ($xss == true) {
                $this->messenger->add($this->language->get('xss_text_login_failed'), Messenger::APP_MESSAGE_WARNING);
                $this->redirect('/auth/login');
            }
            $userfound = $user->authenticate($username,$password, $this->session);

            if ($userfound == true){
                $this->redirect("/");
            }else{
                $this->messenger->add($this->language->get('text_login_failed'), Messenger::APP_MESSAGE_ERROR);
            }
        }
        $this->view(true);
        $this->session->kill();
    }
    public function logoutAction()
    {
        $this->session->kill();
        $this->redirect("/auth/login");
    }

}