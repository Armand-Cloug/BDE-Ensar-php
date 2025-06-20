<?php
require_once 'includes/header.php';

if (!isset($_SESSION['user'])) {
    echo "<p>Veuillez vous connecter pour faire une demande.</p>";
    require_once 'includes/footer.php';
    exit();
}

$role = $_SESSION['user']['role'] ?? null;

if ($role === 'alumni') {
    echo "<p>✅ Vous êtes déjà alumni. Aucune action supplémentaire n'est nécessaire.</p>";
    require_once 'includes/footer.php';
    exit();
}

if ($role === 'admin') {
    echo "<p>ℹ️ En tant qu'administrateur, vous ne pouvez pas faire de demande alumni.</p>";
    require_once 'includes/footer.php';
    exit();
}

// Vérifier si une demande a déjà été faite
require_once 'includes/database.php';

$user_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT statut FROM alumni_requests WHERE user_id = ?");
$stmt->execute([$user_id]);
$request = $stmt->fetch();

if ($request) {
    echo "<p>📄 Vous avez déjà soumis une demande alumni. Statut : <strong>" . htmlspecialchars($request['statut']) . "</strong></p>";
    require_once 'includes/footer.php';
    exit();
}
?>

<h2>Demande d'adhésion Alumni</h2>

<form action="actions/post_alumni_request.php" method="POST">
    <label for="diplome">Diplôme obtenu :</label><br>
    <input type="text" name="diplome" id="diplome" required><br><br>

    <label for="annee">Année d'obtention :</label><br>
    <input type="number" name="annee" id="annee" min="1900" max="2099" required><br><br>

    <button type="submit">Envoyer la demande</button>
</form>

<?php require_once 'includes/footer.php'; ?>


