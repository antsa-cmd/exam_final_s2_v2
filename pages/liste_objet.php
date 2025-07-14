<?php
require('../inc/fonction.php');

$conn = dbconnect();
$objets = getObjetsAvecEtat($conn);
$aujourdhui = date('Y-m-d'); // Date du jour
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
        <li class="nav-item ms-auto"><a class="nav-link text-white" href="ajout_objet.php">Ajouter objet<i class="fa fa-house"></i></a></li>
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
                            <?php
                            // Si l'objet a une date d'emprunt et une date de retour
                            if ($row['date_emprunt'] && $row['date_retour']) {
                                $dateRetour = new DateTime($row['date_retour']);
                                $aujourdhuiDT = new DateTime($aujourdhui);
                                $interval = $aujourdhuiDT->diff($dateRetour);
                                $joursRestants = (int)$interval->format('%r%a');

                                if ($joursRestants > 0) {
                                    echo '<span class="etat-emprunt">Emprunt en cours (disponible dans ' 
                                        . $joursRestants . ' jour' . ($joursRestants > 1 ? 's' : '') . ')</span>';
                                } elseif ($joursRestants === 0) {
                                    echo '<span class="etat-emprunt">Emprunt en cours (disponible aujourd\'hui)</span>';
                                } else {
                                    // Date passée → disponible
                                    echo '<span class="etat-disponible">Disponible</span>';
                                }
                            } else {
                                // Pas d'emprunt enregistré
                                echo '<span class="etat-disponible">Disponible</span>';
                            }
                            ?>
                        </p>

                        <!-- Bouton Supprimer -->
                        <a href="supprimer_objet.php?id_objet=<?= $row['id_objet'] ?>"
                           onclick="return confirm('Voulez-vous vraiment supprimer cet objet ?');"
                           class="btn btn-sm btn-danger mt-2">Supprimer</a>

                        <!-- Bouton Emprunter et formulaire -->
                        <?php if (!($row['date_emprunt'] && $row['date_retour'] && (new DateTime($aujourdhui) <= new DateTime($row['date_retour'])))): ?>
                            <button type="button" class="btn btn-sm btn-primary mt-2"
                                    onclick="afficherFormulaire(<?= $row['id_objet'] ?>)">
                                Emprunter
                            </button>
                            <form action="emprunter_objet.php" method="POST"
                                  class="mt-2 d-none" id="form_<?= $row['id_objet'] ?>">
                                <input type="hidden" name="id_objet" value="<?= $row['id_objet'] ?>">
                                <div class="input-group input-group-sm mb-2">
                                    <input type="number" class="form-control" name="duree_jours"
                                           placeholder="Durée (jours)" required min="1">
                                    <button type="submit" class="btn btn-success">Confirmer</button>
                                </div>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
function afficherFormulaire(idObjet) {
    const form = document.getElementById("form_" + idObjet);
    if (form) {
        form.classList.toggle("d-none");
    }
}
</script>
</body>
</html>
