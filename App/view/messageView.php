<?php
$title = 'Blog de Jean Forteroche : message'; ?>

<?php ob_start(); ?>
<section class="container d-flex full-vh flex-column bg-light">
    <h2>Information</h2>
    <div class="bg-light d-flex flex-column" ><?= $msg ?><div>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>