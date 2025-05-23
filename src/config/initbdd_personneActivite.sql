-- Initialisation de la base de données
DROP DATABASE IF EXISTS `PersonneActivities`;
CREATE DATABASE `PersonneActivities`;
USE `PersonneActivities`;

-- Création des tables
-- Table Activite
CREATE TABLE Activite (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(60) NOT NULL,
    `description` TEXT,
    `sigle` VARCHAR(25)
);

-- Table Localite
CREATE TABLE Localite (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(60) NOT NULL
);

-- Table Personne
CREATE TABLE Personne (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(50) NOT NULL,
    `prenom` VARCHAR(50) NOT NULL,
    `dateNaissance` DATE NOT NULL,
    `idLocalite` INT DEFAULT NULL,
    `depuis` DATE NOT NULL,
    FOREIGN KEY (`idLocalite`) REFERENCES `Localite`(`id`)
);

-- Table Pratique
CREATE TABLE Pratique (
    `idPersonne` INT NOT NULL,
    `idActivite` INT NOT NULL,
    FOREIGN KEY (`idPersonne`) REFERENCES `Personne`(`id`),
    FOREIGN KEY (`idActivite`) REFERENCES `Activite`(`id`)
);

-- Table Langue
CREATE TABLE Langue (
    `lang` VARCHAR(5) PRIMARY KEY, -- fr, en, es
    `locale` VARCHAR(10), -- fr_FR, en_US, es_ES
    `nom` VARCHAR(50) -- Français, English, Espanõl
);

-- Table Traduction
CREATE TABLE Activite_traduction (
    `id` INT,
    `lang` VARCHAR(5),
    `nom` VARCHAR(50),
    `description` TEXT,
    PRIMARY KEY (`id`, `lang`),
    FOREIGN KEY (`id`) REFERENCES `Activite`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`lang`) REFERENCES `Langue`(`lang`) ON DELETE CASCADE
);

-- Insertion des données de base
-- Localités
INSERT INTO Localite (`nom`) VALUES
('SDF'),
('Genève'),
('Lausanne'),
('Zurich'),
('Bâle');

-- Activités
INSERT INTO Activite (`nom`) VALUES
('Natation'),
('Tennis'),
('Course à pied'),
('Escalade'),
('Cyclisme');

-- Personnes
INSERT INTO Personne (`nom`, `prenom`, `dateNaissance`, `idLocalite`, `depuis`) VALUES
('Dupont', 'Jean', '1990-05-14', 1, '2020-03-15'),
('Martin', 'Sophie', '1985-07-23', 2, '2018-10-10'),
('Bernard', 'Paul', '2000-01-30', 3, '2022-06-01'),
('Dubois', 'Marie', '1995-12-12', 4, '2019-09-20');

-- Pratiques
INSERT INTO Pratique (`idPersonne`, `idActivite`) VALUES
(1, 1), -- Jean pratique la natation
(1, 3), -- Jean pratique la course à pied
(2, 2), -- Sophie pratique le tennis
(2, 4), -- Sophie pratique l'escalade
(3, 5), -- Paul pratique le cyclisme
(4, 1), -- Marie pratique la natation
(4, 5); -- Marie pratique le cyclisme


-- Ajout des langues
INSERT INTO Langue (`lang`, `locale`, `nom`) VALUES
('fr', 'fr_FR', 'Français'),
('en', 'en_US', 'English'),
('es', 'es_ES', 'Español'),
('it', 'it_IT', 'Italian'),
('ja', 'ja_JP', '日本語');

-- Traductions des activités en anglais
INSERT INTO Activite_traduction (`id`, `lang`, `nom`, `description`) VALUES
-- Natation / Swimming
(1, 'fr', 'Natation', 'Sport consistant à se déplacer dans l’eau à l’aide des bras et des jambes'),
(1, 'en', 'Swimming', 'Sport involving movement through water using limbs'),
(1, 'es', 'Natación', 'Deporte que consiste en desplazarse en el agua con los brazos y las piernas'),
(1, 'it', 'Nuoto', 'Sport che consiste nel muoversi nell’acqua con braccia e gambe'),
(1, 'ja', '水泳', '手足を使って水中を移動するスポーツ'),

-- Tennis
(2, 'fr', 'Tennis', 'Sport qui se joue avec une raquette et une balle sur un court'),
(2, 'en', 'Tennis', 'Sport played with rackets and a ball on a court'),
(2, 'es', 'Tenis', 'Deporte que se juega con raquetas y una pelota en una cancha'),
(2, 'it', 'Tennis', 'Sport praticato con racchette e una palla su un campo'),
(2, 'ja', 'テニス', 'ラケットとボールを使ってコートで行うスポーツ'),

-- Course à pied / Running
(3, 'fr', 'Course à pied', 'Sport consistant à courir sur différentes distances'),
(3, 'en', 'Running', 'Sport involving running or jogging over distances'),
(3, 'es', 'Correr', 'Deporte que consiste en correr a diferentes velocidades y distancias'),
(3, 'it', 'Corsa', 'Sport che consiste nel correre su varie distanze'),
(3, 'ja', 'ランニング', 'さまざまな距離を走るスポーツ'),

-- Escalade / Climbing
(4, 'fr', 'Escalade', 'Activité consistant à grimper des parois naturelles ou artificielles'),
(4, 'en', 'Climbing', 'Activity of ascending natural or artificial walls'),
(4, 'es', 'Escalada', 'Actividad de ascender paredes naturales o artificiales'),
(4, 'it', 'Arrampicata', 'Attività di scalare pareti naturali o artificiali'),
(4, 'ja', 'クライミング', '自然または人工の壁を登るアクティビティ'),

-- Cyclisme / Cycling
(5, 'fr', 'Cyclisme', 'Sport consistant à se déplacer à vélo sur route ou chemin'),
(5, 'en', 'Cycling', 'Sport of riding bicycles on roads or trails'),
(5, 'es', 'Ciclismo', 'Deporte que consiste en montar en bicicleta por carreteras o caminos'),
(5, 'it', 'Ciclismo', 'Sport che consiste nel pedalare su strade o sentieri'),
(5, 'ja', 'サイクリング', '道路やトレイルで自転車に乗るスポーツ');
