<?php
require_once __DIR__ . '/../includes/config.php'; // Pour session_start()

// Supprimer toutes les variables de session
$_SESSION = [];

// Supprimer le cookie de session (optionnel, pour être propre)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Redirection (modifie selon ta logique)
header('Location: /index.php?page=page_login');
exit;
