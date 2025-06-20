<?php
require_once __DIR__ . '/../includes/config.php';

$token = $_GET['token'] ?? null;

if (!$token) {
    die('Lien invalide ou token manquant.');
}

// Vérifie si un utilisateur correspond à ce token
$stmt = $pdo->prepare("SELECT id FROM users WHERE verify_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('Ce lien de vérification est invalide ou a déjà été utilisé.');
}

// Met à jour l'utilisateur : vérifié + suppression du token
$stmt = $pdo->prepare("UPDATE users SET is_verified = 1, verify_token = NULL WHERE id = ?");
$stmt->execute([$user['id']]);

header("Location: /index.php?page=page_verify");
exit;
