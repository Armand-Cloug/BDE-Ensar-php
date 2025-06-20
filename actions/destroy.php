<?php
require_once __DIR__ . '/../includes/config.php';

if (!isset($_SESSION['user'])) {
    header('Location: /index.php?page=accueil');
    exit();
}

$user_id = $_SESSION['user']['id'];

// Supprimer l'utilisateur de la base
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);

// Supprimer les éventuelles requêtes liées (optionnel si ON DELETE CASCADE est déjà en base)
$pdo->prepare("DELETE FROM alumni_requests WHERE user_id = ?")->execute([$user_id]);

// Détruire la session
session_unset();
session_destroy();

// Redirection vers accueil
header('Location: /index.php?page=accueil');
exit();
