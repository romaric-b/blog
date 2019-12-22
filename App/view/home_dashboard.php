<?php

$title = 'Tableau de bord : vue d\'ensemble'; ?>

<?php ob_start(); ?>

    <section class="admin-create text-center  mb-4">
    <h2>Panneau d'administration</h2>

<?php if (isset($_SESSION)): ?>
    <?php if ($_SESSION['role'] == 'administrator'): ?>
                <p>Bonjour Jean Forteroche et bienvenu sur votre tableau de bord</p>

        </section>

    <?php elseif ($_SESSION['role'] == 'member'):
        header('Location: index.php?action=listPosts');
        exit;
    else:
        header('Location: index.php?action=listPosts');
        exit;
    endif;
endif;
$content = ob_get_clean(); ?>

<?php require('template.php'); ?>