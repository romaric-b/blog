<?php

namespace App\model;

//use PDO;

abstract class Manager
{
    /**
     * @var \PDO $pdo l'objet sera utilisé dans plusieurs méthodes, il est utile de la stocker dans cette variable
     */
//    private $pdo;

    /**
     * @var \PDOStatement $pdoStatement objet PDOStatement résultant de l'utilisation des méthodes PDO::query et PDO::prepare. PDOStatement sera utile dans plusieurs circonstances, donc le stocker dans une variable va permettre son utilisation dans différentes méthodes
     */
//    private $pdoStatement;


    protected function dbConnect()
    {
        $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $bdd;
    }
}