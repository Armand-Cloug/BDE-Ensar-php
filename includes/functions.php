<?php

function sendVerificationEmail(string $email, string $firstName, string $token): bool
{
    $subject = "Validation de votre compte BDE ENSAR";
    
    $verifyUrl = "https://dev.bde-ensar.cloug.fr/actions/verify.php?token=$token";

    $message = "
    <html>
    <head>
        <title>Validation de votre compte</title>
    </head>
    <body>
        <p>Bonjour " . htmlspecialchars($firstName) . ",</p>
        <p>Merci de vous être inscrit. Pour activer votre compte, veuillez cliquer sur le lien ci-dessous :</p>
        <p><a href=\"$verifyUrl\">Activer mon compte</a></p>
        <p>Ou copiez-collez ce lien dans votre navigateur :</p>
        <p>$verifyUrl</p>
        <br>
        <p>Cordialement,<br>L'équipe du BDE ENSAR</p>
    </body>
    </html>
    ";

    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: armandzireg@gmail.com\r\n";

    return mail($email, $subject, $message, $headers);
}

function allow_env_role_access(): bool {
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])) {
        return false;
    }

    $envPath = __DIR__ . '/../.env';
    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0 || strpos($line, '=') === false) continue;
            list($name, $value) = explode('=', $line, 2);
            putenv(trim($name) . '=' . trim($value));
        }
    }

    $allowed_role = getenv('ADMIN_ACCESS_ROLE') ?: 'admin';

    if ($allowed_role === 'all') {
        return true; // Tous les rôles autorisés
    }

    return $_SESSION['user']['role'] === $allowed_role;
}

?>