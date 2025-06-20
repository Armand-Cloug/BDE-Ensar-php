<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page = $_GET['page'] ?? 'accueil';

$public_page  = __DIR__ . '/views/' . $page . '.php';
$private_page = __DIR__ . '/private/' . $page . '.php';

// 🔓 Page publique
if (file_exists($public_page)) {
    include $public_page;

// 🔐 Page privée
} elseif (file_exists($private_page)) {
    // Vérifie que l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        header('Location: /index.php?page=page_login');
        exit;
    }

    // 🔒 Protection "anal" → dépend de is_adherent (et plus du role)
    if ($page === 'anal' && empty($_SESSION['user']['is_adherent'])) {
        die("Accès réservé aux adhérents.");
    }

    // 🔒 Protection "admin*" → via fonction + var env
    if (str_starts_with($page, 'admin') && !allow_env_role_access()) {
        die("Accès réservé.");
    }

    include $private_page;

// ❌ Page inconnue
} else {
    include __DIR__ . '/views/404.php';
}
