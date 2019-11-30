<?php

namespace App\model\entities;

class User
{
    /**
     * @var int $user_id
     * @var string $user_nickname
     * @var string $user_regist_date
     * @var string $user_email
     * @var string $user_password
     * @var string $user_password2
     * @var string $user_role
     */
    private $user_id;
    private $user_nickname;
    private $user_regist_date;
    private $user_email;
    private $user_password;
    private $user_password2;
    private $user_role;


    public function __construct(array $datas = array())
    {
        //On hydrate pas un tableau de données vide
        if (!empty($datas))
        {
            $this->hydrate($datas);
        }
    }

    //// Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
    ///
    /// PARCOURS du tableau $datas (avec pour clé $key et pour valeur $value)
    //  On assigne à $setter la valeur « 'set'.$key », en mettant la 
    //  première lettre de $key en majuscule (utilisation de ucfirst())
    //  SI la méthode set$key de notre classe existe ALORS
    //    On invoque set$key($valeur)
    //  FIN SI
    //FIN PARCOURS
    public function hydrate(array $datas) //Et si j'ai bien compris, ça rend les setters autoexecutants comme on pouvait faire en JS lorsqu'on appelait une méthode dans son constructeur
    {
        foreach ($datas as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method))
            {
                // il existe on peut l'appeler
                $this->$method($value);
            }
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///         SETTERS : affecter une valeur à une propriété d'objet private
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function setNickname($nickname)
    {
        if(isset($nickname))
        {
            if (!empty($nickname))
            {
                if(is_string($nickname) <= 30 )
                {
                    $this->user_nickname = htmlspecialchars($nickname);
                }
                else
                {
                    echo 'Mauvais format du champ pseudo';
                }
            }
            else
            {
                echo 'champ pseudo vide';
            }
        }
        else
        {
            echo 'variable non définie';
        }
    }

    public function setRegistDate($user_regist_date)
    {
        $this->user_regist_date = $user_regist_date;
    }

    public function setEmail($email)
    {
        if(isset($email))
        {
            if (!empty($email))
            {
                //Vérification type et format
                if(is_string($email) <= 30 && preg_match ("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
                {
                    //C'est valide, je sécurise les éventuelles entités html
                    $this->user_email = htmlspecialchars($email);
                }
                else
                {
                    echo 'Mauvais format du champ email';
                }
            }
            else
            {
                echo 'champ email vide';
            }
        }
        else
        {
            echo 'variable non définie';
        }
    }

    //je pense que ma méthode d'hydratation exisge que j'ai un setter pour password et password2 sinon il ne sera pas assigné
    /**
     * @return mixed
     */
    public function setPassword($password) //bug possible : un un $password2 indéfini
    {
        htmlspecialchars($password);

        if (isset($password) && !empty($password) && is_string($password))
        {
            $this->user_password = $password;
        }
    }

    public function setPassword2($password2)
    {

        htmlspecialchars($password2);

        if (isset($password2) && !empty($password2) && is_string($password2))
        {
             $this->user_password2 = $password2;
        }
    }



    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //      GETTERS méthode chargée de renvoyer la valeur d'un attribut
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getNickname()
    {
        return $this->user_nickname;
    }

    public function getRegistDate()
    {
        return $this->user_regist_date;
    }

    public function getEmail()
    {
        return $this->user_email;
    }

    public function getPassword()
    {
        return $this->user_password;
    }

    public function getPassword2()
    {
        return $this->user_password2;
    }

    public function getRole()
    {
        return $this->user_role;
    }
}
