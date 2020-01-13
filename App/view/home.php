<?php

$title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

    <main class="main-content container d-flex bg-light-opacity" id="home">
        <div class="container full-vh">
            <div class="d-flex flex-column mx-auto marg-auto">
                <h1 class="border-bottom wellcome-blog--h1 marg-top-strong border-dark bounceInRight">Bienvenue sur le blog de Jean Forteroche</h1>
                <h2 class="title--h2 bounceInRight">Billet simple pour l'Alaska</h2>
                <a class="button-go-chapter btn btn-primary btn-lg marg-auto bounceInRight" href="index.php?action=listPosts" role="button"><i class="far fa-paper-plane"></i> Voir la liste des chapitres</a>
            </div>
        </div>
    </main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>