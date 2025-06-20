<?php
require_once 'includes/header.php';
?>

<h1>ANAL</h1>

<p>Cette page affiche les informations de session (mode débogage).</p>

<h2>🧾 Infos de session</h2>
<?php if (isset($_SESSION['user'])): ?>
    <ul>
        <li><strong>ID :</strong> <?= htmlspecialchars($_SESSION['user']['id']) ?></li>
        <li><strong>Email :</strong> <?= htmlspecialchars($_SESSION['user']['email']) ?></li>
        <li><strong>Rôle :</strong> <?= htmlspecialchars($_SESSION['user']['role']) ?></li>
    </ul>
<?php else: ?>
    <p>Aucun utilisateur connecté.</p>
<?php endif; ?>

<h2>🧰 Données complètes $_SESSION</h2>
<pre><?php print_r($_SESSION); ?></pre>

<?php
require_once 'includes/footer.php';