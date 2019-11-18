<?php

namespace\App\model;
use PDO;

class UserManager extends Manager
{

    /**
     * @var \PDO $pdo l'objet sera utilisé dans plusieurs méthodes, il est utile de la stocker dans cette variable
     */
    private $pdo;

    /**
     * @var \PDOStatement $pdoStatement objet PDOStatement résultant de l'utilisation des méthodes PDO::query et PDO::prepare. PDOStatement sera utile dans plusieurs circonstances, donc le stocker dans une variable va permettre son utilisation dans différentes méthodes
     */
    private $pdoStatement;

    /**
     * UserManager constructor.
     * Initialisation de la connexion à la BDD
     *
     */
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }


    //CREATE

    /**
     * Insert un objet User dans la bdd et met à jour l'objet passé en argument en lui spécifiant un identifiant (id)
     * @param User $user objet de type User passé par référence
     * @return boolean true si l'objet a bien été inséré, false si une erreur survient
     */
    public function createMember(User &$user) //le & permet d'indiquer que je veux un passage par référence Obligé d'utiliser la class User
    {
        //Une référence n'est rien d'autre qu'une variable pointant sur une autre : elle devient un alias de la variable sur laquelle elle pointe. Si vous modifiez l'une de ces variables, les deux prendront la même valeur. Lors de la déclaration d'une référence, on fait précéder le nom de la variable à référencer d'un & ; et ce uniquement lors de sa déclaration.


        // 1ère value id (généré auto en table donc null ici) utilisation des :parametres-nommés pour les requêtes préparées
        $this->pdoStatement = $this->pdo->prepare('INSERT INTO blog_user VALUES (NULL , :nickname, CURRENT_DATE(), :email, :password, :role)');

        //Utiliser plutôt un tableau de valeur

        //liaison des paramètre avec pdoStatement et la méthode bindValue
        $this->pdoStatement->bindValue(':nickname', $user->getNickname(), PDO::PARAM_STR);
        $this->pdoStatement->bindValue(':registDate', $user->getRegistDate(), PDO::PARAM_STR);
        $this->pdoStatement->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $this->pdoStatement->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        $this->pdoStatement->bindValue(':role', $user->getRole(), PDO::PARAM_STR);

        //éxecution de la requête
        $executeIsOk = $this->pdoStatement->execute();

        if(!$executeIsOk)
        {
            return false;
        }
        else
        {
            //Je récupère l'objet inséré et je l'affecte à $user
            //Avec lastInsertId() de pdo je récupère le dernier id inséré
            $id = $this->pdo->lastInsertId();

            //J'utilise la méthode read pour lire l'identifiant
            $user = $this->readMember($id);

            //POURQUOI FAIRE COMME CA ? Parce que dans mon entité User, je ne peut que get l'id et non lui assigné un id (car il est auto-incrémenté)

            return true;
        }
    }

    //READ

    /**
     * Récupère un objet User à partir de son identifiant
     * @param $memberId  int identifiant de l'utilisateur
     * @return boolean|User|null : false si une erreur survient, un objet User si une correspondance est trouvée, Null s'il n'y a aucune correspondance
     */
    public function readMember($memberId) //Je récupère de la base //pour le login visiblement on cherche plutôt un membre par matching de nickname
    {
        //TODO réviser "les paramètres nommées" PDO https://www.youtube.com/watch?v=Iau0UY7UT8w&list=PLXGXMIp685ivxQE2cp5R33VQ9ciUB_mTo
        //J'affecte à ma variable pdoStatement le résultat de la préparation de cette requête
        $this->pdoStatement = $this->pdo->prepare('SELECT * FORM blog_user WHERE user_id = :id');

        //liaison des paramètres
        $this->pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);

        //Exécution de la requête
        $executeIsOk = $this->pdoStatement->execute();

        //Véirication de l'éxecution de la requête
        if($executeIsOk)
        {
            //récupérer sous forme d'objet le résultat de la requête
            $user = $this->pdoStatement->fetchObject('model\entites\User');

            //PDO ne fait pas la différence entre une requete réussie et l'absence de donnée résultant d'une requête, je traite donc ce cas
            if($user === false) //le cas d'une ligne vide par exemple un utilisateur supprimé
            {
                return null;
            }
            else
            {
                return $user;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * Récupère tous les objets User de la bdd
     *
     * @return array|boolean : tableau d'objets membres ou un tableau vide s'il n'y a aucun objet en bdd, ou false si une erreur survient
     */
    public function readAllMembers()
    {
        $this->pdoStatement = $this->pdo->query('SELECT * FORM blog_user ODER BY user_id = :id');

        $users = [];

        //pdo va parcourir les lignes tant qu'il ne tombera pas sur un cas user false
        while($user = $this->pdoStatement->fetchObject('model\entites\User'))
        {
            $users[] = $user;
        }

        return $users;

    }

    //UPDATE USER


    // * A savoir create et update pourraient être réunies en une seule méthode (save)
    /**
     * Met à jour un objet stocké en bdd
     * @param User $user objet de type User
     * @return boolean true en cas de succès ou false en cas d'erreur
     */
    public function updateMember(User $user)
    {
        // j'afectionne aux champs leurs valeurs ex :  	user_nickname=:nickname
        $this->pdoStatement = $this->pdo->prepare('UPDATE blog_user set user_nickname=:nickname, user_regist_date=:registDate, user_email=:email, user_password=:password, user_role=:role WHERE user_id=:id LIMIT 1'); //LIMIT 1 signifie que lors de l'update ceci ne peut s'appliquer qu'à UNE SEULE ligne ce qui limite fortement les erreurs de MAJ possible

        //liaison des paramètres à leurs valeurs
        $this->pdoStatement->bindValue(':nickname', $user->getNickname(), PDO::PARAM_STR);
        $this->pdoStatement->bindValue(':registDate', $user->getRegistDate(), PDO::PARAM_STR);
        $this->pdoStatement->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $this->pdoStatement->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        $this->pdoStatement->bindValue(':role', $user->getRole(), PDO::PARAM_STR);
        $this->pdoStatement->bindValue(':id', $user->getUserId(), PDO::PARAM_INT);

        //exécution de la requête
        return $this->pdoStatement->execute(); //renverra true si ça a fonctionné false si ça n'est pas le cas
    }

    //DELETE USER
    /**
     * Supprime un objet stocké en bdd
     * @param User $user objet de type User
     * @return boolean true en cas de succès ou false en cas d'erreur
     */
    public function deleteMember(User $user)
    {
        $this->pdoStatement = $this->pdo->prepare('DELETE FROM blog_user WHERE WHERE user_id=:id LIMIT 1'); //LIMIT 1 signifie que lors de l\'update ceci ne peut s\'appliquer qu\'à UNE SEULE ligne ce qui limite fortement les erreurs de MAJ possible

        $this->pdoStatement->bindValue(':id', $user->getUserId(), PDO::PARAM_INT);

        //exécultion de la requête
        return $this->pdoStatement->execute();
    }
}