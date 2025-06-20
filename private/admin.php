<?php
require_once __DIR__ . '/../includes/admin_header.php';
?>

<h1>ADMIN</h1>

<section>
    <h2>Attribuer le rôle Adhérent manuellement</h2>

    <form action="../actions/admin_force_adherent.php" method="POST">
        <label for="user_id">ID de l'utilisateur :</label><br>
        <input type="number" name="user_id" id="user_id" required><br><br>

        <button type="submit">Donner le rôle Adhérent</button>
    </form>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'force_adherent'): ?>
        <p style="color: green;">✅ Rôle adhérent attribué avec succès.</p>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === 'not_found'): ?>
        <p style="color: red;">❌ Utilisateur introuvable.</p>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === 'db'): ?>
        <p style="color: red;">❌ Erreur base de données.</p>
    <?php endif; ?>
</section>

<section>
    <h2>Réinitialisation des adhérents</h2>
    <form action="../actions/admin_reset_all_adherents.php" method="POST" onsubmit="return confirm('⚠️ Cette action va retirer le statut d\'adhérent à tous les utilisateurs et créer un dump SQL. Continuer ?');">
        <button type="submit" style="background-color: darkred; color: white;">Réinitialiser tous les statuts d’adhérents</button>
    </form>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'reset_adherents'): ?>
        <p style="color: green;">✅ Tous les statuts d’adhérents ont été réinitialisés. Un dump a été généré.</p>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === 'dump'): ?>
        <p style="color: red;">❌ Erreur lors du dump de la base.</p>
    <?php endif; ?>
</section>


<?php
require_once 'includes/footer.php';