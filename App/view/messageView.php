<?php
$title = 'Blog de Jean Forteroche : message'; ?>

<?php ob_start(); ?>

<h2>Information</h2>

<div class="bg-light d-flex flex-column container" ><?= $msg ?><div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>