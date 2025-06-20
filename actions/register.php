<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des champs
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';

    // Vérifications basiques
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        die('Tous les champs sont obligatoires.');
    }

    // Vérifier que l'email n'existe pas déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        die('Un compte existe déjà avec cette adresse email.');
    }

    // Hash du mot de passe
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Génération du token de validation
    $verify_token = bin2hex(random_bytes(16)); // 32 caractères

    // Insertion du nouvel utilisateur
    $stmt = $pdo->prepare("
        INSERT INTO users (first_name, last_name, email, password, auth_type, is_verified, verify_token, role)
        VALUES (?, ?, ?, ?, 'local', 0, ?, 'utilisateur')
    ");

    $stmt->execute([
        $first_name,
        $last_name,
        $email,
        $password_hash,
        $verify_token
    ]);

    sendVerificationEmail($email, $first_name, $verify_token);
    header("Location: /index.php?page=page_checkmail");
    exit;
}
