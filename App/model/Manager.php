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

    //class abstraite amélioration possible voir cet exemple : https://www.youtube.com/watch?v=3Iy1KRb-bcs

    //methode définissant si on fait un prepare ou un query($sql)
    //if(getter entité = null) POSE PROBLEME
    // prepare($sql)
    //elseif (getter entité != null car pas de paramètre entré)
    // query typiquement le readAll()

    // pdo, si aucun pdo déà enregistré
    // je fais un nouveau pdo
}