<?php

namespace App\model;


use PDO;

class Manager
{

    /**
     * @return PDO
     */
    protected function dbConnect()
    {

        $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $bdd;
    }
}