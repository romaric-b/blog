<?php

$title = 'Blog de Jean Forteroche : accueil'; ?>

<?php ob_start(); ?>


    <main class="main-content " id="home">
        <div class="container bg-light h-80">
            <div class="column mx-auto">
                <h1 class="border-bottom border-dark">Bienvenue sur le blog de Jean Forteroche</h1>

                <a class="btn btn-secondary btn-lg" href="index.php?action=displayPost&postId=" role="button">Aller à la liste des Chaptitres</a>

<!--                <a class="btn btn-outline-dark" href="#" role="button">Retourner au dernier chapitre lu</a>-->
            </div>
        </div>
    </main>



<?php $content = ob_get_clean(); ?>
<?php //ob_start(); ?>
<!---->
<!--    <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="inscription-modal" aria-hidden="true">-->
<!--        <div class="modal-dialog" role="document">-->
<!--            <div class="modal-content">-->
<!---->
<!--                <div class="modal-header">-->
<!--                    <h5 class="modal-title" id="inscription-modal">Inscription</h5>-->
<!--                    <button type="button" id="close-regist-modal" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                        <span aria-hidden="true">&times;</span>-->
<!--                    </button>-->
<!--                </div>-->
<!--                <div class="modal-body">-->
<!--                    <form action="index.php?action=register" method="POST">-->
<!--                        <p>-->
<!--                            <label for="regist--nickname">Entrez votre pseudo :-->
<!--                                <input type="text" name="registNickname" placeholder="Pseudo" id="regist--nickname" value=""  required/>-->
<!--                            </label>-->
<!--                            <label for="regist--email">Entrez votre adresse email :-->
<!--                                <input type="email" name="registEmail" placeholder="Email" id="regist--email" required/>-->
<!--                            </label>-->
<!--                            <label for="regist--password">Tapez votre mot de passe :-->
<!--                                <input type="password" name="registPassword" placeholder="Mot de passe" id="regist--password" required/>-->
<!--                            </label>-->
<!--                            <label for="regist--confirm-password">Confirmez votre mot de passe :-->
<!--                                <input type="password" name="registPassword2" placeholder="Confirmation mot de passe" id="regist--confirm-password" required/>-->
<!--                            </label>-->
<!--                        </p>-->
<!--                        <p>-->
<!--                            <input type="submit" name="registForm" value="Valider"/>-->
<!--                        </p>-->
<!--                    </form>-->
<!--                </div>-->
<!--                <div class="modal-footer">-->
<!--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>-->
<!--                    <button type="button" class="btn btn-primary">Valider</button>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<?php //$modal = ob_get_clean(); ?>
<?php require_once('register.php') ; ?>
<?php require('template.php'); ?>