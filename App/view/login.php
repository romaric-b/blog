<?php

$title = 'Blog de Jean Forteroche : connexion'; ?>

<?php ob_start(); ?>

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
                        <form action="index.php?action=login" method="POST">
                            <p>
                                <label for="login--nickname">Entrez votre pseudo :
                                    <input type="text" name="loginNickname" placeholder="Pseudo" id="login--nickname" required/>
                                </label>
                                <label for="login--password">Tapez votre mot de passe :
                                    <input type="password" name="loginPassword" placeholder="Mot de passe"  id="login--password" required/>
                                </label>
                                <label for="autoLogin">Se souvenir de moi :
                                    <input type="checkbox" name="autolog" id="autoLogin">
                                </label>
                            </p>
                            <p>
                                <input type="submit" name="loginForm" value="Se connecter"/>
                            </p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Valider</button>
                    </div>

                </div>
            </div>
        </div>

<?php $modal = ob_get_clean(); ?>

<?php require('template.php'); ?>