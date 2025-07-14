<?php
require('../inc/fonction.php');

$uploadDir = __DIR__ . '/../asset/images/';
$maxSize = 2 * 1024 * 1024;
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['img'])) {
    $file = $_FILES['img'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die('Erreur upload : ' . $file['error']);
    }

    if ($file['size'] > $maxSize) {
        die('Fichier trop gros.');
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowedMimeTypes)) {
        die('Type de fichier non autorisé : ' . $mime);
    }

    // Renommer et déplacer
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = uniqid('img_', true) . '.' . $extension;

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
        die("Erreur lors du déplacement du fichier.");
    }

    // Préparer les infos pour la base
    $info['email'] = $_POST['email'];
    $info['nom'] = $_POST['nom'];
    $info['mdp'] = $_POST['mdp'];
    $info['dtn'] = $_POST['dtn'];
    $info['ville'] = $_POST['ville'];
    $info['img'] = $newName;

    insert_inf_insc($info);

    header("Location: login.php");
    exit;
} else {
    die("Aucun fichier envoyé.");
}
?>
