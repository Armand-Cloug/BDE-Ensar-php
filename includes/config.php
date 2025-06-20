<?php
// ⚙️ Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 📦 Chargement des variables d'environnement (fichier non versionné)
$env = parse_ini_file(__DIR__ . '/../database/db.env');

// 🔐 Connexion PDO à la base de données
try {
    $pdo = new PDO(
        "mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']};charset=utf8mb4",
        $env['DB_USER'],
        $env['DB_PASS']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
