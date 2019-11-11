<?php

require_once("model/Manager.php");

class UserManager extends Manager
{
    public function getMember($memberId) //Je récupère de la base
    {
        $db = $this->dbConnect();
        $members = $db->prepare('SELECT user_id, user_nickname, user_email, user_password, user_role DATE_FORMAT(user_regist_date, \'%d/%m/%Y à %Hh%imin%ss\') AS user_regist_date_fr FROM blog_user WHERE user_id = ? ORDER BY comment_date DESC');
        $members->execute(array()); // TODO remplir array

        return $members;
    }

    public function setMember($postId, $author, $comment) //j'envoie en base
    {
        $db = $this->dbConnect();
        $members = $db->prepare('INSERT INTO blog_user(user_id, user_nickname, user_regist_date, user_email, user_password, user_role) VALUES(?, ?, ?, NOW())');
        $members->execute(array()); // TODO remplir array

        return $members;
    }
}