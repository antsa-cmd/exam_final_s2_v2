<?php
require('../inc/fonction.php');
session_start();
$conn = dbconnect();

$id_objet = $_POST['id_objet'] ?? null;
$duree_jours = $_POST['duree_jours'] ?? null;

if (!$id_objet || !$duree_jours) {
    die("Erreur : données manquantes.");
}

if (!isset($_SESSION['utilisateur']) || !isset($_SESSION['utilisateur']['id_membre'])) {
    die("Erreur : utilisateur non connecté.");
}
$id_membre = $_SESSION['utilisateur']['id_membre'];

$date_emprunt = date('Y-m-d');
$date_retour = date('Y-m-d', strtotime("+$duree_jours days"));

$sqlInsert = "INSERT INTO s2_final_emprunt (id_objet, id_membre, date_emprunt, date_retour)
              VALUES (?, ?, ?, ?)";
$stmtInsert = mysqli_prepare($conn, $sqlInsert);
if (!$stmtInsert) {
    die("Erreur préparation INSERT : " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmtInsert, "iiss", $id_objet, $id_membre, $date_emprunt, $date_retour);

if (!mysqli_stmt_execute($stmtInsert)) {
    die("Erreur lors de l’enregistrement de l’emprunt : " . mysqli_error($conn));
}

$sqlUpdate = "UPDATE s2_final_objet SET 
                date_emprunt = ?, 
                date_retour = ?
              WHERE id_objet = ?";
$stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
if (!$stmtUpdate) {
    die("Erreur préparation UPDATE : " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmtUpdate, "ssi", $date_emprunt, $date_retour, $id_objet);
mysqli_stmt_execute($stmtUpdate);

// ✅ Rediriger avec succès
header("Location: liste_objet.php?msg=emprunt_success");
exit();
