<?php
session_start();
require('../inc/fonction.php');

if (!isset($_SESSION['utilisateur']['id_membre'])) {
    die("Vous devez être connecté pour supprimer un objet.");
}

$conn = dbconnect();

$id_membre = $_SESSION['utilisateur']['id_membre'];

if (!isset($_GET['id_objet']) || !is_numeric($_GET['id_objet'])) {
    header("Location: liste_objet.php?error=ID_invalide");
    exit;
}

$id_objet = intval($_GET['id_objet']);

$res = mysqli_query($conn, "SELECT id_membre FROM s2_final_objet WHERE id_objet = $id_objet");
if (!$res) {
    header("Location: liste_objet.php?error=Erreur_SQL");
    exit;
}
$row = mysqli_fetch_assoc($res);

if (!$row) {
    header("Location: liste_objet.php?error=Objet_introuvable");
    exit;
}

if ($row['id_membre'] != $id_membre) {
    header("Location: liste_objet.php?error=Acces_refuse");
    exit;
}

$resDel = mysqli_query($conn, "DELETE FROM s2_final_objet WHERE id_objet = $id_objet");
if (!$resDel) {
    header("Location: liste_objet.php?error=Erreur_suppression");
    exit;
}

header("Location: liste_objet.php?success=Objet_supprime");
exit;
