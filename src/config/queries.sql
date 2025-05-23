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

-- Récupérer toutes les activités d'un user dans une langue précise
SELECT
	Activite.id,
    COALESCE(
		(
			SELECT Activite_traduction.nom
			FROM Activite_traduction
			WHERE lang = "es" AND Activite.id = Activite_traduction.id
		),
		(
			SELECT Activite_traduction.nom
			FROM Activite_traduction
			WHERE lang = "fr" AND Activite.id = Activite_traduction.id
		)
    ) AS `nom`    
FROM Activite
RIGHT JOIN Pratique ON Activite.id = Pratique.idActivite
RIGHT JOIN Personne ON Pratique.idPersonne = Personne.id
WHERE Personne.id = 4;


SELECT *
FROM PersonneActivities.Activite_traduction;