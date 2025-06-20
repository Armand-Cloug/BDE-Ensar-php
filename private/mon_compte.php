<?php
require_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user'])) {
    echo "<p>Vous devez être connecté pour accéder à cette page.</p>";
    require_once __DIR__ . '/../includes/footer.php';
    exit();
}

$user = $_SESSION['user'];
?>

<h2>Mon profil</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr><th>ID</th><td><?= htmlspecialchars($user['id']) ?></td></tr>
    <tr><th>Prénom</th><td><?= htmlspecialchars($user['first_name']) ?></td></tr>
    <tr><th>Nom</th><td><?= htmlspecialchars($user['last_name']) ?></td></tr>
    <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
    <tr><th>Promotion</th><td><?= htmlspecialchars($user['promotion'] ?? 'Non renseignée') ?></td></tr>
    <tr><th>Date de naissance</th><td><?= htmlspecialchars($user['birthdate'] ?? 'Non renseignée') ?></td></tr>
    <tr><th>Entreprise</th><td><?= htmlspecialchars($user['company'] ?? 'Non renseignée') ?></td></tr>
    <tr><th>Type d’authentification</th><td><?= htmlspecialchars($user['auth_type']) ?></td></tr>
    <tr><th>Compte vérifié</th><td>✅ Oui</td></tr>
    <tr><th>Rôle</th><td><?= htmlspecialchars($user['role']) ?></td></tr>
    <tr><th>Date de création</th><td><?= htmlspecialchars($user['created_at'] ?? 'Non disponible') ?></td></tr>
</table>

<p>
    🔒 <a href="/index.php?page=modifier_mdp">Modifier mon mot de passe</a><br>
    ❌ <a href="/actions/destroy.php" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">Supprimer mon compte</a><br>
    🚪 <a href="/actions/logout.php">Se déconnecter</a>
</p>

<?php
require_once __DIR__ . '/../includes/footer.php';
