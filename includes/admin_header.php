<?php
// Définir un titre par défaut si non fourni
if (!isset($pageTitle)) {
    $pageTitle = "ADMIN - BDE ENSAR";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Cloug">
    <meta name="description" content="Site officiel du BDE ENSAR – Niort">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="date" content="<?= date('Y-m-d') ?>">
    <meta name="copyright" content="ADMIN - BDE ENSAR">

    <title><?= htmlspecialchars($pageTitle) ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/logo_bde_1.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

    <!-- CSS principal -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<?php 
require_once __DIR__ . '/admin_navbar.php';
require_once __DIR__ . '/functions.php';


if (!allow_env_role_access()) {
    echo "<p>Accès réservé.</p>";
    exit();
}
?>