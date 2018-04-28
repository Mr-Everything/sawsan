<?php

namespace PHPMVC\CONTROLLERS;

class IndexController extends AbstractController {

    public function defaultAction(){


        $this->language->load('default.common');
        $this->view();

    }


}
