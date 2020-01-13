<?php

namespace App\model;

use App\model\entities\User;

class UserManager extends Manager
{

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          CREATE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Insert user object in database
     * @param User $user object of type Class User
     */
    public function createMember(User $user)
    {
        $req = $this->dbConnect()->prepare('
INSERT INTO blog_user (user_nickname, user_regist_date, user_email, user_password, user_role)
    VALUES (:nickname, NOW(), :email, :password, :role)');

        $req->execute([
            'nickname' => $user->getNickname(),
            'email' => $user->getEmail(),
            'password' => password_hash($user->getPassword(),PASSWORD_DEFAULT),
            'role' => $user->getRole()
        ]);
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Receive an object user. Used for login et registring.
     * @param User $user
     * @return $user the matched user
     */
    public function readMember(User $user)
    {
        $req = $this->dbConnect()->prepare("SELECT user_id, user_nickname, DATE_FORMAT(user_regist_date, '%d/%m/%Y à %Hh%imin') AS user_regist_date_fr, user_email, user_password, user_role FROM blog_user WHERE user_nickname = :nickname");
        $req->execute([
            'nickname' => $user->getNickname()
        ]);
        $user = $req->fetch();
        return $user;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ : ALL
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Receive all user objets from database
     * @return array which contains each $user object
     */
    public function readAllMembers()
    {
        $req = $this->dbConnect()->query('SELECT user_id ,user_nickname, DATE_FORMAT(user_regist_date, \'%d/%m/%Y à %Hh%imin\') AS user_regist_date_fr, user_email, user_password, user_role  FROM blog_user ORDER BY user_id');
        $users = [];

        while($user = $req->fetchObject('\App\model\entities\User'))
        {
            $users[] = $user;
        }
        return $users;
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          UPDATE USER
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /** NOT USED
     * Update an object user
     * @param User $user object type Class User which will be updated
     * @return boolean true success | false fail
     */
//    public function updateMember(User $user)
//    {
//        $req = $this->dbConnect()->prepare('UPDATE blog_user set user_nickname = :nickname, user_email = :email, user_password = :password, user_role = :role WHERE user_id = :user_id LIMIT 1');
//
//        $req->execute([
//            'nickname' => $user->getNickname(),
//            'email' => $user->getEmail(),
//            'password' => $user->getPassword(),
//            'role' => $user->getRole(),
//            'user_id' => $user->getUserId()
//        ]);
//
//        return $req->execute();
//    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          DELETE USER
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Delete an object user of database
     * @param $user_id id of the user to delete
     * @return boolean true success | false fail
     */
    public function deleteMember($user_id)
    {
        $req = $this->dbConnect()->prepare('DELETE FROM blog_user WHERE user_id = ? LIMIT 1');

        $req->execute(array($user_id));

        return $req->execute();
    }
}