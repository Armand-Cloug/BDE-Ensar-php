<?php
require_once __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $annee = trim($_POST['annee'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($annee) || empty($description)) {
        die("⛔ Tous les champs sont requis.");
    }

    if (!preg_match('/^\d{4}$/', $annee)) {
        die("⛔ Format d’année invalide. Utilisez AAAA.");
    }

    // Vérifie que le BDE n'existe pas déjà
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM bde_info WHERE annee = ?");
    $stmt->execute([$annee]);
    if ($stmt->fetchColumn() > 0) {
        header("Location: /index.php?page=admin_bde&success=duplicate");
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Désactive tous les anciens BDE
        $pdo->exec("UPDATE bde_info SET is_active = FALSE");

        // Insère le nouveau BDE et l’active
        $stmt = $pdo->prepare("INSERT INTO bde_info (annee, description, is_active) VALUES (?, ?, TRUE)");
        $stmt->execute([$annee, $description]);

        $pdo->commit();

        header("Location: /index.php?page=admin_bde&success=created");
        exit;
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Erreur SQL : " . $e->getMessage());
        header("Location: /index.php?page=admin_bde&error=sql");
        exit;
    }
} else {
    http_response_code(405);
    echo "Méthode non autorisée.";
}
