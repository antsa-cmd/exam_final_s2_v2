CREATE DATABASE s2_final;
use s2_final;

CREATE TABLE s2_final_membre (
    id_membre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    genre ENUM('Homme', 'Femme', 'Autre') NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    ville VARCHAR(100),
    mdp VARCHAR(255) NOT NULL,
    image_profil VARCHAR(255)
);


CREATE TABLE s2_final_categorie_objet (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(100) NOT NULL
);


CREATE TABLE s2_final_objet (
    id_objet INT AUTO_INCREMENT PRIMARY KEY,
    nom_objet VARCHAR(100) NOT NULL,
    id_categorie INT NOT NULL,
    id_membre INT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES s2_final_categorie_objet(id_categorie)
        ON DELETE CASCADE,
    FOREIGN KEY (id_membre) REFERENCES s2_final_membre(id_membre)
        ON DELETE CASCADE
);


CREATE TABLE s2_final_images_objet (
    id_image INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT NOT NULL,
    nom_image VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_objet) REFERENCES s2_final_objet(id_objet)
        ON DELETE CASCADE
);


CREATE TABLE s2_final_emprunt (
    id_emprunt INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT NOT NULL,
    id_membre INT NOT NULL,
    date_emprunt DATE NOT NULL,
    date_retour DATE,
    FOREIGN KEY (id_objet) REFERENCES s2_final_objet(id_objet)
        ON DELETE CASCADE,
    FOREIGN KEY (id_membre) REFERENCES s2_final_membre(id_membre)
        ON DELETE CASCADE
);


INSERT INTO s2_final_membre (nom, date_naissance, genre, email, ville, mdp, image_profil) VALUES
('Alice Rasoanaivo', '1995-04-20', 'Femme', 'alice@example.com', 'Antananarivo', 'mdp123', 'alice.jpg'),
('Jean Rakoto', '1990-11-10', 'Homme', 'jean@example.com', 'Fianarantsoa', 'mdp123', 'jean.jpg'),
('Mickael Andrianina', '2000-06-15', 'Homme', 'mickael@example.com', 'Toamasina', 'mdp123', 'mickael.jpg'),
('Sofia Randrianarisoa', '1998-01-05', 'Femme', 'sofia@example.com', 'Mahajanga', 'mdp123', 'sofia.jpg');


INSERT INTO s2_final_categorie_objet (nom_categorie) VALUES
('Esthétique'),
('Bricolage'),
('Mécanique'),
('Cuisine');



INSERT INTO s2_final_objet (nom_objet, id_categorie, id_membre) VALUES
('Sèche-cheveux', 1, 1),
('Marteau', 2, 1),
('Clé à molette', 3, 1),
('Mixeur', 4, 1),
('Lisseur', 1, 1),
('Tournevis', 2, 1),
('Crics', 3, 1),
('Batteur', 4, 1),
('Fer à friser', 1, 1),
('Scie', 2, 1);


INSERT INTO s2_final_objet (nom_objet, id_categorie, id_membre) VALUES
('Tondeuse', 1, 2),
('Perceuse', 2, 2),
('Pince multiprise', 3, 2),
('Blender', 4, 2),
('Brosse visage', 1, 2),
('Cloueur', 2, 2),
('Pompe à huile', 3, 2),
('Four électrique', 4, 2),
('Tapis de yoga', 1, 2),
('Cutter', 2, 2);


INSERT INTO s2_final_objet (nom_objet, id_categorie, id_membre) VALUES
('Miroir LED', 1, 3),
('Perforateur', 2, 3),
('Jack hydraulique', 3, 3),
('Robot pâtissier', 4, 3),
('Épilateur', 1, 3),
('Clé dynamométrique', 2, 3),
('Pneu de secours', 3, 3),
('Cocotte-minute', 4, 3),
('Parfum diffuseur', 1, 3),
('Scie sauteuse', 2, 3);


INSERT INTO s2_final_objet (nom_objet, id_categorie, id_membre) VALUES
('Lampe UV', 1, 4),
('Mètre ruban', 2, 4),
('Cric hydraulique', 3, 4),
('Grille-pain', 4, 4),
('Brosse cheveux', 1, 4),
('Tournevis plat', 2, 4),
('Batterie auto', 3, 4),
('Micro-ondes', 4, 4),
('Cireuse', 1, 4),
('Visseuse', 2, 4);

INSERT INTO s2_final_emprunt (id_objet, id_membre, date_emprunt, date_retour) VALUES
(1, 2, '2025-06-01', '2025-06-05'),
(2, 3, '2025-06-02', '2025-06-06'),
(3, 4, '2025-06-03', NULL), -- en cours
(11, 1, '2025-06-04', '2025-06-10'),
(12, 3, '2025-06-04', NULL), -- en cours
(21, 4, '2025-06-05', '2025-06-07'),
(22, 2, '2025-06-06', '2025-06-08'),
(31, 1, '2025-06-07', NULL),
(32, 2, '2025-06-08', NULL),
(4, 2, '2025-06-09', NULL);

CREATE OR REPLACE VIEW s2_final_vue_objets_emprunt AS
SELECT 
    o.id_objet,
    o.nom_objet,
    c.nom_categorie,
    m.nom AS proprietaire,
    e.date_emprunt,
    e.date_retour,
    
FROM s2_final_objet o
JOIN s2_final_categorie_objet c ON o.id_categorie = c.id_categorie
JOIN s2_final_membre m ON o.id_membre = m.id_membre
LEFT JOIN s2_final_emprunt e ON o.id_objet = e.id_objet AND e.date_retour IS NULL;




INSERT INTO s2_final_images_objet (id_objet, nom_image) VALUES
  (1, '../asset/images_objet/image1.jpg'),
  (2, '../asset/images_objet/image1.jpg'),
  (3, '../asset/images_objet/image1.jpg'),
  (4, '../asset/images_objet/image1.jpg'),
  (5, '../asset/images_objet/image1.jpg'),
  (6, '../asset/images_objet/image1.jpg'),
  (7, '../asset/images_objet/image1.jpg'),
  (8, '../asset/images_objet/image1.jpg'),
  (9, '../asset/images_objet/image1.jpg'),
  (10, '../asset/images_objet/image1.jpg'),
  (11, '../asset/images_objet/image1.jpg'),
  (12, '../asset/images_objet/image1.jpg'),
  (13, '../asset/images_objet/image1.jpg'),
  (14, '../asset/images_objet/image1.jpg'),
  (15, '../asset/images_objet/image1.jpg'),
  (16, '../asset/images_objet/image1.jpg'),
  (17, '../asset/images_objet/image1.jpg'),
  (18, '../asset/images_objet/image1.jpg'),
  (19, '../asset/images_objet/image1.jpg'),
  (20, '../asset/images_objet/image1.jpg'),
  (21, '../asset/images_objet/image1.jpg'),
  (22, '../asset/images_objet/image1.jpg'),
  (23, '../asset/images_objet/image1.jpg'),
  (24, '../asset/images_objet/image1.jpg'),
  (25, '../asset/images_objet/image1.jpg'),
  (26, '../asset/images_objet/image1.jpg'),
  (27, '../asset/images_objet/image1.jpg'),
  (28, '../asset/images_objet/image1.jpg'),
  (29, '../asset/images_objet/image1.jpg'),
  (30, '../asset/images_objet/image1.jpg'),
  (31, '../asset/images_objet/image1.jpg'),
  (32, '../asset/images_objet/image1.jpg'),
  (33, '../asset/images_objet/image1.jpg'),
  (34, '../asset/images_objet/image1.jpg'),
  (35, '../asset/images_objet/image1.jpg'),
  (36, '../asset/images_objet/image1.jpg'),
  (37, '../asset/images_objet/image1.jpg'),
  (38, '../asset/images_objet/image1.jpg'),
  (39, '../asset/images_objet/image1.jpg'),
  (40, '../asset/images_objet/image1.jpg');
 
  


CREATE OR REPLACE VIEW s2_final_vue_objets_emprunt AS
SELECT 
    o.id_objet,
    o.nom_objet,
    c.nom_categorie,
    m.nom AS proprietaire,
    e.date_emprunt,
    e.date_retour,
    
    (
      SELECT i.nom_image
      FROM s2_final_images_objet i
      WHERE i.id_objet = o.id_objet
      ORDER BY i.id_image
      LIMIT 1
    ) AS nom_image
FROM s2_final_objet o
JOIN s2_final_categorie_objet c 
  ON o.id_categorie = c.id_categorie
JOIN s2_final_membre m 
  ON o.id_membre = m.id_membre
LEFT JOIN s2_final_emprunt e 
  ON o.id_objet = e.id_objet 
     AND e.date_retour IS NULL;


je vous donne d'abord le page membres et c'est avec ca qu'on vas commencer 
