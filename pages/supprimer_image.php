<?php
require('../inc/fonction.php');
$conn = dbconnect();

$id_image = intval($_GET['id_image']);
$sql = "SELECT nom_image FROM s2_final_images_objet WHERE id_image = $id_image";
$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($res);

if ($data && file_exists($data['nom_image'])) {
    unlink($data['nom_image']);
}

mysqli_query($conn, "DELETE FROM s2_final_images_objet WHERE id_image = $id_image");
header('Location: liste_objets.php');
exit;