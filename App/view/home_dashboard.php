<?php

$title = 'Tableau de bord : vue d\'ensemble'; ?>

<?php ob_start(); ?>

    <div class="text-center  mb-4">
        <h2>Panneau d'administration</h2>

<?php if (isset($_SESSION)): ?>
    <?php if ($_SESSION['role'] == 'administrator'): ?>
        <p>Bonjour Jean Forteroche et bienvenu sur votre tableau de bord</p>

        <a href="index.php?action=addPost" class="btn btn-primary p-1">Créer un article</a>
    </div>

        <section class="admin-report text-center mb-4">
            <h3>Commentaires signalés</h3>

            <?php if (empty($signaledComments)): ?>

                <p>Aucun commentaire signalé</p>

            <?php else: ?>
            <table class="text-center table-striped table-borderless table-responsive table w-100 d-block d-sm-table d-md-table">
                <thead class="thead-dark">
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Commentaire</th>
                    <th>Signalement</th>
                    <th>Action</th>
                </tr>
                </thead>

                <?php foreach ($signaledComments as $signaledComment): ?>

                    <tr>
                        <td><?= htmlspecialchars($signaledComment->getPostTitle())?></td>
                        <td><?=$signaledComment->getAuthor()?></td>
                        <td><?= htmlspecialchars($signaledComment->getCommentContent())?></td>
                        <td><?=$signaledComment->getCommentStatus()?></td>
                        <td class="btn-group" role="group" aria-label="actions">
                            <a href="index.php?action=deleteComment&commentId=<?=$signaledComment->getCommentId()?>" class="btn btn-danger p-1">Effacer commentaire</a>
                            <a href="index.php?action=unsignalComment&commentId=<?=$signaledComment->getCommentId()?>" class="btn btn-secondary p-1">Annuler signalement</a>
                        </td>
                    </tr>

                <?php endforeach;?>
                <?php endif;?>

            </table>
        </section>


    <?php elseif (!empty($_SESSION['role'])):
        header('Location: index.php?action=listPosts');
//    var_dump('redirection car membbre');
        exit;
    endif;
endif;
$content = ob_get_clean(); ?>

<?php require('template.php'); ?>