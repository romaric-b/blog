<?php

namespace model\entities;

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

    //RAPPEL : les Setters fournissent une donnée à mon entité. Une fois fait je peux utiliser ces données avec les getters

    //Permettra de passer des données à l'instanciation directement sous forme de tableau en clé valeur
    public function __construct(array $donnees = array())
    {
        //On hydrate pas un tableau de données vide
        if (!empty($donnees))
        {
            $this->hydrate($donnees);
        }
    }

    //SETTERS

    public function hydrate(array $datas)
    {
        //je fais une boucle avec le tableau de données
        foreach ($datas as $key => $value)
        {
            //je récupère le nom des setters correspondants
            //si la clé est UserId son setter est getUserId
            //Il suffit de mettre la première lettre en MAJ et de la prefixer
            $method = 'set'.ucfirst($key);

            var_dump($method);

            //Vérifie si la méthode existe
            if (method_exists(array($this, $method)))
            {
                // il existe on peut l'appeler
                $this->$method($value);
            }
        }
    }

    //Pas besoin de set id car l'id est généré automatiquement de façon auto-incrémenté dans la table user

    public function setNickname($nickname)
    {
        echo '<p>passe</p>';
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

    public function setPassword($password)
    {
        if(isset($password))
        {
            if (!empty($password))
            {
                if(is_string($password) <= 30 )
                {
                    htmlspecialchars($password);
                    $this->user_password = password_hash($password);
                }
                else
                {
                    echo 'Mauvais format du mot de passe';
                }
            }
            else
            {
                echo 'champ mot de passe vide';
            }
        }
        else
        {
            echo 'variable non définie';
        }
    }

    public function setPassword2($password2)
    {
        if(isset($password2))
        {
            if (!empty($password2))
            {
                if(is_string($password2) <= 30 )
                {
                    htmlspecialchars($password2);
                    $this->user_password2 = password_hash($password2);
                }
                else
                {
                    echo 'Mauvais format du mot de passe';
                }
            }
            else
            {
                echo 'champ mot de passe vide';
            }
        }
        else
        {
            echo 'variable non définie';
        }
    }

    public function setRole($role)
    {
        $this->user_role = $role;
    }

    //GETTERS

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