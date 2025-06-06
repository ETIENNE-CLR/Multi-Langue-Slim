<?php

namespace Models;

use Controllers\LanguageController;
use Models\PDOSingleton;
use Interfaces\ICRUD;
use DateTime;
use Exception;
use PDO;
use PDOException;

class Activites implements ICRUD
{
    public int $id;

    public function __construct(
        public string $nom
    ) {}

    public function create()
    {
        try {
            $db = PDOSingleton::getInstance();

            // Requête SQL avec des paramètres nommés pour éviter les injections SQL
            $stmt = $db->prepare("INSERT INTO Activite (`nom`) VALUES (:nom)");

            // Liaison des paramètres
            $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);

            // Execution de la requête
            $stmt->execute();
            $this->id = $db->lastInsertId();
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            throw new Exception("Erreur lors de l'insertion : " . $e->getMessage());
        }
    }

    static function read()
    {
        try {
            $db = PDOSingleton::getInstance();
            $stmt = $db->prepare('SELECT * FROM Activite');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }

    static function readById(int $id)
    {
        try {
            $db = PDOSingleton::getInstance();
            $stmt = $db->prepare("SELECT * FROM Activite WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }

    public function update()
    {
        try {
            $db = PDOSingleton::getInstance();

            // Requête SQL avec des paramètres nommés pour éviter les injections SQL
            $stmt = $db->prepare(
                "UPDATE Activite SET (nom = :nom)
                WHERE id = :id"
            );

            // Liaison des paramètres
            $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            // Execution de la requête
            $stmt->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            throw new Exception("Erreur lors de l'insertion : " . $e->getMessage());
        }
    }

    static function delete(int $id)
    {
        try {
            $db = PDOSingleton::getInstance();

            // Requête SQL avec des paramètres nommés pour éviter les injections SQL
            $stmt = $db->prepare("DELETE FROM Activite WHERE id = :id");

            // Liaison des paramètres
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execution de la requête
            $stmt->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            throw new Exception("Erreur lors de l'insertion : " . $e->getMessage());
        }
    }

    static function getActivitiesFromPersonneID(int $personneId)
    {
        try {
            // Init
            // Query qui prend la traduction de la langue choisie + la langue par défaut
            // Et remplace la langue par la langue par défaut si elle n'existe pas
            $db = PDOSingleton::getInstance();
            $stmt = $db->prepare('SELECT
                COALESCE(
                    (
                        SELECT Activite_traduction.nom
                        FROM Activite_traduction
                        WHERE lang = :lang AND Activite.id = Activite_traduction.id
                    ),
                    (
                        SELECT Activite_traduction.nom
                        FROM Activite_traduction
                        WHERE lang = :defaultLang AND Activite.id = Activite_traduction.id
                    )
                ) AS `nom`
            FROM Activite
            RIGHT JOIN Pratique ON Activite.id = Pratique.idActivite
            RIGHT JOIN Personne ON Pratique.idPersonne = Personne.id
            WHERE Personne.id = :id');

            // Execution du query
            $lang = LanguageController::getLanguage(true);
            $defaultLang = LanguageController::DEFAULT_LANGUAGE;
            $stmt->bindParam(':id', $personneId, PDO::PARAM_INT);
            $stmt->bindParam(':lang', $lang, PDO::PARAM_STR);
            $stmt->bindParam(':defaultLang', $defaultLang, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Génération du string
            $stringActivities = '';
            foreach ($results as $aActivities) {
                $stringActivities .= $aActivities['nom'] . ', ';
            }
            return substr($stringActivities, 0, strlen($stringActivities) - 2);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }
}
