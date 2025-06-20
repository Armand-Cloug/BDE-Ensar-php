<?php
require_once __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification de la présence du champ
    if (!isset($_POST['active_bde']) || empty($_POST['active_bde'])) {
        die("⛔ Veuillez sélectionner un BDE à activer.");
    }

    $activeBdeId = (int) $_POST['active_bde'];

    // Vérifier que l'ID existe réellement dans la table
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM bde_info WHERE id = ?");
    $stmt->execute([$activeBdeId]);
    if ($stmt->fetchColumn() == 0) {
        die("⛔ BDE introuvable.");
    }

    // 🔄 Réinitialiser tous les BDE comme inactifs
    $pdo->exec("UPDATE bde_info SET is_active = 0");

    // ✅ Activer celui sélectionné
    $stmt = $pdo->prepare("UPDATE bde_info SET is_active = 1 WHERE id = ?");
    $stmt->execute([$activeBdeId]);

    // 🔁 Redirection avec message de succès
    header("Location: /index.php?page=admin_bde&success=active_set");
    exit;
} else {
    http_response_code(405);
    echo "Méthode non autorisée.";
}
