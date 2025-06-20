<?php
require_once __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des champs obligatoires
    if (
        empty($_POST['bde_id']) ||
        empty($_POST['nom']) ||
        empty($_POST['role']) ||
        empty($_POST['description']) ||
        empty($_FILES['photo'])
    ) {
        die("⛔ Tous les champs sont requis.");
    }

    $bde_id = (int) $_POST['bde_id'];
    $nom = trim($_POST['nom']);
    $role = trim($_POST['role']);
    $description = trim($_POST['description']);

    // Gérer l'upload de l'image
    $photo = $_FILES['photo'];
    $uploadDir = __DIR__ . '/../assets/images/upload/';

    // 1️⃣ Vérifier que c’est bien une image
    $imageInfo = getimagesize($photo['tmp_name']);
    if ($imageInfo === false) {
        die("⛔ Le fichier n'est pas une image valide.");
    }

    // 2️⃣ Vérifier l’extension autorisée
    $ext = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png'];
    if (!in_array($ext, $allowedExt)) {
        die("⛔ Extension non autorisée (jpg, jpeg, png uniquement).");
    }

    // Générer un nom de fichier sécurisé
    $filename = uniqid('bde_', true) . '.' . $ext;
    $targetPath = $uploadDir . $filename;

    // Déplacer le fichier
    if (!move_uploaded_file($photo['tmp_name'], $targetPath)) {
        die("⛔ Erreur lors de l'envoi de la photo.");
    }

    // Enregistrement en base
    $stmt = $pdo->prepare("INSERT INTO bde_membres (bde_id, nom, role, description, photo) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$bde_id, $nom, $role, $description, $filename]);

    // Redirection
    header("Location: /index.php?page=admin_bde&success=member_added");
    exit;
} else {
    http_response_code(405);
    echo "Méthode non autorisée.";
}
