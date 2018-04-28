<?php

namespace PHPMVC\CONTROLLERS\SERV;

use PHPMVC\CONTROLLERS\AbstractController;
use PHPMVC\LIB\FileUpload;

class Files extends AbstractController
{

    public function setFile(){

        $file = !empty($_FILES['File']['name']) ? (new FileUpload($_FILES['image']))->upload()->getFileName() : '';

        if ($file){
            return "1";
        }else {
            return "0";
        }
    }

}
