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
    public function createMember(User $user)  //fonctionne
    {
        var_dump('createUser ok');

        $req = $this->dbConnect()->prepare('
INSERT INTO blog_user (user_nickname, user_regist_date, user_email, user_password, user_role)
    VALUES (:nickname, NOW(), :email, :password, :role)'); //A savoir je peux mettre ce que je veux dans les values il faut juste quelque chose de parlant

        //array( 'clé' => 'valeur' , ... ) qui sera plus lisible et compréhensible
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
     * Récupère un objet User à partir de son pseudo
     * @param User $user
     * @return bool
     */
    public function readMember(User $user) //fonctionne
    {
        //J'affecte à ma variable pdoStatement le résultat de la préparation de cette requête
        $req = $this->dbConnect()->prepare("SELECT * FROM blog_user WHERE user_nickname = :nickname");

        $req->execute([
            'nickname' => $user->getNickname()
        ]);
        $users = $req->fetch();

        return $users;
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ : ALL
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Récupère tous les objets User de la bdd
     *
     * @return array|boolean : tableau d'objets members ou un tableau vide s'il n'y a aucun objet en bdd, ou false si une erreur survient
     */
    public function readAllMembers() //fonctionne
    {
        $req = $this->dbConnect()->query('SELECT * FROM blog_user ORDER BY user_id');
        $users = [];

        //pdo va parcourir les lignes tant qu'il ne tombera pas sur un cas user false
        while($user = $req->fetchObject('\App\model\entities\User'))
        {
            $users[] = $user;
        }
        var_dump($users);
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
        $req = $this->dbConnect()->prepare('UPDATE blog_user set user_nickname=:nickname, user_regist_date=:registDate, user_email=:email, user_password=:password, user_role=:role WHERE user_id =:id LIMIT 1'); //LIMIT 1 signifie que lors de l'update ceci ne peut s'appliquer qu'à UNE SEULE ligne ce qui limite fortement les erreurs de MAJ possible

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
    /**
     * Supprime un objet stocké en bdd
     * @param User $user objet de type User
     * @return boolean true en cas de succès ou false en cas d'erreur
     */
    public function deleteMember(User $user) //TODO a tester une fois le back office en place
    {
        $req = $this->dbConnect()->prepare('DELETE FROM blog_user WHERE user_id=:id LIMIT 1'); //LIMIT 1 signifie que lors de l\'update ceci ne peut s\'appliquer qu\'à UNE SEULE ligne ce qui limite fortement les erreurs possibles

        //Méthode de PDO statement, le paramètre en méthode abstraite permet entre autre de sécuriser le type de donné, ici un INT
        $req->bindValue(':id', $user->getUserId(), PDO::PARAM_INT);

        //exécution de la requête
        return $req->execute();
    }
}