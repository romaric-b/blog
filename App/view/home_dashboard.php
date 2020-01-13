<?php

$title = 'Tableau de bord : vue d\'ensemble'; ?>

<?php ob_start(); ?>
<?php if (isset($_SESSION)): ?>
    <?php if(!empty($_SESSION['role']) AND $_SESSION['role'] == 'administrator'): ?>
    <div class="bg-light full-vh container">
        <div class="text-center  mb-4">
            <h2>Tableau de bord</h2>
        <p>Bonjour Jean Forteroche et bienvenu sur votre tableau de bord</p>


        <section class="admin-report text-center marg-top-strong mb-4">
            <h3 class="marg-top-strong">Votre blog en quelques chiffres</h3>
            <ul class="d-flex justify-content-center marg-top-strong">
                <li class="flex-column dashboard_stats--li shadow p-3 bg-secondary text-light">
                    <span class="font-weight-bold stats-number"><?= $totalPosts ?></span>
                    <p class="d-block row marg-auto align-items-center"><i class="fas fa-book"></i> chapitres</p>
                </li>
                <li class="flex-column ml-5 mr-5 dashboard_stats--li shadow p-3 bg-secondary text-light">
                    <span class="font-weight-bold stats-number"><?= $totalComments ?></span>
                    <p class="d-block row marg-auto align-items-center"><i class="far fa-comment"></i> commentaires</p>
                </li>
                <li class="flex-column dashboard_stats--li shadow p-3 bg-secondary text-light">
                    <span class="font-weight-bold stats-number"><?= $totalMembers ?></span>
                    <p class="d-block row marg-auto align-items-center"><i class="fas fa-user"></i> membres</p>
                </li>
            </ul>

            <button class="btn btn-primary marg-top-strong" type="button" data-toggle="collapse" data-target="#create_post" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-pencil-alt"></i>
                Écrire un nouveau chapitre
            </button>
            <div id="create_post" class="creation_post--section marg-h border-top border-bottom collapse">
                <form action="index.php?action=createPost" method="POST" class="d-flex marg-auto flex-column w-80">
                    <label class="marg-bot-small marg-top-strong" for="post_title">Titre :
                        <input id="post_title" name="createTitle" id="title">
                    </label>
                    <label class="marg-bot-small"  for="post_extract">Rédigez un extrait de votre chapitre :
                        <textarea class="tinymce-edition marg-top" id="post_extract" name="createExtract">
                        </textarea>
                    </label>
                    <label class="marg-bot-small"  for="post_content">Rédigez le contenu de votre chapitre :
                        <textarea class="tinymce-edition marg-top" id="post_content" name="createContent">
                        </textarea>
                    </label>
                    <p>
                        <input type="submit" class="btn btn-primary text-light" value="Valider ce chapitre"/>
                    </p>
                </form>
            </div>


            <h3 class="marg-top-strong">Les derniers commentaires signalés</h3>
            <?php if(empty($signaledComments) OR $signaledComments == NULL): ?>
                <p>Aucun commentaire signalé</p>

            <?php elseif(!empty($signaledComments)): ?>
             <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="text-center bg-light table-striped table-borderless table-responsive table w-100 d-block d-sm-table d-md-table">
                    <thead class="thead-dark">
                    <tr>
                        <th>Tire du chapitre</th>
                        <th>Date</th>
                        <th>Auteur</th>
                        <th>Commentaire</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <?php foreach ($signaledComments as $signaledComment): ?>
                        <tr>
                            <td><?= htmlspecialchars($signaledComment->getPostTitle())?></td>
                            <td><?=$signaledComment->getCommentDate()?></td>
                            <td><?=$signaledComment->getAuthor()?></td>
                            <td><?= htmlspecialchars($signaledComment->getCommentContent())?></td>
                            <td class="btn-group" role="group" aria-label="actions">
                                <a class="btn btn-danger" data-toggle="modal" data-target="#delete-modal"  href="#"><i class="far fa-edit"></i>Effacer commentaire</a>
                                <a href="index.php?action=unsignalReadedComment&commentId=<?=$signaledComment->getCommentId()?>" class="btn btn-secondary p-1"><i class="far fa-comment"></i>Annuler signalement</a>
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
                            <button type="button" id="close-login-modal" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="index.php?action=login" method="POST">
                                <p>
                                    Etes vous sûr de vouloir supprimer ce commentaire ?
                                </p>
                                <p>
                                    <a href="index.php?action=deleteComment&commentId=<?=$signaledComment->getCommentId()?>" class="btn btn-danger p-1"><i class="far fa-trash-alt"></i>Effacer commentaire</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

                <?php endif; ?>

            </section>
     </div>
    <?php elseif (empty($_SESSION['role']) OR $_SESSION['role'] == 'member'):

        header('Location: index.php?action=viewHome');
        exit;
    endif;
endif;

$content = ob_get_clean(); ?>

<?php require('template.php'); ?>