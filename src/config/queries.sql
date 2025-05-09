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