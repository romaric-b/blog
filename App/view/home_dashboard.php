<?php

$title = 'Tableau de bord : vue d\'ensemble'; ?>

<?php ob_start(); ?>
<?php if (isset($_SESSION)): ?>
    <?php if(!empty($_SESSION['role']) AND $_SESSION['role'] == 'administrator'): ?>
        <div class="text-center  mb-4">
            <h1>Panneau d'administration</h1>
        <p>Bonjour Jean Forteroche et bienvenu sur votre tableau de bord</p>
        <section>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#create_post" aria-expanded="false" aria-controls="collapseExample">
                Ecrire un nouvel article
            </button>
        </section>
        <section id="create_post" class="creation_post--section collapse">
            <form action="index.php?action=createPost" method="POST" class="flex-column">
                <label for="post_title">Titre :
                    <input id="post_title" name="createTitle" id="title">
                </label>
                <label for="post_extract">Rédigez un extrait de votre article :
                    <textarea class="tinymce-edition" id="post_extract" name="createExtract">
                        </textarea>
                </label>
                <label for="post_content">Rédigez le contenu de votre article :
                    <textarea class="tinymce-edition" id="post_content" name="createContent">
                        </textarea>
                </label>
                <p>
                    <input type="submit"  value="Valider"/>
                </p>
            </form>
        </section>

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
                    <th>Action</th>
                </tr>
                </thead>

                <?php foreach ($signaledComments as $signaledComment): ?>

                    <tr>
                        <td><?= htmlspecialchars($signaledComment->getPostTitle())?></td>
                        <td><?=$signaledComment->getAuthor()?></td>
                        <td><?= htmlspecialchars($signaledComment->getCommentContent())?></td>
                        <td class="btn-group" role="group" aria-label="actions">
                            <a href="index.php?action=deleteComment&commentId=<?=$signaledComment->getCommentId()?>" class="btn btn-danger p-1">Effacer commentaire</a>
                            <a href="index.php?action=unsignalReadedComment&commentId=<?=$signaledComment->getCommentId()?>" class="btn btn-secondary p-1">Annuler signalement</a>
                        </td>
                    </tr>

                <?php endforeach;?>
                <?php endif;?>

            </table>
        </section>


    <?php elseif (empty($_SESSION['role']) OR $_SESSION['role'] == 'member'):
        header('Location: index.php?action=viewHome');
        exit;
    endif;
endif;
$content = ob_get_clean(); ?>

<?php require('template.php'); ?>