<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/admin_header.php';

$bdes = $pdo->query("SELECT id, annee FROM bde_info ORDER BY annee DESC")->fetchAll(PDO::FETCH_ASSOC);

// Gestion du message de confirmation
$success = $_GET['success'] ?? null;
?>

<h1>Gestion des BDE</h1>

<?php if ($success === 'created'): ?>
    <p style="color: green;">✅ Nouveau BDE créé avec succès.</p>
<?php endif; ?>

<!-- Définir le BDE actif -->
<h2>Définir le BDE actif</h2>

<form action="/actions/admin_set_active_bde.php" method="POST">
    <label for="active_bde">Sélectionnez le BDE actif :</label>
    <select name="active_bde" id="active_bde" required>
        <option value="">-- Choisir une année --</option>
        <?php
        // On détermine le BDE actuellement actif une seule fois
        $bdeActif = null;
        foreach ($bdes as $bde) {
            if ($bdeActif === null) {
                $check = $pdo->prepare("SELECT is_active FROM bde_info WHERE id = ?");
                $check->execute([$bde['id']]);
                $row = $check->fetch();
                if ($row && $row['is_active']) {
                    $bdeActif = $bde['id'];
                }
            }
        }

        // Affichage des options avec sélection automatique
        foreach ($bdes as $bde) {
            $selected = ($bde['id'] === $bdeActif) ? 'selected' : '';
            echo "<option value='{$bde['id']}' $selected>{$bde['annee']}</option>";
        }
        ?>
    </select>
    <button type="submit">Mettre à jour</button>
</form>


<hr>

<!-- Formulaire de création d’un nouveau BDE -->
<h2>Créer un nouveau BDE</h2>
<form action="/actions/admin_add_bde.php" method="POST">
    <label for="annee">Année (ex: 2025) :</label>
    <input type="text" name="annee" id="annee" pattern="\d{4}" required><br><br>

    <label for="description">Description générale :</label><br>
    <textarea name="description" id="description" rows="6" cols="70" required></textarea><br><br>

    <button type="submit">Créer le BDE</button>
</form>

<hr>

<!-- Formulaire de création d’un membre de BDE -->
<h2>Ajouter un membre à un BDE</h2>

<form action="/actions/admin_add_bde_member.php" method="POST" enctype="multipart/form-data">
    <label for="bde_id">Année du BDE :</label>
    <select name="bde_id" id="bde_id" required>
        <option value="">-- Choisir une année --</option>
        <?php
        foreach ($bdes as $bde) {
            echo "<option value='{$bde['id']}'>{$bde['annee']}</option>";
        }
        ?>
    </select><br><br>

    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required><br><br>

    <label for="role">Rôle :</label>
    <input type="text" name="role" id="role" required><br><br>

    <label for="description">Description :</label><br>
    <textarea name="description" id="description" rows="4" cols="60" required></textarea><br><br>

    <label for="photo">Photo (PNG/JPG) :</label>
    <input type="file" name="photo" id="photo" accept="image/png, image/jpeg" required><br><br>

    <button type="submit">Ajouter le membre</button>
</form>

<hr>

<!-- BDE existants -->
<h2>Consulter un BDE</h2>

<form method="GET" action="">
    <input type="hidden" name="page" value="admin_bde">
    <label for="year">Choisir une année :</label>
    <select name="year" id="year" onchange="this.form.submit()">
        <option value="">-- Sélectionnez une année --</option>
        <?php
        foreach ($bdes as $bde) {
            $selected = (isset($_GET['year']) && $_GET['year'] === $bde['annee']) ? 'selected' : '';
            echo "<option value='" . htmlspecialchars($bde['annee']) . "' $selected>{$bde['annee']}</option>";
        }
        ?>
    </select>
</form>

<?php
if (!empty($_GET['year'])) {
    $annee = $_GET['year'];

    // 🔍 Récup info du BDE sélectionné
    $stmt = $pdo->prepare("SELECT * FROM bde_info WHERE annee = ?");
    $stmt->execute([$annee]);
    $bde = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bde):
        echo "<h3>Description du BDE {$bde['annee']}</h3>";
        echo "<p>" . nl2br(htmlspecialchars($bde['description'])) . "</p>";

        // 👥 Récup les membres associés
        $stmt = $pdo->prepare("SELECT * FROM bde_membres WHERE bde_id = ? ORDER BY nom ASC");
        $stmt->execute([$bde['id']]);
        $membres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($membres):
            echo "<h4>Membres</h4><ul style='list-style: none; padding: 0;'>";
            foreach ($membres as $membre):
                $photo = htmlspecialchars($membre['photo']);
                $photoPath = "/assets/images/upload/" . $photo;
                echo "<li style='margin-bottom: 20px; display: flex; align-items: center; gap: 15px;'>";
                echo "<img src='$photoPath' alt='{$membre['nom']}' width='80' height='80' style='object-fit: cover; border-radius: 50%;'>";
                echo "<div><strong>{$membre['nom']} – {$membre['role']}</strong><br>" . nl2br(htmlspecialchars($membre['description'])) . "</div>";
                echo "</li>";
            endforeach;
            echo "</ul>";
        else:
            echo "<p>Ce BDE n’a pas encore de membres enregistrés.</p>";
        endif;
    else:
        echo "<p style='color: red;'>BDE non trouvé.</p>";
    endif;
}
?>

<hr>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
