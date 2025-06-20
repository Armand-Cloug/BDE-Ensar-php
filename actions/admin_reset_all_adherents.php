<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!allow_env_role_access()) {
    echo "<p>Accès réservé.</p>";
    exit();
}

try {
    // 🧹 Réinitialiser tous les statuts d'adhérents
    $stmt = $pdo->prepare("UPDATE users SET is_adherent = FALSE");
    $stmt->execute();

    header('Location: /index.php?page=admin&success=reset_adherents');
    exit();
} catch (PDOException $e) {
    header('Location: /index.php?page=admin&error=db');
    exit();
}
