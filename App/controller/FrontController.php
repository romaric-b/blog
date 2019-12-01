<?php

namespace App\controller;

class FrontController
{
    public function viewHome()
    {
        require_once('App/view/home.php');
    }
}

?>