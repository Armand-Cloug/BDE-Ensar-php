<?php
require_once 'includes/header.php';
?>

<h1>CON?TACT</h1>

<?php
require_once __DIR__ . '/../includes/header.php';
?>

<h2>Formulaire de contact</h2>

<form method="POST" action="/actions/send_contact.php">
    <label for="nom">Nom :</label><br>
    <input type="text" id="nom" name="nom" required><br><br>

    <label for="prenom">Prénom :</label><br>
    <input type="text" id="prenom" name="prenom" required><br><br>

    <label for="promotion">Promotion :</label><br>
    <input type="text" id="promotion" name="promotion" required><br><br>

    <label for="email">Adresse mail :</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="message">Message :</label><br>
    <textarea id="message" name="message" rows="5" required></textarea><br><br>

    <button type="submit">Envoyer</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>