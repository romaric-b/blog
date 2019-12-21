<?php

namespace App\controller;

class FrontController
{
    /**
     * @param $fileName receive string name of view's file
     */
    public function loadView($fileName)
    {
        require("App/View/" . $fileName .".php");
    }
}

?>