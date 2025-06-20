<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Charger les variables depuis la racine
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0 || strpos($line, '=') === false) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}

$stripeKey = getenv('STRIPE_SECRET_KEY');
if (!$stripeKey) {
    die("Clé secrète Stripe non définie !");
}

\Stripe\Stripe::setApiKey($stripeKey);
