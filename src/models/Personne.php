<?php

namespace Models;

use Controllers\PDOSingleton;
use Interfaces\ICRUD;
use Models\Activites;
use DateTime;
use Exception;
use PDO;
use PDOException;

class Personne implements ICRUD
{
    public int $id;

    public function __construct(
        public string $nom,
        public string $prenom,
        public DateTime $dateNaissance,
        public int|null $idLocalite,
        public DateTime $depuis
    ) {}

    public function create()
    {
        try {
            $db = PDOSingleton::getInstance();
            $stmt = $db->prepare(
                "INSERT INTO Personne (nom, prenom, dateNaissance, idLocalite, depuis)
            VALUES (:nom, :prenom, :dateNaissance, :idLocalite, :depuis)"
            );

            // Variables pour les dates formatées
            $formattedDateNaissance = $this->dateNaissance->format('Y-m-d');
            $formattedDepuis = $this->depuis->format('Y-m-d');

            // Liaison des paramètres
            $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
            $stmt->bindParam(':dateNaissance', $formattedDateNaissance, PDO::PARAM_STR);
            $stmt->bindParam(':idLocalite', $this->idLocalite);
            $stmt->bindParam(':depuis', $formattedDepuis, PDO::PARAM_STR);

            // Exécution de la requête
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
            $stmt = $db->prepare('SELECT
                Personne.id,
                Personne.nom,
                Personne.prenom,
                Personne.dateNaissance,
                Localite.nom AS `Localite`,
                Personne.depuis
            FROM PersonneActivities.Personne
            JOIN PersonneActivities.Localite ON Personne.idLocalite = Localite.id');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Génération des activités
            foreach ($results as $key => $apersonne) {
                $results[$key]['activites'] = Activites::getActivitiesFromPersonneID($apersonne['id']);
            }
            return $results;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }

    static function readById(int $id)
    {
        try {
            $db = PDOSingleton::getInstance();
            $stmt = $db->prepare("SELECT
                Personne.id,
                Personne.nom,
                Personne.prenom,
                Personne.dateNaissance,
                Localite.nom AS `Localite`,
                Personne.depuis
            FROM PersonneActivities.Personne
            JOIN PersonneActivities.Localite ON Personne.idLocalite = Localite.id
            WHERE Personne.id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            $results['activites'] = Activites::getActivitiesFromPersonneID($results['id']);
            return $results;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }

    static function readByIdWithIDs(int $id)
    {
        try {
            $db = PDOSingleton::getInstance();
            $stmt = $db->prepare("SELECT
                Personne.id,
                Personne.nom,
                Personne.prenom,
                Personne.dateNaissance,
                Localite.id AS `Localite`,
                Personne.depuis,
                GROUP_CONCAT(Activite.id) AS `Activites`
            FROM PersonneActivities.Personne
            JOIN PersonneActivities.Localite ON Personne.idLocalite = Localite.id
            JOIN PersonneActivities.Pratique ON Personne.id = Pratique.idPersonne
            JOIN PersonneActivities.Activite ON Pratique.idActivite = Activite.id
            WHERE Personne.id = :id");
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
                "UPDATE Personne SET (nom = :nom, prenom = :prenom, dateNaissance = :dateNaissance, idLocalite = :idLocalite, depuis = :depuis)
                WHERE id = :id"
            );

            // Liaison des paramètres
            $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
            $stmt->bindParam(':dateNaissance', $this->dateNaissance);
            $stmt->bindParam(':idLocalite', $this->idLocalite);
            $stmt->bindParam(':depuis', $this->depuis);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            // Execution de la requête
            $stmt->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            throw new Exception("Erreur lors de l'insertion : " . $e->getMessage());
        }
    }

    static public function delete(int $id)
    {
        try {
            $db = PDOSingleton::getInstance();

            // Supprimer la personne
            $stmt = $db->prepare("DELETE FROM Personne WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            throw new Exception("Erreur lors de l'insertion : " . $e->getMessage());
        }
    }
}
