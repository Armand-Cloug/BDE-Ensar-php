<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>Connexion</h2>

<form action="/actions/login.php" method="post">
    <label for="email">Adresse email :</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>
</form>

<p>Pas encore de compte ? <a href="/index.php?page=page_register">Créer un compte</a></p>

<?php include __DIR__ . '/../includes/footer.php'; ?>
