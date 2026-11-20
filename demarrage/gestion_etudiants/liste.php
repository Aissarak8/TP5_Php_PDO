<?php
$titre = 'Liste des étudiants';
require_once __DIR__ . '/config/connexion.php';

$pdo = getConnexion();

// Filtre par filière
$filtre = $_GET['filiere'] ?? '';

if ($filtre !== '' && in_array($filtre, FILIERES, true)) {
    $stmt = $pdo->prepare('SELECT id, cne, nom, prenom, email, filiere, date_naissance, date_inscription FROM etudiants WHERE filiere = :filiere ORDER BY nom, prenom');
    $stmt->bindParam(':filiere', $filtre);
    $stmt->execute();
}

if ($filtre === '') {
    $stmt = $pdo->query('SELECT id, cne, nom, prenom, email, filiere, date_naissance, date_inscription FROM etudiants ORDER BY nom, prenom');
}

// Résultats de la requête
$etudiants   = $stmt->fetchAll();
$nbEtudiants = count($etudiants);
$nbColonnes  = $stmt->columnCount();

// Message après une action
$message = '';
if (isset($_GET['ajout']))     { $message = 'Étudiant ajouté avec succès (id n° ' . (int) $_GET['ajout'] . ').'; }
if (isset($_GET['supprime']))  { $message = 'Étudiant supprimé.'; }

require __DIR__ . '/includes/header.php';
?>
<h1>Liste des étudiants</h1>

<?php if ($message): ?>
    <div class="alerte alerte-succes"><?= e($message) ?></div>
<?php endif; ?>

<div class="carte">
    <div class="barre-outils">
        <form method="get" action="liste.php">
            <label for="filiere">Filière :</label>
            <select name="filiere" id="filiere" onchange="this.form.submit()">
                <option value="">Toutes</option>
                <?php foreach (FILIERES as $f): ?>
                    <option value="<?= e($f) ?>" <?= $filtre === $f ? 'selected' : '' ?>><?= e($f) ?></option>
                <?php endforeach; ?>
            </select>
            <noscript><button class="btn" type="submit">Filtrer</button></noscript>
        </form>
        <a class="btn" href="ajouter.php">➕ Ajouter</a>
    </div>

    <p class="info"><?= $nbEtudiants ?> étudiant(s) — <?= $nbColonnes ?> colonnes retournées par la requête</p>

    <table>
        <thead>
            <tr>
                <th>#</th><th>CNE</th><th>Nom</th><th>Prénom</th><th>E-mail</th>
                <th>Filière</th><th>Naissance</th><th>Inscrit le</th><th></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($nbEtudiants === 0): ?>
            <tr><td colspan="9" class="vide">Aucun étudiant enregistré pour le moment.</td></tr>
        <?php else: ?>
            <?php foreach ($etudiants as $i => $etu): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= e($etu['cne']) ?></td>
                    <td><?= e(strtoupper($etu['nom'])) ?></td>
                    <td><?= e($etu['prenom']) ?></td>
                    <td><?= e($etu['email']) ?></td>
                    <td><span class="badge"><?= e($etu['filiere']) ?></span></td>
                    <td><?= $etu['date_naissance'] ? date('d/m/Y', strtotime($etu['date_naissance'])) : '—' ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($etu['date_inscription'])) ?></td>
                    <td>
                        <form method="post" action="supprimer.php" onsubmit="return confirm('Supprimer cet étudiant ?');">
                            <input type="hidden" name="id" value="<?= (int) $etu['id'] ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
