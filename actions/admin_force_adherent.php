<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!allow_env_role_access()) {
    echo "<p>Accès réservé.</p>";
    exit();
}

// Vérifie que l'ID utilisateur est bien passé et numérique
if (!isset($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
    header('Location: /index.php?page=admin&error=not_found');
    exit();
}

$user_id = (int) $_POST['user_id'];

try {
    // Vérifie que l'utilisateur existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        header('Location: /index.php?page=admin&error=not_found');
        exit();
    }

    // Met à jour le champ is_adherent à TRUE
    $update = $pdo->prepare("UPDATE users SET is_adherent = TRUE WHERE id = ?");
    $update->execute([$user_id]);

    header('Location: /index.php?page=admin&success=force_adherent');
    exit();
} catch (PDOException $e) {
    header('Location: /index.php?page=admin&error=db');
    exit();
}
