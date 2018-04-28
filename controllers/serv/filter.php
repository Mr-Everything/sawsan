<?php

namespace PHPMVC\CONTROLLERS\SERV;

use PHPMVC\CONTROLLERS\AbstractController;
use PHPMVC\MODELS\FilterModel;

class Filter extends AbstractController
{

    public function findAction()
    {
        $find = Filter::filterString($_REQUEST['name']);
        $user = FilterModel::getTheFilteredUser($find);

        echo json_encode($user);
    }

}
