<?php
require_once '../includes/config.php';

if (!isset($_SESSION['user'])) {
    header('Location: /index.php?page=accueil');
    exit();
}

$user_id = $_SESSION['user']['id'];
$diplome = $_POST['diplome'] ?? null;
$annee = $_POST['annee'] ?? null;

if (!$diplome || !$annee || !is_numeric($annee)) {
    header('Location: /index.php?page=alumni&error=invalid');
    exit();
}

// Vérifie s’il existe déjà une demande en attente
$stmt = $pdo->prepare("SELECT COUNT(*) FROM alumni_requests WHERE user_id = ? AND statut = 'en_attente'");
$stmt->execute([$user_id]);
if ($stmt->fetchColumn() > 0) {
    header('Location: /index.php?page=become_alumni&error=exists');
    exit();
}

// Insertion de la demande
$stmt = $pdo->prepare("INSERT INTO alumni_requests (user_id, diplome, annee) VALUES (?, ?, ?)");
$stmt->execute([$user_id, $diplome, $annee]);

header('Location: /index.php?page=alumni&success=true');
exit();

