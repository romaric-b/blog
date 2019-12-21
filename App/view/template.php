<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= $title ?></title>



    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="./public/css/style.css" rel="stylesheet" />


    <!-- Custom fonts for this template -->
<!--    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet" type="text/css">-->

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

</head>

<body id="page-top">
    <div class="global_page--div container-fluid">





        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Jean Forteroche</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main--navbar" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="main--navbar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Accueil<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Chapitres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="open-login-form" href="#login-modal?action=login">Connexion</a> <!-- TODO replacer par connecté une fois logué -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="open-register-form" href="index.php?action=register">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">A propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="index.php?action=disconnect">Déconnexion</a>
                    </li>

<!--                    <li class="nav-item">-->
<!--                        --><?php
//                        if(!empty($_SESSION)){ ?>
<!--                            <a class="nav-link" href="index.php?action=unlog">Se déconnecter</a>-->
<!--                        --><?php //}
//                        else { ?>
<!--                            <a class="nav-link" href="index.php?action=login">Connexion</a>-->
<!--                        --><?php //} ?>
<!--                    </li>-->
                </ul>
            </div>
        </nav>

        <?= $modal ?>

        <?= $content ?>



        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <span class="copyright">Copyright &copy; Jean Forteroche 2019</span>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline social-buttons">
                            <li class="list-inline-item">
                                <a href="#">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <!-- TODO mention légales -->
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div> <!--div global close-->

<!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- My Javascript -->
<!-- gestion de la validation front des formulaires : inscription, connexion, publication de commentaire

     Navigation : ouverture et fermeture des modales peut-être rajouté un type de modale pour les messages informatifs dynamiques du type "Votre signalement a bien été enregistré", "Vous êtes bien inscrit", "Vous allez être redirigé vers la page des articles" qui serait déclenché par le succès de l'action ET/OU de la requête

    Header : lorsque je suis connecté, inscription et connexion disparaitront de manière à voir connecté ainsi que déconnexion
 -->
    <!--RAPPEL : Ajax en 1er -->
    <script src="../blog/public/js/Modal.js"></script>
    <script src="../blog/public/js/main.js"></script>

</body>
</html>
