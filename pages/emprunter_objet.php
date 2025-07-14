<?php
require('../inc/fonction.php');

$conn = dbconnect();

$id_objet = $_POST['id_objet'] ?? null;
$duree_jours = $_POST['duree_jours'] ?? null;

if (!$id_objet || !$duree_jours) {
    die("Erreur : données manquantes.");
}

$date_emprunt = date('Y-m-d');
$date_retour = date('Y-m-d', strtotime("+$duree_jours days"));

// Mettre id_membre_emprunteur à NULL (donc on met NULL en SQL)

$sql = "UPDATE s2_final_objet SET 
            id_membre_emprunteur = NULL, 
            date_emprunt = ?, 
            date_retour = ?
        WHERE id_objet = ?";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Erreur préparation SQL : " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ssi", $date_emprunt, $date_retour, $id_objet);

if (mysqli_stmt_execute($stmt)) {
    header("Location: liste_objet.php?msg=emprunt_success");
    exit();
} else {
    echo "Erreur lors de l’emprunt : " . mysqli_error($conn);
}
