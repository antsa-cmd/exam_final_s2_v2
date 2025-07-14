<?php
require('../inc/fonction.php');
session_start();

$conn = dbconnect();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header("Location: login.php");
    exit();
}

// Récupère les catégories depuis la base
$categories = [];
$sql = "SELECT * FROM s2_final_categorie_objet";
$result = mysqli_query($conn, $sql);
if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d’un objet</title>
    <link rel="stylesheet" href="../asset/bootstrap/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #f5f7fa, #c3cfe2);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 600px;
        }

        h2 {
            font-weight: 700;
            text-align: center;
            color: #343a40;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #495057;
            box-shadow: 0 0 0 0.2rem rgba(52,58,64,0.25);
        }

        .btn-dark {
            border-radius: 12px;
            padding: 10px;
            font-weight: bold;
            font-size: 1rem;
            background-color: #343a40;
            transition: background-color 0.3s ease;
        }

        .btn-dark:hover {
            background-color: #212529;
        }

        small.text-muted {
            font-size: 0.8rem;
        }

        .mt-5 {
            margin-top: 4rem !important;
        }
    </style>
</head>
<header class="py-3 bg-dark">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link text-white" href="#">Emprunt</a></li>
            <li class="nav-item ms-auto"><a class="nav-link text-white" href="liste_objet.php">Accueil<i class="fa fa-house"></i></a></li>
            <li class="nav-item ms-auto"><a class="nav-link text-white" href="ajout_objet.php">Ajouter objet<i class="fa fa-house"></i></a></li>
            <li class="nav-item"><a class="nav-link text-white" href="login.php">Déconnexion <i class="fa fa-right-from-bracket"></i></a></li>
        </ul>
</header>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Ajouter un nouvel objet</h2>
    <form action="traitement_objet.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom_objet" class="form-label">Nom de l'objet</label>
            <input type="text" class="form-control" name="nom_objet" required>
        </div>

        <div class="mb-3">
            <label for="id_categorie" class="form-label">Catégorie</label>
            <select class="form-select" name="id_categorie" required>
                <option value="">-- Sélectionnez une catégorie --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id_categorie'] ?>">
                        <?= htmlspecialchars($cat['nom_categorie']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Images (vous pouvez en sélectionner plusieurs)</label>
            <input type="file" class="form-control" name="images[]" multiple accept="image/*">
            <small class="text-muted">La première image sera l’image principale</small>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-dark">Ajouter l’objet</button>
        </div>
    </form>
</div>

</body>
</html>
