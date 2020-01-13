<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Blog de Jean Forteroche, roman dernièrement paru Billet simple pour l'Alaska">
    <meta name="author" content="Jean Forteroche">
    <title><?= $title ?></title>



    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="./public/css/style.css" rel="stylesheet" />


    <!-- Custom fonts for this template -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,500,600,700&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

</head>

<body id="page-top">
    <div class="global_page--div col-xl container-fluid flex-column bg_home">

        <!--Login Modal-->
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Connexion</h5>
                        <button type="button" id="close-login-modal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="d-flex flex-column" action="index.php?action=login" method="POST">
                            <p class="d-flex flex-column">
                                <span>* Ces champs sont obligatoires</span>
                                <label class="d-flex flex-column" for="login--nickname">Entrez votre pseudo * :
                                    <input type="text" name="loginNickname" placeholder="Pseudo" id="login--nickname" required/>
                                </label>
                                <label class="d-flex flex-column" for="login--password">Tapez votre mot de passe * :
                                    <input type="password" name="loginPassword" placeholder="Mot de passe"  id="login--password" required/>
                                </label>
                                Vous n'êtes pas inscrit ? <a class="nav-link" id="open-register-form" data-dismiss="modal" data-toggle="modal" data-target="#register-modal" href="#">Inscrivez-vous ici</a>
                            </p>
                            <p>
                                <input  class="btn btn-primary"  type="submit" name="loginForm" value="Se connecter"/>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!--Register Modal-->
        <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="inscription-modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="inscription-modal">Inscription</h5>
                        <button type="button" id="close-regist-modal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="d-flex flex-column" action="index.php?action=register" method="POST">
                            <p>
                                <span>* Ces champs sont obligatoires</span>
                                <label class="d-flex flex-column" for="regist--nickname">Entrez votre pseudo comportant 1 à 30 caractères * :
                                    <input type="text" name="registNickname" placeholder="Pseudo" id="regist--nickname" value=""  required/>
                                </label>
                                <label class="d-flex flex-column" for="regist--email">Entrez votre adresse email * :
                                    <input type="email" name="registEmail" placeholder="Email" id="regist--email" required/>
                                </label>
                                <label class="d-flex flex-column" for="regist--password">Tapez votre mot de passe comportant 1 à 30 caractères * :
                                    <input type="password" name="registPassword" placeholder="Mot de passe" id="regist--password" required/>
                                </label>
                                <label class="d-flex flex-column" for="regist--confirm-password">Confirmez votre mot de passe * :
                                    <input type="password" name="registPassword2" placeholder="Confirmation mot de passe" id="regist--confirm-password" required/>
                                </label>
                            </p>
                            <p>
                                <input class="btn btn-primary" type="submit" name="registForm" value="Valider"/>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light container">
            <a class="header--a navbar-brand d-flex row" href="index.php?action=viewHome">
                <h1 class="header_title--h1 row">
                    <div class="header-logo"></div>
                    <div class="title_name">Jean Forteroche</div><span class="title--span">Billet simple pour l'Alaska</span>
                </h1>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main--navbar" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="main--navbar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=viewHome">Accueil<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=listPosts">Chapitres</a>
                    </li>
<!--                    <li class="nav-item">-->
<!--                        <a class="nav-link" href="#">A propos</a>-->
<!--                    </li>-->
                    <li class="nav-item">
                        <?php
                        if(!empty($_SESSION['role'])){ ?>
                            <a class="nav-link" href="index.php?action=disconnect">Se déconnecter</a>

                        <?php }
                        else { ?>
                            <a class="nav-link" id="open-register-form"  data-toggle="modal" data-target="#register-modal" href="#">Inscription</a>
                        </li>
                            <a class="nav-link" data-toggle="modal" data-target="#login-modal"  href="#">Connexion</a>
                        <?php } ?>
                        </li>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'administrator'){ ?>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=viewHomeDashboard">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=viewCommentDashboard">Gérer commentaires</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=viewPostDashboard">Gérer chapitres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=viewMemberDashboard">Gérer Membres</a>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </nav>

        <?= $content ?>

        <!-- Footer -->
        <footer class="footer container bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <span class="copyright">Copyright &copy; Jean Forteroche 2019</span>
                    </div>
                    <div class="col-md-4">
                        <a class="nav-link text-black-50" href="#">Mentions légales</a>
                    </div>
                </div>
            </div>
        </footer>
    </div> <!--div global close-->

    <!--TinyMCE-->
    <script src="https://cdn.tiny.cloud/1/sguduqeo4kbrmiicmeazgnj892slxkt1nd2wz04afbus4c3y/tinymce/5/tinymce.min.js"></script>
    <script>tinymce.init({selector:'.tinymce-edition', language : 'fr_FR'});</script>
<!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
