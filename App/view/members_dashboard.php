<?php
$title = 'Tableau de bord : Membres'; ?>

<?php ob_start(); ?>
<?php if (isset($_SESSION)): ?>
    <?php if(!empty($_SESSION['role']) AND $_SESSION['role'] == 'administrator'): ?>
        <section class="admin-report text-center container full-vh bg-light mb-4">
            <h1 class="marg-bot">Gestion de vos membres</h1>
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
                                <?php $_SESSION['user' . $user->getUserId()] = $user;
                                ?>
                                <a href="index.php?action=banUser&amp;userId=<?=$user->getUserId()?>" class="btn btn-danger p-1"><i class="fas fa-user-alt-slash"></i>Bannir membre</a>
                            </td>
                        </tr>
                            <?php endif;?>
                    <?php endforeach;?>
                </table>
            </div>

        </section>
    <?php elseif (empty($_SESSION['role']) OR $_SESSION['role'] == 'member'):
        header('Location: index.php?action=viewHome');
        exit;
    endif;
endif;
$content = ob_get_clean(); ?>

<?php require('template.php'); ?>