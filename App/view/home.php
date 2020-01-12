<?php

$title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

    <main class="main-content d-flex" id="home">
        <div class="container bg-light h-80">
            <div class="column mx-auto marg-auto">
                <h1 class="border-bottom wellcome-blog--h1 border-dark">Bienvenue sur le blog de Jean Forteroche</h1>
                <h2 class="title--h2 marg-auto">Billet simple pour l'Alaska</h2>
                <a class="button-go-chapter btn btn-secondary btn-lg marg-auto" href="index.php?action=listPosts" role="button"><i class="far fa-paper-plane"></i> Voir la liste des chapitres</a>
            </div>
        </div>
    </main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>