<?php
$title = 'Tableau de bord : Commentaires'; ?>

<?php ob_start(); ?>
<?php if (isset($_SESSION)): ?>
    <?php if(!empty($_SESSION['role']) AND $_SESSION['role'] == 'administrator'): ?>

        <h1>Gestion des commentaires</h1>
            <table class="text-center table-striped table-borderless table-responsive table w-100 d-block d-sm-table d-md-table">
                <thead class="thead-dark">
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Commentaire</th>
                    <th>Signalement</th>
                    <th>Lu ou non</th>
                    <th>Action</th>
                </tr>
                </thead>
                <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?= htmlspecialchars($comment->getPostTitle())?></td>
                    <td><?=$comment->getAuthor()?></td>
                    <td><?= htmlspecialchars($comment->getCommentContent())?></td>
                    <td><?=$comment->getCommentStatus()?></td>
                    <td><?=$comment->getCommentRead()?></td>
                    <td class="btn-group" role="group" aria-label="actions">
                        <a href="index.php?action=deleteComment&amp;commentId=<?=$comment->getCommentId()?>" class="btn btn-danger p-1">Effacer commentaire</a>
                        <a href="index.php?action=unsignalReadedComment&amp;commentId=<?=$comment->getCommentId()?>" class="btn btn-secondary p-1">Annuler signalement</a>
                        <a href="index.php?action=updateReadedComment&amp;commentId=<?=$comment->getCommentId()?>" class="btn btn-danger p-1">Marquer comme lu</a>
                    </td>
                </tr>
                <?php endforeach;?>
            </table>
    <?php elseif (empty($_SESSION['role']) OR $_SESSION['role'] == 'member'):
        header('Location: index.php?action=viewHome');
        exit;
    endif;
endif;
$content = ob_get_clean(); ?>

<?php require('template.php'); ?>