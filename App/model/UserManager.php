<?php

namespace App\model;

use App\model\entities\User;

class UserManager extends Manager //Je peux faire un final, une classe finale signifie qu'elle ne pourra pas être étendue par une classe fille
{

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          CREATE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///
    /**
     * Insert un objet User dans la bdd et met à jour l'objet passé en argument en lui spécifiant un identifiant (id)
     * @param User $user objet de type User
     * @return boolean true si l'objet a bien été inséré, false si une erreur survient
     */
    public function createMember(User $user) //le & permet d'indiquer que je veux un passage par référence Obligé d'utiliser la class User
    {
        var_dump('createUser ok');

        $req = $this->dbConnect()->prepare('
INSERT INTO blog_user (user_nickname, user_regist_date, user_email, user_password, user_role)
    VALUES (:nickname, NOW(), :email, :password, :role)'); //A savoir je peux mettre ce que je veux dans les values il faut juste quelque chose de parlant

        //array( 'clé' => 'valeur' , ... ) qui sera plus lisible et compréhensible
        $req->execute([
            'nickname' => $user->getNickname(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()
        ]);
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Récupère un objet User à partir de son pseudo
     * @param User $user
     * @return bool
     */
    public function readMember(User $user) //Je récupère de la base //pour le login visiblement on cherche plutôt un membre par matching de nickname
    {
        var_dump('dans readMember()');
        //J'affecte à ma variable pdoStatement le résultat de la préparation de cette requête
        $req = $this->dbConnect()->prepare("SELECT user_id, COUNT(user_nickname), user_regist_date FROM blog_user WHERE user_nickname = " . $user->getNickname());

        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\Entity\User');
        $req->fetch();
        $users = $req->execute(array($user));

        return $users;

//        $result = $req->execute(array($user->getNickname()));
//        $result = $req->execute(array($user));
//        return $result;

        //Peut-être conserver ce principe : @return boolean|User|null : false si une erreur survient, un objet User si une correspondance est trouvée, Null s'il n'y a aucune correspondance
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ : ALL
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Récupère tous les objets User de la bdd
     *
     * @return array|boolean : tableau d'objets members ou un tableau vide s'il n'y a aucun objet en bdd, ou false si une erreur survient
     */
    public function readAllMembers()
    {
        $req = $this->dbConnect()->query('SELECT * FORM blog_user ODER BY user_id = :id');
        $users = [];

        //pdo va parcourir les lignes tant qu'il ne tombera pas sur un cas user false
        while($user = $req->fetchObject('model\entites\User'))
        {
            $users[] = $user;
        }
        return $users;
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          UPDATE USER
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // * A savoir create et update pourraient être réunies en une seule méthode (save)
    /**
     * Met à jour un objet stocké en bdd
     * @param User $user objet de type User
     * @return boolean true en cas de succès ou false en cas d'erreur
     */
    public function updateMember(User $user)
    {
        // j'afectionne aux champs leurs valeurs ex :  	user_nickname=:nickname
        $req = $this->dbConnect()->prepare('UPDATE blog_user set user_nickname=:nickname, user_regist_date=:registDate, user_email=:email, user_password=:password, user_role=:role WHERE user_id=:id LIMIT 1'); //LIMIT 1 signifie que lors de l'update ceci ne peut s'appliquer qu'à UNE SEULE ligne ce qui limite fortement les erreurs de MAJ possible

        //liaison des paramètres à leurs valeurs
        $req->execute([
            'nickname' => $user->getNickname(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);

        //exécution de la requête
        return $req->execute(); //renverra true si ça a fonctionné false si ça n'est pas le cas
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          DELETE USER
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///
    /**
     * Supprime un objet stocké en bdd
     * @param User $user objet de type User
     * @return boolean true en cas de succès ou false en cas d'erreur
     */
    public function deleteMember(User $user)
    {
        $req = $this->dbConnect()->prepare('DELETE FROM blog_user WHERE WHERE user_id=:id LIMIT 1'); //LIMIT 1 signifie que lors de l\'update ceci ne peut s\'appliquer qu\'à UNE SEULE ligne ce qui limite fortement les erreurs possibles

        //Méthode de PDO statement, le paramètre en méthode abstraite permet entre autre de sécuriser le type de donné, ici un INT
        $req->bindValue(':id', $user->getUserId(), PDO::PARAM_INT);

        //exécultion de la requête
        return $this->pdoStatement->execute();
    }
}