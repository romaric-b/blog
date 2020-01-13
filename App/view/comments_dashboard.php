<?php
$title = 'Tableau de bord : Commentaires'; ?>

<?php ob_start(); ?>
<?php if (isset($_SESSION)): ?>
    <?php if(!empty($_SESSION['role']) AND $_SESSION['role'] == 'administrator'): ?>
    <div class="bg-light container full-vh">
        <h1>Gestion des commentaires</h1>
        <?php if(empty($comments) OR $comments == NULL): ?>
            <p>Aucun commentaire.</p>

        <?php elseif(!empty($comments)): ?>
        <div class="d-flex marg-top-strong row">
            <a class="btn btn-secondary p-1 marg-auto marg-top marg-bot w-25" href="index?action=viewCommentDashboardOrderByNotRead"><i class="fas fa-book"></i>Trier par commentaires non lus</a>
            <a class="btn btn-secondary p-1 marg-auto marg-bot w-25" href="index?action=viewCommentDashboardOrderByRead"><i class="fas fa-book-open"></i>Trier par commentaires déjà lus</a>
        </div>
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
            <table class="text-center bg-light table-striped table-borderless table-responsive table w-100 d-block d-sm-table d-md-table">
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
                    <td><?=$comment->getCommentStatusFr()?></td>
                    <td><?=$comment->getCommentReadFr()?></td>
                    <td class="btn-group" role="group" aria-label="actions">
                        <?php $_SESSION['comment' . $comment->getCommentId()] = $comment;
                        ?>
                        <a href="index.php?action=deleteComment&amp;&commentId=<?=$comment->getCommentId()?>" class="btn btn-danger p-1"><i class="far fa-trash-alt"></i>Effacer commentaire</a>
                        <a href="index.php?action=unsignalReadedComment&amp;commentId=<?=$comment->getCommentId()?>" class="btn btn-warning p-1"><i class="fas fa-undo"></i>Annuler signalement</a>
                        <a href="index.php?action=updateReadedComment&amp;commentId=<?=$comment->getCommentId()?>" class="btn btn-secondary p-1"><i class="fas fa-book-open"></i>Marquer comme lu</a>
                    </td>
                </tr>
                <?php endforeach;?>
            </table>
        </div>
        <?php endif; ?>
    </div>


    <?php elseif (empty($_SESSION['role']) OR $_SESSION['role'] == 'member'):
        header('Location: index.php?action=viewHome');
        exit;
    endif;
endif;
$content = ob_get_clean(); ?>

<?php require('template.php'); ?>