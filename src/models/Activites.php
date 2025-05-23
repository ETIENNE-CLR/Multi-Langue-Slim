<?php

namespace Models;

use Controllers\LanguageController;
use Controllers\PDOSingleton;
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
            $db = PDOSingleton::getInstance();
            $stmt = $db->prepare('SELECT Activite_traduction.nom
            FROM Activite_traduction
            JOIN Pratique ON Activite_traduction.id = Pratique.idActivite
            JOIN Personne ON Pratique.idPersonne = Personne.id
            JOIN Langue ON Activite_traduction.lang = Langue.lang
            WHERE Personne.id = :id AND Langue.lang = :lang');

            // Execution du query
            $lang = LanguageController::getLanguage(true);
            $stmt->bindParam(':id', $personneId, PDO::PARAM_INT);
            $stmt->bindParam(':lang', $lang, PDO::PARAM_STR);
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
