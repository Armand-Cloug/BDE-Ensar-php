<?php
include __DIR__ . '/../includes/stripe.php';
include __DIR__ . '/../includes/config.php';

# Lien d'admin Stripe : https://dashboard.stripe.com/test/workbench/overview

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$log_file = __DIR__ . '/../logs/stripe_webhook.log';
file_put_contents($log_file, "[" . date('c') . "] Webhook appelé\n", FILE_APPEND);

$endpoint_secret = getenv('STRIPE_WEBHOOK_SECRET');

$payload = @file_get_contents("php://input");
$sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"] ?? '';

try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

    file_put_contents($log_file, "[" . date('c') . "] Event reçu : " . $event->type . "\n", FILE_APPEND);

    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;
        $user_id = $session->metadata->user_id ?? null;

        file_put_contents($log_file, "user_id reçu : " . $user_id . "\n", FILE_APPEND);

        if ($user_id) {
            $stmt = $pdo->prepare("UPDATE users SET is_adherent = 1 WHERE id = ?");
            $stmt->execute([$user_id]);

            file_put_contents($log_file, "Rôle mis à jour en 'adherent' pour l'user_id : $user_id\n", FILE_APPEND);
        } else {
            file_put_contents($log_file, "Aucun user_id dans les metadata\n", FILE_APPEND);
        }
    }

    http_response_code(200);
} catch (Exception $e) {
    file_put_contents($log_file, "Erreur Stripe Webhook : " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(400);
    exit();
}

