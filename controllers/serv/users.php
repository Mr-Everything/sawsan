<?php

namespace PHPMVC\CONTROLLERS\SERV;

use PHPMVC\CONTROLLERS\AbstractController;
use PHPMVC\LIB\Filter;
use PHPMVC\MODELS\UsersModel;

class Users extends AbstractController
{

    public function signAction()
    {

        $firstName = Filter::filterString($_REQUEST['FirstName']);
        $lastName = Filter::filterString($_REQUEST['LastName']);
        $email = Filter::filterString($_REQUEST['Email']);
        $password = Filter::cryptPassword($_REQUEST['Password']);
        $status = Filter::filterInt($_REQUEST['Status']);
        $code   = Filter::filterInt($_REQUEST['Code']);

        $user = new UsersModel();
        $user->FirstName = $firstName;
        $user->LastName = $lastName;
        $user->Email = $email;
        $user->Password = $password;
        $user->Status = $status;

        $json = new \stdClass();

        if ($user->save()) {
            $json->result = "1";
        } else {
            $json->result = "0";
        }

        echo json_encode($json);

    }


    public function loginAction()
    {

        $email = Filter::filterString($_REQUEST['Email']);
        $password = Filter::cryptPassword($_REQUEST['Password']);

        $user = (new UsersModel())->getBy(['Email' => $email, 'Password' => $password]);
        $user = array_shift($user);
        $json = new \stdClass();

        if ($user) {
            $json = $user;
        } else {
            $json->result = false;
        }

        echo json_encode($json);


    }
}
