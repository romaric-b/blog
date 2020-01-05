<?php

$title = 'Page introuvable'; ?>

<?php ob_start(); ?>

    <main class="main-content" id="home">
        <h1>Erreur 404</h1>
        <div class="container bg-light h-80">
            <p>Erreur 404 : La page demandée est introuvable
                <a href="index.php?action=viewHome">Retourner à l'accueil</a>
            </p>
        </div>
    </main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>