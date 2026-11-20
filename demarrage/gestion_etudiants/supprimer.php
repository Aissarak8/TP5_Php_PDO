<?php
// Suppression d'un étudiant
require_once __DIR__ . '/config/connexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: liste.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare('DELETE FROM etudiants WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        header('Location: liste.php?supprime=1');
        exit;
    }

}

header('Location: liste.php');
exit;
