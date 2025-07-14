<?php
require('../inc/fonction.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];

    $utilisateur = verifier_utilisateur($nom, $mdp);

    if ($utilisateur) {
        session_start();
        $_SESSION['utilisateur'] = $utilisateur;
        header("Location: liste_objet.php");
        exit();
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - MINI RESEAU</title>
    <link rel="stylesheet" href="../asset/bootstrap/bootstrap.min.css">
    <script src="../asset/bootstrap/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<header class="container-fluid py-3 bg-dark">
        <ul class="nav justify-content-start w-100">
            <li class="nav-item"><a href="#" class="nav-link text-white"><strong>TIKTOK</strong></a></li>
            <li class="nav-item"><a href="inscription.php" class="nav-link text-white">S'inscrire<i class="fa fa-right-from-bracket"></i></a></li>
        </ul>
</header>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <h2 class="mb-4 text-center">Connexion</h2>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="Nom" class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="Antsa" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="mdp" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-dark">Valider</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
