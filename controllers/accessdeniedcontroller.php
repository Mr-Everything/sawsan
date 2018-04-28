<?php

namespace PHPMVC\CONTROLLERS;

class AccessDeniedController extends AbstractController
{
    public function defaultAction()
    {
        $this->language->load('default.common');
        $this->language->load('accessdenied.default');
        $this->view();
    }
}