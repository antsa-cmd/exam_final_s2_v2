<?php
require('../inc/fonction.php');
session_start();

$conn = dbconnect();

if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit();
}

// Récupère id_membre depuis la session (attention au nom exact)
$id_membre = $_SESSION['utilisateur']['id_membre'];

$nom_objet = mysqli_real_escape_string($conn, $_POST['nom_objet']);
$id_categorie = intval($_POST['id_categorie']);

$sql = "INSERT INTO s2_final_objet (nom_objet, id_categorie, id_membre) VALUES ('$nom_objet', $id_categorie, $id_membre)";
if (!mysqli_query($conn, $sql)) {
    die("Erreur insertion objet: " . mysqli_error($conn));
}
$id_objet = mysqli_insert_id($conn);

$uploadDir = __DIR__ . '../asset/images_objet/';  // chemin absolu vers dossier d'upload
$defaultRelPath = '../asset/images_objet/default.jpg';
$images_uploaded = false;

if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['images']['name'][$index], PATHINFO_EXTENSION);
            $newName = uniqid("img_") . "." . $ext;
            $destination = $uploadDir . $newName;

            // Déplace le fichier temporaire vers le dossier cible
            if (move_uploaded_file($tmpName, $destination)) {
                $imagePath = '../asset/images_objet/' . $newName;  // chemin relatif stocké en base
                $sqlImg = "INSERT INTO s2_final_images_objet (id_objet, nom_image) VALUES ($id_objet, '$imagePath')";
                mysqli_query($conn, $sqlImg);
                $images_uploaded = true;
            } else {
                echo "Échec du déplacement du fichier : " . htmlspecialchars($_FILES['images']['name'][$index]) . "<br>";
            }
        } else {
            echo "Erreur lors de l'upload du fichier : " . htmlspecialchars($_FILES['images']['name'][$index]) . "<br>";
        }
    }
}

if (!$images_uploaded) {
    $sql = "INSERT INTO s2_final_images_objet (id_objet, nom_image) VALUES ($id_objet, '$defaultRelPath')";
    mysqli_query($conn, $sql);
}

header('Location: liste_objet.php');
exit;
