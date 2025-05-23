-- Récupérer les activités d'une personne
SELECT Activite.nom
FROM Activite
JOIN Pratique ON Activite.id = Pratique.idActivite
JOIN Personne ON Pratique.idPersonne = Personne.id
WHERE Personne.id = 2;

-- Créer une personne
--> dans le fichier init_bdd

-- Récupérer la liste des personnes (read)
SELECT
    Personne.id,
    Personne.nom,
    Personne.prenom,
    Personne.dateNaissance,
    Localite.nom AS `Localite`,
    Personne.depuis
FROM PersonneActivities.Personne
JOIN PersonneActivities.Localite ON Personne.idLocalite = Localite.id

-- Update
UPDATE Personne
SET (nom = :nom, prenom = :prenom, dateNaissance = :dateNaissance, idLocalite = :idLocalite, depuis = :depuis)
WHERE id = :id

-- Delete
DELETE FROM Personne WHERE id = :id





-- TRADUCTION --

SELECT * FROM PersonneActivities.Activite_traduction WHERE lang = 'fr';

-- Read principal
SELECT
	Personne.id,
    Personne.nom,
    Personne.prenom,
    Personne.dateNaissance,
    Localite.nom AS `Localite`,
    Personne.depuis
FROM PersonneActivities.Personne
JOIN PersonneActivities.Localite ON Personne.idLocalite = Localite.id;
            
-- Récupérer toutes les activités d'un user dans une langue précise
SELECT Activite_traduction.nom
FROM Activite_traduction
JOIN Pratique ON Activite_traduction.id = Pratique.idActivite
JOIN Personne ON Pratique.idPersonne = Personne.id
JOIN Langue ON Activite_traduction.lang = Langue.lang
WHERE Personne.id = 1 AND Langue.lang = "fr";

SELECT *
FROM PersonneActivities.Activite_traduction;