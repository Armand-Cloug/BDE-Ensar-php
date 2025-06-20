<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/admin_header.php';

// 🔍 Récupération des colonnes de la table users
$columns = $pdo->query("SHOW COLUMNS FROM users")->fetchAll(PDO::FETCH_COLUMN);

// 🔧 Colonne sélectionnée
$extraColumn = $_GET['champ'] ?? 'role';
$extraColumn = in_array($extraColumn, $columns) ? $extraColumn : 'role';

// 📦 Requête pour tous les utilisateurs avec id + colonne dynamique
$stmt = $pdo->query("SELECT id, first_name, last_name, email, `$extraColumn` FROM users ORDER BY last_name ASC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des utilisateurs</h2>

<!-- 🎛️ Sélecteur de colonne -->
<form method="GET" action="/index.php">
    <input type="hidden" name="page" value="admin_utilisateurs">
    <label for="champ">Afficher aussi :</label>
    <select name="champ" id="champ" onchange="this.form.submit()">
        <?php foreach ($columns as $col): ?>
            <option value="<?= $col ?>" <?= $col === $extraColumn ? 'selected' : '' ?>>
                <?= htmlspecialchars($col) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<!-- 📋 Tableau -->
<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th><?= htmlspecialchars($extraColumn) ?></th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['last_name']) ?></td>
            <td><?= htmlspecialchars($user['first_name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user[$extraColumn]) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
