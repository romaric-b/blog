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

    public $msg;


    public function __construct(array $datas = array())
    {
        if (!empty($datas))
        {
            $this->hydrate($datas);
        }
    }

    /**
     * @param array $datas setted to my entity's parameters
     */
    public function hydrate(array $datas)
    {
        foreach ($datas as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            //call the good method of my class if she exists
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///         SETTERS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///
     /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setNickname($nickname)
    {
        if(isset($nickname))
        {
            if (!empty($nickname))
            {
                if(is_string($nickname) && strlen($nickname) <= 30 )
                {
                    $this->user_nickname = htmlspecialchars($nickname);
                }
                else
                {
                    $this->msg = 'Mauvais format du champ pseudo';
                    return;
                }
            }
            else
            {
                $this->msg = 'champ pseudo vide';
                return;
            }
        }
        else
        {
            $this->msg = 'variable non définie';
            return;
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
                if(is_string($email) && strlen($email) <= 30 && preg_match ("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
                {
                    $this->user_email = htmlspecialchars($email);
                }
                else
                {
                    $this->msg = 'Mauvais format du champ email';
                    return;
                }
            }
            else
            {
                $this->msg = 'champ email vide';
                return;
            }
        }
        else
        {
            $this->msg = 'variable non définie';
            return;
        }
    }

    /**
     * @return mixed $password
     */
    public function setPassword($password)
    {
        htmlspecialchars($password);

        if (isset($password) && !empty($password) && is_string($password) && strlen($password) <= 30)
        {
            $this->user_password = $password;
        }
    }

    public function setPassword2($password2)
    {

        htmlspecialchars($password2);

        if (isset($password2) && !empty($password2) && is_string($password2) && strlen($password2) <= 30)
        {
             $this->user_password2 = $password2;
        }
    }

    /**
     * @param mixed $user_role
     */
    public function setRole($user_role)
    {
        $this->user_role = $user_role;
    }



    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //      GETTERS
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

    public function getMessage()
    {
        return $this->msg;
    }
}
