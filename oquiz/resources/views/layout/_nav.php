<nav class="navbar navbar-toggleable-md navbar-light bg-faded">

    <ul class="nav mr-auto">
    <a class="nav-link d-inline" href="<?= route('quiz_list'); ?>">
        <h1>
            O'Quiz
        </h1>
    </a>
    </ul>

    <ul class="nav nav-pills justify-content-end">
    <li class="nav-item">
        <a class="nav-link active" href="<?= route('quiz_list'); ?>">
        <i class="fas fa-home"></i>
        Accueil
        </a>
    </li>
    <!-- AUTHENT 7 - test sur user authentifié ou non -> data globale vues -->
    <?php if($isConnected): ?>


        <li class="nav-item">
             <!-- WIP page profil-->
            <a class="nav-link" href="<?= route('user_profile'); ?>">
                <i class="fas fa-user-cog"></i>
                <?= $currentUser->firstname . ' ' . $currentUser->lastname ?>
            </a>
        </li>

        <!-- ADMINISTRATION CONTENU - nav admin (cf passage global parametre Controller.php) -->
        <!-- note: $currentUser contient un utilisateurs retourné par le model User) -->
        <?php if($isAdmin): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= route('admin_quiz_list'); ?>">
                <i class="fas fa-unlock-alt"></i>
                    Admininistration
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item">
             <!-- LOGOUT 8 - link -->
            <a class="nav-link" href="<?= route('user_logout'); ?>">
                <i class="fas fa-sign-out-alt"></i>
                Déconnexion
            </a>
        </li>

    <?php else: ?>

        <li class="nav-item">
            <a class="nav-link" href="<?= route('user_signin'); ?>">
                <i class="fas fa-user"></i>
                Connexion
            </a>
        </li>

    <?php endif; ?>

    </ul>
</nav>