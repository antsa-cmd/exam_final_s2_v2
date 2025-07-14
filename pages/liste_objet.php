<?php
require('../inc/fonction.php');

$conn = dbconnect();
$objets = getObjetsAvecEtat($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Objets disponibles</title>
    <link rel="stylesheet" href="../asset/bootstrap/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .objet-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            font-size: 0.85rem;
        }
        .objet-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }
        .objet-card img {
            height: 140px;
            object-fit: cover;
        }
        .card-body {
            background-color: #ffffff;
            padding: 12px;
        }
        .card-title {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #343a40;
        }
        .card-text p {
            margin: 4px 0;
            font-size: 0.82rem;
            color: #555;
        }
        .etat-disponible {
            color: #198754;
            font-weight: bold;
        }
        .etat-emprunt {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<header class="py-3 bg-dark">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link text-white" href="#">Emprunt</a></li>
            <li class="nav-item ms-auto"><a class="nav-link text-white" href="#">Accueil<i class="fa fa-house"></i></a></li>
            <li class="nav-item"><a class="nav-link text-white" href="login.php">Déconnexion <i class="fa fa-right-from-bracket"></i></a></li>
        </ul>
</header>
<body>
<div class="container py-4">
    <h2 class="text-center mb-4 fw-bold">Objets disponibles</h2>
    <div class="row g-3">
        <?php foreach ($objets as $row): ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card objet-card">
                <?php if (!empty($row['nom_image'])): ?>
                    <img src="<?= htmlspecialchars($row['nom_image']) ?>" class="card-img-top" alt="objet">
                <?php else: ?>
                    <div class="bg-secondary text-white text-center py-4">Aucune image</div>
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($row['nom_objet']) ?></h5>
                    <div class="card-text">
                        <p><strong>Catégorie :</strong> <?= htmlspecialchars($row['nom_categorie']) ?></p>
                        <p><strong>Propriétaire :</strong> <?= htmlspecialchars($row['proprietaire']) ?></p>
                        <p><strong>Emprunt :</strong> <?= $row['date_emprunt'] ? htmlspecialchars($row['date_emprunt']) : '—' ?></p>
                        <p>
                            <strong>État :</strong>
                            <?php if ($row['date_emprunt'] && !$row['date_retour']): ?>
                                <span class="etat-emprunt">Emprunt en cours</span>
                            <?php else: ?>
                                <span class="etat-disponible">Disponible</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
