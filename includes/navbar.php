<nav>
    <ul>
        <!-- Toujours visible -->
        <li><a href="/index.php?page=accueil">Accueil</a></li>
        <li><a href="/index.php?page=apropos">À propos</a></li>
        <li><a href="/index.php?page=evenements">Événements</a></li>
        <li><a href="/index.php?page=galerie">Galerie</a></li>
        <li><a href="/index.php?page=contact">Contact</a></li>

        <?php if (isset($_SESSION['user'])): ?>
            <?php
                $user = $_SESSION['user'];
                $isAdherent = !empty($user['is_adherent']) && $user['is_adherent'] == true;
            ?>

            <?php if ($isAdherent): ?>
                <li><a href="/index.php?page=anal">Anal</a></li>
            <?php endif; ?>

            <li><a href="/index.php?page=mon_compte">Mon compte</a></li>
            <li><a href="/actions/logout.php">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="/index.php?page=page_login">Connexion</a></li>
        <?php endif; ?>
        
            <hr>

            <li><a href="/index.php?page=adherent">DEV adherent</a></li>
            <li><a href="/index.php?page=alumni">DEV alumnis</a></li>
            <li><a href="/index.php?page=admin">DEV Admin</a></li>
            <li><a href="/index.php?page=DEV_session">DEV Session</a></li>
    </ul>
</nav>
