<?php

namespace App\model;

class Manager
{
    protected function dbConnect()
    {
        //try et catch ?
        $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $db;
    }
}