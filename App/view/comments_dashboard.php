<?php
$title = 'Tableau de bord : Commentaires'; ?>

<?php ob_start(); ?>
<?php if (isset($_SESSION)): ?>
    <?php if(!empty($_SESSION['role']) AND $_SESSION['role'] == 'administrator'): ?>
    <div class="bg-light container">
        <h1>Gestion des commentaires</h1>
        <div class="d-flex marg-top-strong flex-column">
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
                        <a class="btn btn-danger" data-toggle="modal" data-target="#delete-modal"  href="#"><i class="far fa-trash-alt"></i>Effacer commentaire</a>
                        <a href="index.php?action=unsignalReadedComment&amp;commentId=<?=$comment->getCommentId()?>" class="btn btn-secondary p-1"><i class="fas fa-undo"></i>Annuler signalement</a>
                        <a href="index.php?action=updateReadedComment&amp;commentId=<?=$comment->getCommentId()?>" class="btn btn-danger p-1"><i class="fas fa-book-open"></i>Marquer comme lu</a>
                    </td>
                </tr>
                <?php endforeach;?>
            </table>
        </div>
        <!--delete Modal-->
        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Connexion</h5>
                        <button type="button" id="close-login-modal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="index.php?action=login" method="POST">
                            <p>
                                Êtes-vous sûr de vouloir Effacer ce commentaire ?
                            </p>
                            <p>
                                <a href="index.php?action=deleteComment&commentId=<?=$comment->getCommentId()?>" class="btn btn-danger p-1"><i class="far fa-trash-alt"></i>Effacer commentaire</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php elseif (empty($_SESSION['role']) OR $_SESSION['role'] == 'member'):
        header('Location: index.php?action=viewHome');
        exit;
    endif;
endif;
$content = ob_get_clean(); ?>

<?php require('template.php'); ?>