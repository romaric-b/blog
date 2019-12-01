<?php

$title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>


    <main class="main-content " id="home">
        <div class="container bg-light h-80">
            <div class="column mx-auto">
                <h1 class="border-bottom border-dark">Bienvenue sur le blog de Jean Forteroche</h1>

                <a class="btn btn-secondary btn-lg" href="#" role="button">Aller à la liste des Chaptitres</a>

                <a class="btn btn-outline-dark" href="#" role="button">Retourner au dernier chapitre lu</a>
            </div>
        </div>
    </main>



<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>