<?php
require('../inc/fonction.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $info['email'] = $_POST['email'];
    $info['nom'] = $_POST['nom'];
    $info['mdp'] = $_POST['mdp'];
    $info['dtn'] = $_POST['dtn'];
    $info['ville'] = $_POST['ville'];
    $info['img'] = $_POST['img'];



    insert_inf_insc($info);

    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/bootstrap/bootstrap.min.css">
    <script src="../asset/bootstrap/bootstrap.bundle.min.js"></script>
    <title>index</title>
</head>
<body>
<header class="bg-dark py-3 mb-4">
        <div class="container">
            <nav class="d-flex justify-content-between align-items-center">
                <a href="amis.php" class="text-white text-decoration-none fs-4 fw-bold">EXAMEN</a>
                <ul class="nav">
                    <li class="nav-item">
                        <a href="login.php" class="nav-link text-white">Se connecter</a>
                    </li>
                </ul>
            </nav>
        </div>
</header>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-5 text-dark mt-5 text-center">
                <h1>Bienvenue, veuillez vous inscrire</h1>
            </div>

            <div class="col-md-7">
                <form action="traitement_image.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Votre email..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" placeholder="Votre nom..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="mdp" class="form-control" placeholder="Votre mot de passe..." required>
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Ville</label>
                        <input type="text" name="ville" class="form-control" placeholder="Votre ville..." required>
                    </div> 
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="img" accept="image/*" required>   
                    </div>
                    <div class="mb-3">
                        <label class="form-label">date de naissance</label>
                        <input type="date" name="dtn" class="form-control" placeholder="Votre date de naissance..." required>
                    </div>
                  
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
