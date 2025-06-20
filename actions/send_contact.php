
<?php

// 🔒 Sécurité basique
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /index.php?page=contact');
    exit();
}

// 📨 Récupération des champs
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$promotion = trim($_POST['promotion'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// 🔍 Vérification
if ($nom && $prenom && $promotion && $email && $message) {
    $to = 'bde.ensar.contact@gmail.com';
    $subject = "Demande de contact de $prenom $nom ($promotion)";
    $body = "Nom : $nom\nPrénom : $prenom\nPromotion : $promotion\nEmail : $email\n\nMessage :\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        header('Location: /index.php?page=contact&success=1');
        exit();
    } else {
        header('Location: /index.php?page=contact&error=send');
        exit();
    }
} else {
    header('Location: /index.php?page=contact&error=fields');
    exit();
}
