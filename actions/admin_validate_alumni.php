<?php
require_once __DIR__ .'/../includes/config.php';
require_once __DIR__ .'/../includes/functions.php';

if (!allow_env_role_access()) {
    echo "<p>Accès réservé.</p>";
    exit();
}

$request_id = $_POST['request_id'] ?? null;
$user_id = $_POST['user_id'] ?? null;
$action = $_POST['action'] ?? null;

if (!$request_id || !$action) {
    header('Location: /index.php?page=admin_alumni&error=param');
    exit();
}

if ($action === 'valider' && $user_id) {
    // 1. Valider la demande
    $stmt = $pdo->prepare("UPDATE alumni_requests SET statut = 'valide' WHERE id = ?");
    $stmt->execute([$request_id]);

    // 2. Mettre à jour le rôle utilisateur
    $stmt = $pdo->prepare("UPDATE users SET role = 'alumni' WHERE id = ?");
    $stmt->execute([$user_id]);

} elseif ($action === 'refuser') {
    $stmt = $pdo->prepare("UPDATE alumni_requests SET statut = 'refuse' WHERE id = ?");
    $stmt->execute([$request_id]);
}

header('Location: /index.php?page=admin_alumni');
exit();
