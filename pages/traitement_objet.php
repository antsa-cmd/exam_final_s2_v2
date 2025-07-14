<?php
require('../inc/fonction.php');
session_start();
$conn = dbconnect();

// Vérification de session
if (!isset($_SESSION['utilisateur'])) {
    die("Erreur : utilisateur non connecté.");
}
$id_membre = $_SESSION['id_membre'];

// Vérification des champs
if (empty($_POST['nom_objet']) || empty($_POST['id_categorie'])) {
    die("Erreur : champ nom_objet ou id_categorie manquant.");
}

$nom_objet = mysqli_real_escape_string($conn, $_POST['nom_objet']);
$id_categorie = intval($_POST['id_categorie']);

// Insertion de l'objet
$sql = "INSERT INTO s2_final_objet (nom_objet, id_categorie, id_membre) 
        VALUES ('$nom_objet', $id_categorie, $id_membre)";
if (!mysqli_query($conn, $sql)) {
    die("Erreur insertion objet: " . mysqli_error($conn));
}
$id_objet = mysqli_insert_id($conn);

// Upload des images
$uploadDir = "../asset/images_objet/";
$defaultRelPath = '../asset/images_objet/default.jpg';
$images_uploaded = false;

if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['images']['name'][$index], PATHINFO_EXTENSION);
            $newName = uniqid("img_") . "." . $ext;
            $destination = $uploadDir . $newName;
            if (move_uploaded_file($tmpName, $destination)) {
                $imagePath = '../asset/images_objet/' . $newName;
                $sqlImg = "INSERT INTO s2_final_images_objet (id_objet, nom_image) 
                           VALUES ($id_objet, '$imagePath')";
                mysqli_query($conn, $sqlImg);
                $images_uploaded = true;
            }
        }
    }
}

// Si aucune image : image par défaut
if (!$images_uploaded) {
    $sql = "INSERT INTO s2_final_images_objet (id_objet, nom_image) 
            VALUES ($id_objet, '$defaultRelPath')";
    mysqli_query($conn, $sql);
}

header('Location: liste_objets.php');
exit;
