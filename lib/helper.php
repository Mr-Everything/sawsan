<?php

namespace PHPMVC\LIB ;

trait Helper
{

    public function redirect($page)
    {
        session_write_close();
        header("Location: $page");
        exit();
    }

}