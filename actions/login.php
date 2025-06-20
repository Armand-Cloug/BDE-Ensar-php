<?php
require_once __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        die('Veuillez remplir tous les champs.');
    }

    // 🔍 Rechercher l’utilisateur par email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND auth_type = 'local'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
        die('Email ou mot de passe incorrect.');
    }

    if (!$user['is_verified']) {
        die('Veuillez valider votre adresse email avant de vous connecter.');
    }

    // ✅ Authentification réussie → stocker toutes les infos utiles
    $_SESSION['user'] = [
        'id'           => $user['id'],
        'first_name'   => $user['first_name'],
        'last_name'    => $user['last_name'],
        'promotion'    => $user['promotion'],
        'birthdate'    => $user['birthdate'],
        'company'      => $user['company'],
        'email'        => $user['email'],
        'role'         => $user['role'],
        'is_adherent'  => $user['is_adherent'], // <- Ajout ici
        'auth_type'    => $user['auth_type'],
        'is_verified'  => $user['is_verified'],
        'created_at'   => $user['created_at']
    ];

    header('Location: /index.php?page=accueil');
    exit;
}
