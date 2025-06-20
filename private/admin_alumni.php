<?php
require_once __DIR__ . '/../includes/admin_header.php';
require_once __DIR__ .'/../includes/config.php';

// Récupération des demandes
$stmt = $pdo->query("
    SELECT r.id, u.email, r.diplome, r.annee, r.statut, r.date_demande, r.user_id
    FROM alumni_requests r
    JOIN users u ON u.id = r.user_id
    ORDER BY r.date_demande DESC
");
$demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Demandes d'adhésion Alumni</h2>

<?php if (empty($demandes)): ?>
    <p>Aucune demande pour le moment.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Utilisateur</th>
            <th>Diplôme</th>
            <th>Année</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($demandes as $demande): ?>
            <tr>
                <td><?= htmlspecialchars($demande['email']) ?></td>
                <td><?= htmlspecialchars($demande['diplome']) ?></td>
                <td><?= htmlspecialchars($demande['annee']) ?></td>
                <td><?= htmlspecialchars($demande['statut']) ?></td>
                <td><?= htmlspecialchars($demande['date_demande']) ?></td>
                <td>
                    <?php if ($demande['statut'] === 'en_attente'): ?>
                        <form action="../actions/admin_validate_alumni.php" method="POST" style="display:inline;">
                            <input type="hidden" name="request_id" value="<?= $demande['id'] ?>">
                            <input type="hidden" name="user_id" value="<?= $demande['user_id'] ?>">
                            <input type="hidden" name="action" value="valider">
                            <button type="submit">✅ Accepter</button>
                        </form>
                        <form action="../actions/admin_validate_alumni.php" method="POST" style="display:inline;">
                            <input type="hidden" name="request_id" value="<?= $demande['id'] ?>">
                            <input type="hidden" name="action" value="refuser">
                            <button type="submit">❌ Refuser</button>
                        </form>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php 
require_once __DIR__ . '/../includes/footer.php';
?>
