<?php
require("connexion.php");
function insert_inf_insc($info){
    $conn = dbconnect();

    $username = mysqli_real_escape_string($conn, $info['nom']);
    $email = mysqli_real_escape_string($conn, $info['email']);
    $password = mysqli_real_escape_string($conn, $info['mdp']);
    $dtn = mysqli_real_escape_string($conn, $info['dtn']);
    $ville = mysqli_real_escape_string($conn, $info['ville']);
    $img = mysqli_real_escape_string($conn, $info['img']);



    $sql = "INSERT INTO s2_final_membre (nom, email , mdp, date_naissance, ville, image_profil) VALUES ('$username', '$email', '$password', '$dtn', '$ville', '$img')";
    if (!mysqli_query($conn, $sql)) {
        die("Erreur MySQL : " . mysqli_error($conn));
    }
}

function verifier_utilisateur($nom, $mdp) {
    $conn = dbconnect();

    $sql = "SELECT * FROM s2_final_membre WHERE nom = '%s' AND mdp = '%s'";
    $sql = sprintf($sql, mysqli_real_escape_string($conn, $nom), mysqli_real_escape_string($conn, $mdp));

    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) == 1) {
        $user = mysqli_fetch_assoc($res);
        return $user; 
    }

    return false; 
}


function getObjetsAvecEtat($conn) {
    $sql = "SELECT * FROM s2_final_vue_objets_emprunt";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Erreur SQL (vue_objets_emprunt) : " . mysqli_error($conn));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
