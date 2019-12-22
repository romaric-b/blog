<?php
$title = 'Tableau de bord : création d\'article;' ?>

<?php ob_start(); ?>
<h2>Création d'un billet</h2>

<p>TinyMCE</p>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
