<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un objet</title>
    <link rel="stylesheet" href="../asset/bootstrap/bootstrap.min.css">
</head>
<header class="py-3 bg-dark">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link text-white" href="#">Emprunt</a></li>
            <li class="nav-item ms-auto"><a class="nav-link text-white" href="#">Accueil<i class="fa fa-house"></i></a></li>
            <li class="nav-item ms-auto"><a class="nav-link text-white" href="ajout_objet.php">Ajouter objet<i class="fa fa-house"></i></a></li>
            <li class="nav-item"><a class="nav-link text-white" href="login.php">Déconnexion <i class="fa fa-right-from-bracket"></i></a></li>
        </ul>
</header>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Ajouter un nouvel objet</h2>
    <form action="traitement_objet.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nom de l'objet</label>
            <input type="text" name="nom_objet" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="id_categorie" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                <option value="1">Esthétique</option>
                <option value="2">Bricolage</option>
                <option value="3">Mécanique</option>
                <option value="4">Cuisine</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Images (plusieurs possibles)</label>
            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter l'objet</button>
    </form>
</div>
</body>
</html>