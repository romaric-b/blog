<?php
$title = 'Blog de Jean Forteroche : message'; ?>

<?php ob_start(); ?>

<h1>Message</h1>

<div><?= $msg ?><div>



<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>