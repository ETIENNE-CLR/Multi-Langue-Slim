-- Initialisation de la base de données
DROP DATABASE IF EXISTS `PersonneActivities`;
CREATE DATABASE `PersonneActivities`;
USE `PersonneActivities`;

-- Création des tables
-- Classe Activite
CREATE TABLE Activite (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(60) NOT NULL
);

-- Classe Localite
CREATE TABLE Localite (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(60) NOT NULL
);

-- Classe Personne
CREATE TABLE Personne (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(50) NOT NULL,
    `prenom` VARCHAR(50) NOT NULL,
    `dateNaissance` DATETIME NOT NULL,
    `idLocalite` INT DEFAULT NULL,
    `depuis` DATETIME NOT NULL,
    FOREIGN KEY (`idLocalite`) REFERENCES `Localite`(`id`)
);

-- Classe Pratique
CREATE TABLE Pratique (
    `idPersonne` INT NOT NULL,
    `idActivite` INT NOT NULL,
    FOREIGN KEY (`idPersonne`) REFERENCES `Personne`(`id`),
    FOREIGN KEY (`idActivite`) REFERENCES `Activite`(`id`)
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
('Dupont', 'Jean', '1990-05-14 00:00:00', 1, '2020-03-15 00:00:00'),
('Martin', 'Sophie', '1985-07-23 00:00:00', 2, '2018-10-10 00:00:00'),
('Bernard', 'Paul', '2000-01-30 00:00:00', 3, '2022-06-01 00:00:00'),
('Dubois', 'Marie', '1995-12-12 00:00:00', 4, '2019-09-20 00:00:00');

-- Pratiques
INSERT INTO Pratique (`idPersonne`, `idActivite`) VALUES
(1, 1), -- Jean pratique la natation
(1, 3), -- Jean pratique la course à pied
(2, 2), -- Sophie pratique le tennis
(2, 4), -- Sophie pratique l'escalade
(3, 5), -- Paul pratique le cyclisme
(4, 1), -- Marie pratique la natation
(4, 5); -- Marie pratique le cyclisme