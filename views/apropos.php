<?php
require_once __DIR__ . '/../includes/header.php';

$anneeDemandee = $_GET['bde'] ?? null;

require_once __DIR__ . '/../includes/config.php';

try {
    if ($anneeDemandee) {
        $stmt = $pdo->prepare("SELECT * FROM bde_info WHERE annee = ?");
        $stmt->execute([$anneeDemandee]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM bde_info WHERE is_active = TRUE LIMIT 1");
        $stmt->execute();
    }

    $bde = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bde) {
        echo "<h2>BDE {$bde['annee']}</h2>";
        echo "<p>" . nl2br(htmlspecialchars($bde['description'])) . "</p>";

        $stmtMembres = $pdo->prepare("SELECT * FROM bde_membres WHERE bde_id = ?");
        $stmtMembres->execute([$bde['id']]);
        $membres = $stmtMembres->fetchAll(PDO::FETCH_ASSOC);

        if ($membres) {
            echo "<h3>Équipe du BDE</h3><div class='bde-membres'>";
            foreach ($membres as $membre) {
                echo "<div class='membre'>";
                if (!empty($membre['photo'])) {
                    echo "<img src='/assets/images/upload/" . htmlspecialchars($membre['photo']) . "' alt='Photo de {$membre['nom']}' width='120'>";
                }
                echo "<h4>" . htmlspecialchars($membre['nom']) . "</h4>";
                echo "<p><em>" . htmlspecialchars($membre['role']) . "</em></p>";
                echo "<p>" . nl2br(htmlspecialchars($membre['description'])) . "</p>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>Aucun membre enregistré pour ce BDE.</p>";
        }

    } else {
        echo "<p>BDE non trouvé.</p>";
    }

    $stmtAll = $pdo->query("SELECT annee FROM bde_info ORDER BY annee DESC");
    $allAnnees = $stmtAll->fetchAll(PDO::FETCH_COLUMN);

    echo "<hr><h3>Anciens BDE</h3><ul>";
    foreach ($allAnnees as $annee) {
        if (!$anneeDemandee && $annee === $bde['annee']) continue;
        echo "<li><a href='/index.php?page=apropos&bde=" . urlencode($annee) . "'>$annee</a></li>";
    }
    echo "</ul><hr>";

} catch (PDOException $e) {
    echo "<p>Erreur lors du chargement des données.</p>";
}

require_once __DIR__ . '/../includes/footer.php';?>
