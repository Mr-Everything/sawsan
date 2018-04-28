<?php

namespace PHPMVC\CONTROLLERS;

class NotFoundController extends AbstractController {

    public function notFoundAction(){

        $this->language->load('notfound.default');
        $this->getFuck();

    }

    public function defaultAction(){
        var_dump("nothing");
    }


}
