<?php
$title = 'Tableau de bord : Membres'; ?>

<?php ob_start(); ?>
<?php if (isset($_SESSION)): ?>
    <?php if(!empty($_SESSION['role']) AND $_SESSION['role'] == 'administrator'): ?>
        <section class="admin-report text-center container bg-light mb-4">
            <h1>Gestion de vos membres</h1>
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="text-center table-striped table-borderless table-responsive table w-100 d-block d-sm-table d-md-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Pseudo</th>
                            <th>Date d'inscription</th>
                            <th>adresse email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <?php if($user->getRole() == 'member') :?>
                            <td><?= htmlspecialchars($user->getNickname())?></td>
                            <td><?=$user->getRegistDate()?></td>
                            <td><?= htmlspecialchars($user->getEmail())?></td>
                            <td class="btn-group" role="group" aria-label="actions">
                                <a class="btn btn-danger" data-toggle="modal" data-target="#delete-modal"  href="#"><i class="fas fa-user-alt-slash"></i>Bannir membre</a>
                            </td>
                        </tr>
                            <?php endif;?>
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
                                    Êtes-vous sûr de vouloir bannir ce membre ?
                                </p>
                                <p>
                                    <a href="index.php?action=banUser&userId=<?=$user->getUserId()?>" class="btn btn-danger p-1"><i class="fas fa-user-alt-slash"></i>Bannir membre</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    <?php elseif (empty($_SESSION['role']) OR $_SESSION['role'] == 'member'):
        header('Location: index.php?action=viewHome');
        exit;
    endif;
endif;
$content = ob_get_clean(); ?>

<?php require('template.php'); ?>