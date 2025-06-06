<?php

namespace Models;

use Models\PDOSingleton;
use Interfaces\ICRUD;
use DateTime;
use Exception;
use PDO;
use PDOException;

class Pratiquer
{
    static public function makeRelation(int $idPersonne, int $idActivite)
    {
        try {
            $db = PDOSingleton::getInstance();

            // Requête SQL avec des paramètres nommés pour éviter les injections SQL
            $stmt = $db->prepare("INSERT INTO Pratique (`idPersonne`, `idActivite`) VALUES (:idPersonne, :idActivite)");

            // Liaison des paramètres
            $stmt->bindParam(':idPersonne', $idPersonne, PDO::PARAM_INT);
            $stmt->bindParam(':idActivite', $idActivite, PDO::PARAM_INT);

            // Execution de la requête
            $stmt->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            throw new Exception("Erreur lors de l'insertion : " . $e->getMessage());
        }
    }

    static public function delete(int $idpersonne){
        try {
            $db = PDOSingleton::getInstance();

            // Supprimer les relations
            $stmt = $db->prepare("DELETE FROM Pratique WHERE idPersonne = :idPersonne");
            $stmt->bindParam(':idPersonne', $idpersonne, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            throw new Exception("Erreur lors de l'insertion : " . $e->getMessage());
        }
    }
}
