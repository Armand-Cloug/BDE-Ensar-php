<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>Créer un compte</h2>

<form action="/actions/register.php" method="post">
    <label for="first_name">Prénom :</label><br>
    <input type="text" id="first_name" name="first_name" required><br><br>

    <label for="last_name">Nom :</label><br>
    <input type="text" id="last_name" name="last_name" required><br><br>

    <label for="email">Adresse email :</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Créer mon compte</button>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
