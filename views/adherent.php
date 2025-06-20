<?php
include __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user'])) {
    echo "<p>Veuillez vous connecter pour devenir adhérent.</p>";
    require_once 'includes/footer.php';
    exit();
}

// 🔄 Synchronisation du rôle en base après paiement
if (isset($_GET['success']) && isset($_SESSION['user']['id'])) {
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user']['id']]);
    $newRole = $stmt->fetchColumn();
    if ($newRole && $newRole !== $_SESSION['user']['role']) {
        $_SESSION['user']['role'] = $newRole;
    }
}

// ✅ Récupération du rôle courant
$role = $_SESSION['user']['role'];
?>

<h2>Devenir adhérent</h2>

<?php if ($role === 'adherent'): ?>
    <p>✅ Vous êtes déjà adhérent du BDE ENSAR. Merci pour votre soutien !</p>
<?php else: ?>
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">✅ Paiement réussi. Vous êtes maintenant adhérent !</p>
    <?php elseif (isset($_GET['cancel'])): ?>
        <p style="color: red;">❌ Paiement annulé. Vous pouvez réessayer ci-dessous.</p>
    <?php endif; ?>

    <p>Pour devenir adhérent du BDE ENSAR, un paiement unique de 5€ est requis.</p>

    <form action="actions/checkout_adherent.php" method="POST">
        <button type="submit">Payer 5 €</button>
    </form>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>

