<?php
session_start();
include __DIR__ . '/../includes/stripe.php';

if (!isset($_SESSION['user'])) {
    header('Location: /index.php?page=accueil');
    exit();
}

// Récupérer le nom de domaine depuis .env
$domain = rtrim(getenv('DOMAIN_NAME'), '/'); // supprime éventuel slash final

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Adhésion BDE ENSAR',
            ],
            'unit_amount' => 500,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $domain . '/index.php?page=adherent&success=true',
    'cancel_url' => $domain . '/index.php?page=adherent&cancel=true',
    'metadata' => [
        'user_id' => $_SESSION['user']['id']
    ]
]);

header("Location: " . $checkout_session->url);
exit();
